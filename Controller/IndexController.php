<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Controller;

class IndexController extends BaseController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function Index($request, $response, $args)
    {
        $name = $request->getQueryParam('name', 'Slimxy');
        //testsss
        return $this->view->render($response, 'weclome.php', [
            'name' => $name,
        ]);
    }
}
