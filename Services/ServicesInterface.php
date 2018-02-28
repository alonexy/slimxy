<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/28
 * Time: 14:08
 */
namespace Services;

interface ServicesInterface {
    public function beforeAction($arr);

    public function behindAction($arr);
};

class ServicesInterfaceExtension implements ServicesInterface {
    // 扩展数组
    private $_extensionArray = array();

    public function addExtension(ServicesInterface $extension) {
        $this->_extensionArray []= $extension;
    }
    public function beforeAction($arr) {
        foreach ($this->_extensionArray as $extension) {
            $extension->beforeAction($arr);
        }
    }
    public function behindAction($arr) {
        foreach ($this->_extensionArray as $extension) {
            $extension->behindAction($arr);
        }
    }
};