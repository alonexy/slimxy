<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/28
 * Time: 15:07
 */
namespace Services\Test;

class TestFactory {
    public static function ExtensionInit() {
        $exts = new \Services\ServicesInterfaceExtension();
        // 添加扩展
        $exts->addExtension(new \Services\Test\CheckTest());
        $exts->addExtension(new \Services\Test\CheckTest2());
        $exts->addExtension(new \Services\Test\CheckTest3());
        $exts->addExtension(new \Services\Test\CheckTest4());
        return $exts;
    }
}