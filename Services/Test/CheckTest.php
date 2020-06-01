<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Services\Test;

use Services\ServicesInterface;

/**
 * @internal
 * @coversNothing
 */
class CheckTest implements ServicesInterface
{
    public function beforeAction($arr)
    {
//        echo 'sdsdsdsdsdsd<br>';
    }

    public function behindAction($arr)
    {
//        echo 'behindAction<br>';
    }
}
