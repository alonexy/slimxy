<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/24
 * Time: 17:42
 */

namespace Controller;

use Helpers\Functions;
use PHPMailer\PHPMailer\PHPMailer;
use Services\Test\TestFactory;

class HomeController extends BaseController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function Index($request, $response, $args)
    {
        $name = $request->getQueryParam('name','Slimxy');
        return $this->view->render($response, 'weclome.php', [
            'name' => $name
        ]);
    }

    /**
     * 获取所有安居客临沂地区分布
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function get_house($request, $response, $args)
    {
        $a_id = $request->getQueryParam('aid',0);
        $url = 'https://api.fang.anjuke.com/web/loupan/mapNewlist/?city_id=120&zoom=11&swlng=118.058832&swlat=34.820067&nelng=118.668242&nelat=35.400235&order=rank&order_type=asc&region_id='.$a_id.'&sub_region_id=0&house_type=0&property_type=0&price_id=0&bunget_id=0&status_sale=3%2C4%2C6%2C7&price_title=%E5%85%A8%E9%83%A8&keywords=&page=1&page_size=20&timestamp=1&_='.time();
        $arr = Functions::curlGet($url);
        if(Functions::is_json($arr)){
            $res = \GuzzleHttp\json_decode($arr);
            return $response->withJson(Functions::getMessageBody('SUC',$res));
        }
        return $response->withJson(Functions::getMessageBody('Fail'));
    }

}