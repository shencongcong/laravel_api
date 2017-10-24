<?php

// 以POST方式提交数据
/**
 * @param $url
 * @param $param
 * @param bool $is_file
 * @param bool $return_array
 * @return mixed
 */
function post_data($url, $param, $is_file = false, $return_array = true) {
    set_time_limit ( 0 );
    if (! $is_file && is_array ( $param )) {
        $param = JSON ( $param );
    }
    if ($is_file) {
        $header [] = "content-type: multipart/form-data; charset=UTF-8";
    } else {
        $header [] = "content-type: application/json; charset=UTF-8";
    }
    $ch = curl_init ();
    if (class_exists ( '/CURLFile' )) { // php5.5跟php5.6中的CURLOPT_SAFE_UPLOAD的默认值不同
        curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, true );
    } else {
        if (defined ( 'CURLOPT_SAFE_UPLOAD' )) {
            curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, false );
        }
    }
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
    curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
    curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    $res = curl_exec ( $ch );

    curl_close ( $ch );

    $return_array && $res = json_decode ( $res, true );

    return $res;
}

function JSON($array) {
    arrayRecursive ( $array, 'urlencode', true );
    $json = json_encode ( $array );
    return urldecode ( $json );
}

function arrayRecursive(&$array, $function, $apply_to_keys_also = false) {
    static $recursive_counter = 0;
    if (++ $recursive_counter > 1000) {
        die ( 'possible deep recursion attack' );
    }
    foreach ( $array as $key => $value ) {
        if (is_array ( $value )) {
            arrayRecursive ( $array [$key], $function, $apply_to_keys_also );
        } else {
            $array [$key] = $function ( $value );
        }

        if ($apply_to_keys_also && is_string ( $key )) {
            $new_key = $function ( $key );
            if ($new_key != $key) {
                $array [$new_key] = $array [$key];
                unset ( $array [$key] );
            }
        }
    }
    $recursive_counter --;
}

/*
 * 签名
 * */
function signature($open_id,$string,$merchant_id)
{
    $str = $open_id.$string.$merchant_id;
    //进行加密
    $signature = sha1($str);
    $signature = md5($signature);
    //转换成大写
    $signature = strtoupper($signature);
    return $signature;
}


function token($data,$time_stamp,$string)
{ 
    $str = strtoupper($data.$time_stamp.$string);
    //进行加密
    $signature = md5($str);
    return $signature;
}

/**
 * @desc 根据两点间的经纬度计算距离
 * @param float $lat 纬度值
 * @param float $lng 经度值
 */
function getDistance($lng1, $lat1, $lng2, $lat2) {
    // 将角度转为狐度
    $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);
    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
    return round($s);
}


/**
 * 生成预约号
 * @return string
 */
function create_appoint_num(){
    return 'y'.date('YmdHis') . substr(uniqid(), 4);
}


/*
 * 获取产品的预约时间
 * */
function sever_time($sever_num){
    $sever_time = '';
    switch ($sever_num){
        case 1:
            $sever_time = '0.5小时';
            break;
        case 2:
            $sever_time = '1小时';
            break;
        case 3:
            $sever_time = '1.5小时';
            break;
        case 4:
            $sever_time = '2小时';
            break;
        case 5:
            $sever_time = '2.5小时';
            break;
        case 6:
            $sever_time = '3小时';
            break;
        case 7:
            $sever_time = '3.5小时';
            break;
        case 8:
            $sever_time = '4小时';
            break;
        case 9:
            $sever_time = '4.5小时';
            break;
        case 10:
            $sever_time = '5小时';
            break;
        case 11:
            $sever_time = '5.5小时';
            break;
        case 12:
            $sever_time = '6小时';
            break;
    }
    return $sever_time;
}

// 预约成功通知会员模板页面
function appoint_ok_notice_member($member_name,$time_date,$time_hour_text,$goods_two_text,$shop_name,$shop_tel,$waiter_name,$appoint_server_time_text){
    return array(
        'first' =>array('value'=>$member_name.' 您预约的服务师:'.$waiter_name),
        'keyword1'=>array('value'=>$shop_name),
        'keyword2'=>array('value'=>$goods_two_text),
        'keyword3'=>array('value'=>$time_date.' '.$time_hour_text.' (服务时长'.$appoint_server_time_text.')',"color"=>"#173177"),
        'keyword4'=>array('value'=>$shop_tel),
        'remark'=>array('value'=>$shop_name.'感谢您的光临'),
    );
}

//预约成功通知服务师
function appoint_ok_notice_waiter($member_name,$time_date,$time_hour_text,$goods_two_text,$member_tel,$remark,$good_price){
    return      array(
        'first' =>array('value'=>'您有一条新的预约订单'),
        'keyword1'=>array('value'=>$time_date.' '.$time_hour_text,"color"=>"#173177"),
        'keyword2'=>array('value'=>$goods_two_text),
        'keyword3'=>array('value'=>$good_price.'元'),
        'keyword4'=>array('value'=>$member_name),
        'keyword5'=>array('value'=>$member_tel),
        'remark'=>array('value'=>'备注信息:  '.$remark,"color"=>"#173177"),
    );
}

//提前10min提醒服务师
function appoint_ok_notice_hair_again($member_name,$time_date,$time_hour_text,$member_tel,$hair_name){

    return      array(
        'first' =>array('value'=>'您好，您有一个预约即将到期，请及时联系会员'),
        'keyword1'=>array('value'=>$member_name),
        'keyword2'=>array('value'=>$hair_name),
        'keyword3'=>array('value'=>$time_date.' '.$time_hour_text,"color"=>"#173177"),
        'remark'=>array('value'=>'会员联系方式：'.$member_tel),
    );
}

//提前30min提醒会员
function appoint_ok_notice_member_again($member_name,$time_date,$time_hour_text,$shop_tel,$hair_name,$shop_name){

    return      array(
        'first' =>array('value'=>'您好，您预约的服务时间即将到期。'),
        'keyword1'=>array('value'=>$member_name),
        'keyword2'=>array('value'=>$hair_name),
        'keyword3'=>array('value'=>$time_date.' '.$time_hour_text,"color"=>"#173177"),
        'remark'=>array('value'=>'请您提前10分钟到店。如有疑问，请致电'.$shop_tel.'【'.$shop_name.'】'),
    );
}


//取消预约通知会员
function appoint_cancel_notice_member($member_name,$time_date,$time_hour_text,$goods_two_text,$reason,$shop_name){

    return      array(
        'first' =>array('value'=>$member_name.',您的预约已成功取消'),
        'keyword1'=>array('value'=>$goods_two_text),
        'keyword2'=>array('value'=>$time_date.' '.$time_hour_text,"color"=>"#173177"),
        'keyword3'=>array('value'=>$reason),
        'remark'=>array('value'=>$shop_name.'感谢您的支持，并期待下次您的光临',"color"=>"#173177"),
    );
}

//取消预约通知服务师
function appoint_cancel_notice_hair($member_name,$time_date,$time_hour_text,$goods_two_text,$reason){

    return      array(
        'first' =>array('value'=>'会员:'.$member_name.',已取消对您的预约'),
        'keyword1'=>array('value'=>$goods_two_text),
        'keyword2'=>array('value'=>$time_date.' '.$time_hour_text,"color"=>"#173177"),
        'keyword3'=>array('value'=>$reason),
    );

}


?>