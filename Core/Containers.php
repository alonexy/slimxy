<?php
namespace Core;


/**
 * 容器扩展 TODO 单例
 * Class Containers
 * @package Core
 */
Class Containers
{
    public $container;

    public function __construct()
    {
        $this->container = new \Slim\Container;
        $this->SetContainersSettings();
    }

    /**
     * 获取容器配置
     * @return \Slim\Container
     */
    public function GetContainers()
    {
// ======Log配置=====
        $this->container['logger'] = function ($c) {
            $logName      = date('Y-m-d');
            $logger       = new \Monolog\Logger($logName);
            $file_handler = new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/' . $logName . '.log');
            $logger->pushHandler($file_handler);
            return $logger;
        };
// ======Configs 配置=====
        $this->container['configs'] = function ($c) {
            $Configs = new \Configs\Config($c['settings']);
            return $Configs;
        };
//  ======数据库配置=====
        $this->container['db']    = function ($c) {
            $db  = $c['settings']['db'];
            $dsn = 'mysql:host=' . $db['default']['host'] . ';dbname=' . $db['default']['dbname'] . ';charset=utf8';
            $pdo = new \Slim\PDO\Database($dsn, $db['default']['user'], $db['default']['pass']);
            return $pdo;
        };
//======视图=====
        $this->container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(
                __DIR__ . '/../Templates', [
                'cache' => false
            ]);
            // Instantiate and add Slim specific extension
            $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
            $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
            return $view;
        };
//==报错处理==
        $this->container['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {
                $errMsg           = $exception->getMessage();
                $errCode          = $exception->getCode();
                $errFile          = $exception->getFile();
                $errLine          = $exception->getLine();
                $resp             = array();
                $resp['msg']      = $errMsg;
                $resp['code']     = $errCode;
                $resp['data']     = (object)[];
                $resp['err_file'] = $errFile;
                $resp['err_line'] = $errLine;
                return $c['response']->withJson($resp);
            };
        };
        return $this->container;
    }

    /**
     * 容器配置文件更新
     * @throws \Exception
     */
    private function SetContainersSettings()
    {
        //配置更新
        $settings = $this->container->get('settings');
        $env      = getenv('APP_ENV');
        if (!in_array($env, ['local', 'production', 'test'])) {
            $error = 'Set APP_ENV in (local,production,test)';
            throw new \Exception($error);
        }
        $config = require __DIR__ . '/../Configs/' . $env . '.php';
        $settings->replace($config);
    }
}

