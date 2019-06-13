<?php
namespace Helpers;

class Functions
{
    /**
     * @name判断是否为手机号
     * @param $mobile
     * @return bool
     */
    public static function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * 生产唯一通行编码
     * @param string $prefix
     * @return string
     */
    public static function uuids($prefix=''){
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }
    /**
     * 判断是否是json
     */
    public static function is_json($string) {
        @json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 使用curl模拟get
     * @param $url
     * @return mixed
     */
    public static function curlGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * curl post
     * @param $url
     * @param $data
     * @return mixed
     */
    public static function curlPost($url,$data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        }

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
    /**
     * @name 获取消息主体
     * @param string $msg
     * @param array $arr
     * @param int $code
     * @return array
     */
    public static function getMessageBody($msg='系统错误',$arr=[],$code=0)
    {
        $data = array();
        $data['msg']  = "{$msg}";
        if(empty($arr)){
            $data['data'] = (object)$arr;
        }else{
            $data['data'] = $arr;
        }

        $data['status'] = $code;
        return $data;
    }
    /**
     * 判断是否是时间格式
     * @param $dateTime
     * @return bool
     */
    public static function isDateTime($dateTime){
        $ret = strtotime($dateTime);
        return $ret !== FALSE && $ret != -1;
    }
}