<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Services;

interface ServicesInterface
{
    public function beforeAction($arr);

    public function behindAction($arr);
}

class ServicesInterfaceExtension implements ServicesInterface
{
    // 扩展数组
    private $_extensionArray = [];

    public function addExtension(ServicesInterface $extension)
    {
        $this->_extensionArray[] = $extension;
    }

    public function beforeAction($arr)
    {
        foreach ($this->_extensionArray as $extension) {
            $extension->beforeAction($arr);
        }
    }

    public function behindAction($arr)
    {
        foreach ($this->_extensionArray as $extension) {
            $extension->behindAction($arr);
        }
    }
}
