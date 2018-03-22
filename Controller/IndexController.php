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

class IndexController extends BaseController
{
    public function Index($request, $response, $args)
    {
        $name = $request->getQueryParam('name','Slimxy');
        return $this->view->render($response, 'weclome.php', [
            'name' => $name
        ]);
    }
}