<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/28
 * Time: 14:07
 */

namespace Services\Test;

use Services\ServicesInterface;

class CheckTest2 implements ServicesInterface
{
    public function beforeAction($arr){
        echo 'beforeAction2222<br>';
    }

    public function behindAction($arr){
        echo 'behindAction22222<br>';
    }
}