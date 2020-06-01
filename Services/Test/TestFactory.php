<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Services\Test;

class TestFactory
{
    public static function ExtensionInit()
    {
        $exts = new \Services\ServicesInterfaceExtension();
        // 添加扩展
        $exts->addExtension(new \Services\Test\CheckTest());
        return $exts;
    }
}
