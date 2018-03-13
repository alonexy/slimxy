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

class TestController extends BaseController
{
    public function Index($request, $response, $args)
    {
        $ext = TestFactory::ExtensionInit();
        $ext->beforeAction($request);
        $selectStatement = $this->db->select()
            ->from('users')
            ->where('id', '=', 3);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();
        //print_r($data);
        $ext->behindAction($data);
        if($data){
            return $response->withJson(['list'=>$data,'msg'=>'suc']);
        }
        return $response->withJson(['list'=>$data,'msg'=>'fail']);
    }
    public function TestView($request, $response){

        $name = $request->getQueryParam('name','hi');
        return $this->view->render($response, 'test.php', [
            'name' => $name
        ]);
    }
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
    public function MonitorDomain(){
        $url = 'https://whois.bj.baidubce.com/whois?ie=utf-8&oe=utf-8&format=javascript&domain=lywb.com&_='.time();
        $json = $this->curlGet($url);
        $data = json_decode($json,1);
        if(isset($data['status']) && ($data['status'] == 'UNREGISTERED')){
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.qq.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'link_xy@qq.com';                 // SMTP username
                $mail->Password = 'xxx';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('455367282@qq.com', 'ALonexy');    // Add a recipient
                $mail->addAddress('961610358@qq.com');

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = '域名监控报告';
                $mail->Body    =  'www.lywb.com 已到期快去注册';

                $mail->send();
                echo 'Message has been sent';
            } catch (\Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        }

    }
}