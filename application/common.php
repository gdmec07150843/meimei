<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;
use think\Db;
use think\Url;
use think\Route;
use think\Loader;
use think\Request;
use think\Session;
use app\api\library\Http\HttpRequest;


	/**
	 * 获取当前登录的管理员ID
	 * @return int
	 */
	function cmf_get_current_admin_id()
	{
	    return Session::get('admin_id');
	}
	/**
	 * 获取文件扩展名
	 * @param string $filename 文件名
	 * @return string 文件扩展名
	 */
	function cmf_get_file_extension($filename)
	{
	    $pathinfo = pathinfo($filename);
	    return strtolower($pathinfo['extension']);
	}

	/**
     * 获取系统配置，通用
     * @param string $key 配置键值,都小写
     * @return array
     */
    function cmf_get_option($key)
    {
        if (!is_string($key) || empty($key)) {
            return [];
        }

        static $cmfGetOption;

        if (empty($cmfGetOption)) {
            $cmfGetOption = [];
        } else {
            if (!empty($cmfGetOption[$key])) {
                return $cmfGetOption[$key];
            }
        }

        $optionValue = cache('cmf_options_' . $key);

        if (empty($optionValue)) {
            $optionValue = Db::name('option')->where('option_name', $key)->value('option_value');
            if (!empty($optionValue)) {
                $optionValue = json_decode($optionValue, true);

                cache('cmf_options_' . $key, $optionValue);
            }
        }

        $cmfGetOption[$key] = $optionValue;

        return $optionValue;
    }

    /**
     * 获取上传配置
     */
    function cmf_get_upload_setting()
    {
        $uploadSetting = cmf_get_option('upload_setting');
        if (empty($uploadSetting) || empty($uploadSetting['file_types'])) {
            $uploadSetting = [
                'file_types' => [
                    'image' => [
                        'upload_max_filesize' => '10240',//单位KB
                        'extensions'          => 'jpg,jpeg,png,gif,bmp4'
                    ],
                    'video' => [
                        'upload_max_filesize' => '10240',
                        'extensions'          => 'mp4,avi,wmv,rm,rmvb,mkv'
                    ],
                    'audio' => [
                        'upload_max_filesize' => '10240',
                        'extensions'          => 'mp3,wma,wav'
                    ],
                    'file'  => [
                        'upload_max_filesize' => '10240',
                        'extensions'          => 'txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar'
                    ]
                ],
                'chunk_size' => 512,//单位KB
                'max_files'  => 20 //最大同时上传文件数
            ];
        }

        if (empty($uploadSetting['upload_max_filesize'])) {
            $uploadMaxFileSizeSetting = [];
            foreach ($uploadSetting['file_types'] as $setting) {
                $extensions = explode(',', trim($setting['extensions']));
                if (!empty($extensions)) {
                    $uploadMaxFileSize = intval($setting['upload_max_filesize']) * 1024;//转化成B
                    foreach ($extensions as $ext) {
                        if (!isset($uploadMaxFileSizeSetting[$ext]) || $uploadMaxFileSize > $uploadMaxFileSizeSetting[$ext] * 1024) {
                            $uploadMaxFileSizeSetting[$ext] = $uploadMaxFileSize;
                        }
                    }
                }
            }

            $uploadSetting['upload_max_filesize'] = $uploadMaxFileSizeSetting;
        }

        return $uploadSetting;
    }

    /**
	 * 获取网站根目录
	 * @return string 网站根目录
	 */
	function cmf_get_root()
	{
	    $request = Request::instance();
	    $root    = $request->root();
	    $root    = str_replace('/index.php', '', $root);
	    if (defined('APP_NAMESPACE') && APP_NAMESPACE == 'api') {
	        $root = preg_replace('/\/api$/', '', $root);
	        $root = rtrim($root, '/');
	    }

	    return $root;
	}

    /**
     * 获取图片预览地址
     * @param string $file
     * @param string $style
     * @return mixed
     */
    function getPreviewUrl($file, $style = '')
    {
        return getWebRoot() . '/upload/' . $file;
    }

     /**
     * 获取域名
     */
    function getWebRoot()
    {
        return cmf_get_domain() . cmf_get_root();

    }

    /**
     * 返回带协议的域名
     */
    function cmf_get_domain()
    {
        $request = Request::instance();
        return $request->domain();
    }

    /**
     * 获取文件相对路径
     * @param string $assetUrl 文件的URL
     * @return string
     */
    function cmf_asset_relative_url($assetUrl)
    {
        if (strpos($assetUrl, "http") === 0) {
            return $assetUrl;
        } else {
            return str_replace('/upload/', '', $assetUrl);
        }
    }


    /**
    *  将数组转为json
    * @param int $code
    * @param string $msg
    * @param string $data
    * @param string $url
    * @param string $url
    */
    function returnJson($code = 0, $msg='',$data = '', $url = '')
    {
        return json(['code' => $code,'msg' => $msg, 'data' => $data, 'url' => $url]);
        exit;
    }


    /**
    *   base64转为图片(多图)
    *   @param string $pic
    */
    function base64upload($pic)
    {
        $lists = explode("`", $pic);
        $list = [];
        $arr = [];
        foreach ($lists as $key=>$val) {
            if (strstr($val,",")){
                $list[$key] = explode(',',$val);

                $arr[$key]['url'] = $list[$key][1];
            }
        }

        $data['photos'] = [];
        $res = [];
        foreach($arr as $k=>$v){

            //图片名字
            $imageName = "25220_".date("His",time()).rand(1111,9999).'.jpg';
            $up_dir = 'upload/';
            $path = $up_dir.date("Ymd",time());

            if (!is_dir($path)){ //判断目录是否存在 不存在就创建
                mkdir($path,0777,true);
            }

            $imageSrc =  $path."/". $imageName;  //图片名字

            $list = file_put_contents($imageSrc, base64_decode($v['url'])); //返回的是字节数

            if (strstr($imageSrc,".")){
                $res[$k] = explode('.',$imageSrc);
                $imageUrl = '/'.$res[$k][0].'.'.$res[$k][1];

            }

            $photoUrl = cmf_asset_relative_url($imageUrl);

            array_push($data['photos'], ["url" =>'/upload/'.$photoUrl]);
        }

        return $data;
    }
	/**
    *   base64转为图片(单图)
    *   @param string $pic
    */
	function base64uploadone($image)
    {
        if (strstr($image,",")){
            $image = explode(',',$image);
            $image = $image[1];
        }else{
			return $image;
		}

        $imageName = "25220_".date("His",time()).rand(1111,9999).'.jpg';

        $up_dir = 'upload/';
        $path = $up_dir.date("Ymd",time());

        if (!is_dir($path)){ //判断目录是否存在 不存在就创建
            mkdir($path,0777,true);
        }

        $imageSrc =  $path."/". $imageName;  //图片名字

        $list = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数

        if (strstr($imageSrc,".")){
            $imageUrl = explode('.',$imageSrc);
            $imageUrl = $imageUrl[0].'.'.$imageUrl[1];
        }

		return '/'.$imageUrl;
    }

    /**
    *   获取订单号
    */
    function getOrderCode()
    {
        $ordercode = date('Ymd') . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        return $ordercode;
    }

	/**
    *   获取任务编号
    */
    function getTaskCode()
    {
        $ordercode = date('Ymd') . str_pad(mt_rand(1, 9999), 8, '0', STR_PAD_LEFT);
        return $ordercode;
    }

	/**
	 * 获取随机数
	 */
	function getRandomString($len, $chars=null)
	{
	    if (is_null($chars)){
	        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    }
	    mt_srand(10000000*(double)microtime());
	    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
	        $str .= $chars[mt_rand(0, $lc)];
	    }
	    return $str;
	}

	/**
	 * 获取随机数
	 */
	function getRandom($len, $chars=null)
	{
	    if (is_null($chars)){
	        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    }
	    mt_srand(10000000*(double)microtime());
	    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
	        $str .= $chars[mt_rand(0, $lc)];
	    }
	    return $str;
	}

    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    function xml_to_data($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }

    /**
     * 输出xml字符
     * @param   $params     参数名称
     * return   string      返回组装的xml
     **/
    function data_to_xml( $params ){
        if(!is_array($params)|| count($params) <= 0)
        {
            return false;
        }
        $xml = "<xml>";
        foreach ($params as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /* 获取当月 */
    function getcurrent()
    {
        $cur = date('Y-m',time());//当天年月
        $cur_y = date('Y',time());//当天年份
        $cur_m = date('m',time());//当天月份
        $cur_f = $cur . '-1';//本月首日
        $first = strtotime($cur_f);//时间戳最小值，本月第一天时间戳
        //下月首日
        if($cur_m>=12){
            $cur_n = ($cur_y+1) . '-1-1';
        }else{
            $cur_n = $cur_y . '-' . ($cur_m+1) . '-1';
        }

        $last = strtotime($cur_n);//时间戳最大值，下个月第一天时间戳

        return ['first'=>$first,'last'=>$last];
    }

    /* 获取12个月的数据 */
    function getmonth()
    {
        $list = [];
        for($i=1;$i<=12;$i++){
            $list[] = $i;
        }
        return $list;
    }

	/* 天数(31天) */
	function getday()
	{
		$list = [];
		for($i=1;$i<=31;$i++){
			$list[] = $i;
		}
		return $list;
	}

    /* 获取当前年份的前10年和后10年 */
    function getyears()
    {
        /* 当前年份 */
        $currentYear = date('Y');

        /* 前10年 */
        $pastyears = array();
        for ($i=0; $i<10; $i++)
        {
            $pastyears[$i] = $currentYear - $i;
        }

        foreach($pastyears as $key=>$val){
            $rating[$key] = $val;
        }

        array_multisort($rating, SORT_ASC, $pastyears);

        foreach ($pastyears as $k => $v) {

        }

        return $pastyears;
    }

     /* 获取指定年月的第一天和最后一天的时间戳 */
    function getcur($data)
    {
       $year = $data['year'];  //选中年份
        $month = $data['month'];//选中月份
        $times = $year.'-'.$month; //选中年月
        $monthfirst = $times . '-1';//本月首日
        $first = strtotime($monthfirst);//时间戳最小值，本月第一天时间戳
        if($month>=12){
            $n = ($year+1) . '-1-1';
        }else{
            $n = $year . '-' . ($month+1) . '-1';
        }

        $last = strtotime($n);//时间戳最大值，下个月第一天时间戳
        return ['first'=>$first,'last'=>$last];
    }

    /*根据生日获取当前年龄*/
    function birthday($birthday){ 
         $age = strtotime($birthday); 
         if($age === false){ 
          return false; 
         } 
         list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
         $now = strtotime("now"); 
         list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
         $age = $y2 - $y1; 
         if((int)($m2.$d2) < (int)($m1.$d1)) 
          $age -= 1; 
         return $age; 
    } 

    function sign($name)
    {
        new \wxwebpay\WxPay();
        return createSign($name);
    }
    function getPrepayId($tpWxPayDto)
    {
        $appid = appid;
        $orderId = $tpWxPayDto->getOrderId();
        $totalFee = $tpWxPayDto->getTotalFee();
        $spbillCreateIp = $tpWxPayDto->getSpbillCreateIp();
        $notifyUrl = notifyurl1;
        $tradeType = "APP";
        $mchId = partner;
        $nonceStr = getNonceStr(32);
        $body = $tpWxPayDto->getBody();
        $outTradeNo = $orderId;

        // var_export($tpWxPayDto);
        $packageParams = Array("appid" => $appid,
            "mch_id" => $mchId,
            "nonce_str" => $nonceStr,
            "body" => $body,
            "out_trade_no" => $outTradeNo,
            "total_fee" => $totalFee,
            "spbill_create_ip" => $spbillCreateIp,
            "notify_url" => $notifyUrl,
            "trade_type" => $tradeType);

        $sign = createSign($packageParams);
        $xml = "<xml>"
            . "<appid>$appid</appid>"
            . "<mch_id>$mchId</mch_id>"
            . "<nonce_str>$nonceStr</nonce_str>"
            . "<sign>$sign</sign>"
            . "<body><![CDATA[$body]]></body>"
            . "<out_trade_no>$outTradeNo</out_trade_no>"
            . "<total_fee>$totalFee</total_fee>"
            . "<spbill_create_ip>$spbillCreateIp</spbill_create_ip>"
            . "<notify_url>$notifyUrl</notify_url>"
            . "<trade_type>$tradeType</trade_type>"
            . "</xml>";

        $response = HttpRequest::send(HttpRequest::POST, createOrderURL, $xml);
        $body = $response->body;
        // $response = "<xml><return_code><![CDATA[SUCCESS]]></return_code>
        // <return_msg><![CDATA[OK]]></return_msg>
        // <appid><![CDATA[wx3edca490fbef3ddb]]></appid>
        // <mch_id><![CDATA[1377961402]]></mch_id>
        // <nonce_str><![CDATA[XK1hullX7TGogBET]]></nonce_str>
        // <sign><![CDATA[48FAA6D19D874B6CBE256A6F4225F51F]]></sign>
        // <result_code><![CDATA[SUCCESS]]></result_code>
        // <prepay_id><![CDATA[wx20160827164328733bad1aa50845829429]]></prepay_id>
        // <trade_type><![CDATA[APP]]></trade_type>
        // </xml>";
        $xml = simplexml_load_string($body, null, LIBXML_NOCDATA);
        return (string)$xml->prepay_id;
    }

    function getResult($prepayId)
    {
        $appId = appid;
        $mchId = partner;
        $package = "Sign=WXPay";
        $nonceStr = getNonceStr(32);
        $timestamp = time();
        $packageParams = array("appid" => $appId,
            "noncestr" => $nonceStr,
            "package" => $package,
            "partnerid" => $mchId,
            "prepayid" => $prepayId,
            "timestamp" => $timestamp);
        $sign = createSign($packageParams);
        $packageParams["sign"] = $sign;
        return json_encode($packageParams);
    }

    function createSign($packageParams)
    {
        ksort($packageParams);
        $sign = "";
        foreach ($packageParams as $k => $v) {
            if (!("sign" == $k))
                // echo "$k => $v<br>";
                if (isset($v) && !empty($v) && !("sign" == $k) && !("key" == $k)) {
                    $sign .= "$k=$v&";
                }
        }
        $sign .= "key=" . partnerkey;
        return strtoupper(MD5($sign));
    }
    function getNonceStr($len)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $lc = strlen($chars) - 1;
        $str = "";
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }
	function get_client_ip($type = 0) {
	    $type       =  $type ? 1 : 0;
	    $ip         =   'unknown';

	    if ($ip !== 'unknown') return $ip[$type];

	    if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
	        $ip=$_SERVER['HTTP_X_REAL_IP'];
	    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
	        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
	    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
	        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	        $pos    =   array_search('unknown',$arr);
	        if(false !== $pos) unset($arr[$pos]);
	        $ip     =   trim($arr[0]);
	    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
	        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
	    }else{
	        $ip=$_SERVER['REMOTE_ADDR'];
	    }

	    // IP地址合法验证
	    $long = sprintf("%u",ip2long($ip));
	    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);

	    return $ip[$type];
    }

	/**
	 * 获取文件的名称
	 */
	function getfilename($file)
	{
		$url = substr($file,strripos($file,"/")+1);
		return $url;
	}

    /*
    *上传多个图片或者多个视频
    *save_path string  储存路径
    *name string postname
     */
    function uploads_all($name,$save_path='public/upload/video/',$ext='mp3,mp4',$size = 100971520)
    {
        $pic = request()->file($name);
        if(empty($pic)){
            return false;
        }

        $data=[];
        foreach ($pic as $key => $file) {
            $path = $save_path.date('Y').'/'.date('m-d').'/';
            $root_path = ROOT_PATH.$path;
            if(!file_exists($root_path))
            {
                @mkdir($root_path, 0777, true);
            }

            $pic_info = $file->validate(['size'=>$size,'ext'=>$ext])->move($root_path );
            if($pic_info){
                $img_path = $path.$pic_info->getSaveName();
                $data[$key]['status'] = 200;
                $data[$key]['msg'] = '上传成功';
                $data[$key]['data'] = substr($img_path,6);
            }else{
                $data['status'] = 201;
                $data[$key]['msg'] = '上传失败,'.$file->getError();
                $data[$key]['data'] = [];

            }
        }
        return $data;
    }

	/**
	 * 去除字符串前后的符号
	 * @param $string 字符串
	 * @param $a  符号
	 */
	function removesymbol($string,$a){
		$string = trim($string,$a);
		return $string;
	}


    //生成token
    function getToken($uid){
        $key = "Elephant";  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token = [
            "iss"=>"",  //签发者 可以为空
            "aud"=>"", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time(), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time()+604800, //token 过期时间
            "uid" => $uid //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];
        $jwt = JWT::encode($token,$key,"HS256"); //根据参数生成了 token
        return json([
            "token"=>$jwt
        ]);
    }

    //解析token
    function check($token){
        $key = "Elephant";  //上一个方法中的 $key 本应该配置在 config文件中的
        $info = JWT::decode($token,$key,["HS256"]); //解密jwt
        return json($info);
    }

