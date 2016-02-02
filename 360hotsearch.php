<?php
 	
$appkey = "df1eb2fdeb5fe36f24402770b8b47467";
$url = "http://op.juhe.cn/onebox/news/words";
$params = array(
      "key" => $appkey,//应用APPKEY(应用详细页查询)
      "dtype" => "",//返回数据的格式,xml或json，默认json
);
$paramstring = http_build_query($params);
$content = juhecurl($url,$paramstring);
$result = json_decode($content,true);
if($result){
    if($result['error_code']=='0'){
        $hotwords=array_slice($result['result'],0,12);
	echo '<h5> &nbsp &nbsp现在被搜索的热词 </h5>'; 
	echo '<div id="back">';
	echo '<style type="text/css">';
	echo '#back{background:#546E7A;}';
	echo '#tagsList {position:relative; width:450px; height:400px; margin: 20px auto 0;  }';
       echo  '#tagsList a {position:absolute; top:0px; left:0px; font-family: Microsoft YaHei; color:#fff; font-weight:bold; text-decoration:none; padding: 3px 6px; }';
       echo '#tagsList a:hover { color:#FF0000; letter-spacing:2px;}';
	echo '</style>';
        echo '<div id="tagsList">';
	foreach( $hotwords as $hot){
	echo '<a  href="//www.baidu.com/s?wd='.$hot.'" >'.$hot.'</a>';
    }
       echo '</div>';
       echo '</div>';
    }else{
        echo $result['error_code'].":".$result['reason'];
    }
}else{
    echo "请求失败";
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


