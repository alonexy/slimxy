<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/24
 * Time: 17:42
 */

namespace Controller;

use PHPMailer\PHPMailer\PHPMailer;
use Services\Test\TestFactory;

class DomainController extends BaseController
{
    public function curlGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function MonitorDomain($request, $response){
        $name = $request->getQueryParam('name','lywb.com');
        $url = 'https://whois.bj.baidubce.com/whois?ie=utf-8&oe=utf-8&format=javascript&domain='.$name.'&_='.time();
        $json = $this->curlGet($url);
        $data = json_decode($json,1);
        if(isset($data['data']['status'])){
            if($data['data']['status'] == 'UNREGISTERED'){
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'link_xy@qq.com';                 // SMTP username
                    $mail->Password = 'bisctchumvxhbgjj';                           // SMTP password
                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('455367282@qq.com', 'ALonexy');    // Add a recipient
                    $mail->addAddress('961610358@qq.com');

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = '域名监控报告';
                    $mail->Body    =   $name.' 未注册 https://wanwang.aliyun.com/domain/searchresult/?keyword='.$name.'  == Detail:'.$json;

                    $mail->send();
                    echo "Ok \n";
                } catch (\Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }else{
                echo "Wait!!!\n";
            }
        }
        print_r($json);
    }
}