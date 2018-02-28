<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/28
 * Time: 14:07
 */

namespace Services\Test;

use Services\ServicesInterface;

class CheckTest3 implements ServicesInterface
{
    public function beforeAction($arr){
        echo 'beforeAction3333<br>';
    }

    public function behindAction($arr){
        echo 'behindAction3333<br>';
    }
}