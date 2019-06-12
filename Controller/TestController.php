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
    public function AddJob($request, $response, $args){
        $redisConfs = $this->configs->get('redis','job');
        $dsn = "redis://auth:{$redisConfs['auth']}@{$redisConfs['host']}:{$redisConfs['port']}";
        \Resque::setBackend($dsn,$redisConfs['db_set']);
        $args = array(
            'name' => 'Chris'
        );

        $jobID =  \Resque::enqueue('default',\Jobs\Test_Job::class, $args,true);
        if(empty($jobID)){
            throw new \Exception('Job 投递失败',1002);
        }
        $this->container->logger->info('jobID==>',[$jobID]);

        return $response->withJson(['job_id'=>$jobID,'msg'=>'suc','redisConfs'=>$redisConfs]);
    }
    public function TestView($request, $response){
        $name = $request->getQueryParam('name','hi');
        return $this->view->render($response, 'test.php', [
            'name' => $name
        ]);
    }
}