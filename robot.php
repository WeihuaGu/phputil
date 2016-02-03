<?php
class robot {
//配置您申请的appkey
var $appkey = "2a79068e5acd901e1c813b8ad734f745";
var $url = "http://op.juhe.cn/robot/index";
var $info="";
var $userid="";
var $params;

function __construct($info){
$this->info=$info;

}

function quest(){

$params = array(
      "key" => $this->appkey,//您申请到的本接口专用的APPKEY
      "info" => $this->info,//要发送给机器人的内容，不要超过30个字符
      "dtype" => "",//返回的数据的格式，json或xml，默认为json
      "loc" => "",//地点，如北京中关村
      "lon" => "",//经度，东经116.234632（小数点后保留6位），需要写为116234632
      "lat" => "",//纬度，北纬40.234632（小数点后保留6位），需要写为40234632
      "userid" => "",//1~32位，此userid针对您自己的每一个用户，用于上下文的关联
);
$paramstring = http_build_query($params);
$content = $this->juhecurl($this->url,$paramstring);
$result = json_decode($content,true);
if($result){
    if($result['error_code']=='0'){
        return $result['result']['text'];
    }else{
        echo $result['error_code'].":".$result['reason'];
    }
}else{
    echo "请求失败";
}

}

function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
 
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}




}


