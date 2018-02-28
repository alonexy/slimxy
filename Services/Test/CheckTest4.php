<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/28
 * Time: 14:07
 */

namespace Services\Test;

use Services\ServicesInterface;

class CheckTest4 implements ServicesInterface
{
    public function beforeAction($arr){
        echo 'beforeAction444<br>';
    }

    public function behindAction($arr){
        echo 'behindAction444<br>';
    }
}