<?php

//defined('BASEPATH') or exit('No direct script access allowed');
define('LOG_PREFIX', '[PETS_LOG]');

/**
 * generate a token
 * @return string token
 */
function generate_token()
{
    $alphabets = range('a', 'z');
    $capticals = range('A', 'Z');
    $numbers = range('0', '9');
    $all = $alphabets + $capticals + $numbers;
    $token = '';
    for ($i = 0; $i < 15; $i++) {
        $token .= $all[rand(0, count($all) - 1)];
    }
    $token = time() . $token;
    return md5($token);
}

/**
 * 错误日志
 * $type 必填，日志类型（参考application/config/log_type.php）
 * $message 必填，日志记录内容
 */
function log_message_error($type, $message)
{
    log_message("error", LOG_PREFIX . $type . $message);
}

// 提示日志
// 参考函数log_message_error
function log_message_info($type, $message)
{
    log_message("info", LOG_PREFIX . $type . $message);
}

/**
 * 自定义的API输出函数，响应内容为JSON格式。
 * $output 必须，类型为数组，指定输出的内容。
 * $status_code 必须，此次响应的状态码。
 */
function api_output($output, $status_code)
{
    // 设置状态码信息以及响应内容格式
    $CI = &get_instance();
    $CI->output
        ->set_status_header($status_code)
        ->set_content_type('application/json', 'utf8');
    $CI->output
        ->set_output(json_encode($output))
        ->_display();
    exit;
}

// 将数组转换为由 键值和数值 组成的字符串
// $array 必须，待转换的数组
function my_array_to_str($array)
{
    ob_start();
    print_r($array);
    $result = ob_get_clean();
    $result = str_replace("\n", '', $result);
    return '[' . $result . ']';
}

/**
 * 将密码信息进行加密
 * 采用BLOWFISH加密方式
 * $origin_passwd 必需，为待加密密码
 * $cost 非必需，默认为7。设置循环次数为 2^$code
 */
function encrypt_passwd($origin_passwd, $cost = 7)
{
    // 生成一位32位的MD5加密随机字符串作为盐值
    $salt = random_string('md5');
    $param = '$' . implode('$', array(
        "2y", // 服务器上的php版本 >= PHP 5.3.7
        str_pad($cost, 2, "0", STR_PAD_LEFT),
        $salt,
    ));
    return crypt($origin_passwd, $param);
}

/**
 * $passwd 必需，待验证密码
 * $hash   必需，数据库中取出的hash值
 */
function validate_passwd($passwd, $hash)
{
    return crypt($passwd, $hash) == $hash;
}

// 利用MD5算法生成hash值，一般用作数据表中的主键值。
// 为了保证每次生成的值不一样，被hash的值应包含当前时间戳
function create_primary_key()
{
    $result = random_string('alnum', 8);
    $result = time() . $result;
    return do_hash($result, 'md5');
}

/**
 * send http request
 * @param  string $url  request url
 * @param  string $data
 * @return response
 */
function http_request($url, $data = '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // 需要获取的URL地址
    if (empty($data)) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // get
    } else {
        curl_setopt($ch, CURLOPT_POST, 1); //设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //POST数据
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/**
 * validate SMS code
 * @param  string $phone   phone number
 * @param  string $SMScode code
 * @param  string $zone    phone zone number, optional
 * @return bool
 */
function validate_SMS_code($phone, $SMScode, $zone = '86')
{
    $url = 'https://api.sms.mob.com/sms/vertify';
    $request = array(
        'appkey' => MOB_APPKEY,
        'phone' => $phone,
        'zone' => $zone,
        'code' => $SMScode,
    );
    $response = http_request($url, $request);
    if (isset($response['status']) && $response['status'] == HTTP_OK) {
        return true;
    } else {
        return false;
    }
}
