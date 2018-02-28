<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/24
 * Time: 17:42
 */

namespace Controller;

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
        return $response->write('end<br>');
//        if($data){
//            return $response->withJson(['list'=>$data,'msg'=>'suc']);
//        }
//        return $response->withJson(['list'=>$data,'msg'=>'fail']);
    }
    public function TestView($request, $response){

        $name = $request->getQueryParam('name','hi');
        return $this->view->render($response, 'test.php', [
            'name' => $name
        ]);
    }
}