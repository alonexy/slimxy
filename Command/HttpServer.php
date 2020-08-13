<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 * @author   alonexy@qq.com
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Command;

use Helpers\ServerHelper;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * SlimXy HttpServer
 * Class HttpServer.
 */
class HttpServer extends Command
{
    protected static $defaultName = 'http:server';

    /**
     * 所有操作.
     * @var array
     */
    protected $actions = [
        'start',
        'reload',
        'stop',
        'status',
    ];

    # PidFileDir
    protected $PidFile = __DIR__ . '/../bin/http_server.pid';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取状态
     * @param $input
     * @param $output
     * @return bool
     */
    public function Status($input, $output)
    {
        $pid = ServerHelper::getPid($this->PidFile);
        if ($pid < 1) {
            $output->writeln('<error>Http Server is Not Running.</error>');
            return false;
        }
        if (! ServerHelper::isRunning($pid)) {
            return $output->writeln('<error>Http Server is Not Running. </error>');
        }
        return $output->writeln('<success>Http Server is Running. </success>');
    }

    /**
     * 配置.
     */
    protected function configure()
    {
        $this->setDescription('Provide some commands to manage the Slimxy HTTP Server')
            ->setAliases(['HttpServer', 'http-server'])
            ->addArgument('action', InputArgument::REQUIRED, 'action')
            ->addOption('daemonize', 'd', InputOption::VALUE_NONE, 'Start Server at daemonize ?')
            ->addOption('only_task', 'o', InputOption::VALUE_NONE, 'Reload Server only task ?')
            ->setHelp('HttpServer -> actions:' . json_encode($this->actions));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $input->getArgument('action');

        $SucOutputStyle = new OutputFormatterStyle('green');
        $ErrOutputStyle = new OutputFormatterStyle('white', 'red', ['bold', 'blink']);
        /*
         * 可用前景色和背景色有：black，red，green，  yellow，blue，magenta，cyan和white。
         *
         * 和可用的选项为：bold，underscore，blink，reverse （使在背景和前景颜色被交换的“反向视频”模式）和conceal（设定前景颜色为透明的，使键入的文本不可见-尽管它可被选择和复制;该选项通常在要求用户输入敏感信息时使用。
         */
        $output->getFormatter()->setStyle('success', $SucOutputStyle);
        $output->getFormatter()->setStyle('error', $ErrOutputStyle);

        switch ($action) {
            case 'start':
                $this->Start($input, $output);
                break;
            case 'reload':
                $this->Reload($input, $output);
                break;
            case 'stop':
                $this->Stop($input, $output);
                break;
            case 'status':
                $this->Status($input, $output);
                break;
            default:
                return $output->writeln("<error>action is Err must in ['start','reload', 'stop'] </error>");
        }
    }

    /**
     * 开启 httpServer.
     * @param $input
     * @param $output
     */
    private function Start($input, $output)
    {
        $daemonize = $input->getOption('daemonize');
        $container = new \Core\Containers();
        $app = new \Slim\App($container->GetContainers());
        if(env('APP_ENV') !== 'local'){
            require __DIR__ . '/../routes.php';
        }
        $port = (int) env('SW_HTTP_SERVER_PORT') ?: 8888;
        $http_server = new \Swoole\Http\Server('0.0.0.0', $port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $http_server->set(
            [
                'daemonize' => $daemonize,    //守护进程化 true/false
                'pid_file' => $this->PidFile,
                'reactor_num' => env('SW_REACTOR_NUM', 1),    //reactor thread num
                'worker_num' => env('SW_WORK_NUM', 8),    //Swoole采用固定Worker进程的模式
                'backlog' => 2048,    //此参数将决定最多同时有多少个等待accept的连接。
                'max_request' => env('SW_MAX_REQ', 3000),
                'max_coroutine' => env('SW_MAX_COR', 30000),
                'enable_coroutine' => true,
                'dispatch_mode' => 1, // 1平均分配，2按FD取模固定分配，3抢占式分配，默认为取模(dispatch=2)
                'log_level' => env('SW_LOG_LEVEL', 0),
                'log_file' => __DIR__ . '/../logs/swoole.log',
                'request_slowlog_file' => __DIR__ . '/../logs/trace.log',
                'http_parse_post' => false,
                'hook_flags' => [SWOOLE_HOOK_ALL, SWOOLE_HOOK_CURL],
            ]
        );
        $http_server->on(
            'WorkerStart',
            function ($serv, $worker_id)  {

            }
        );
        $http_server->on(
            'start',
            function ($server) use ($port, $output, $daemonize) {
                $notice = "Slimxy Http Server is started at http://0.0.0.0:{$port}\n";
                if ($daemonize) {
                    $notice = "Slimxy Http Server is daemonize started at http://0.0.0.0:{$port}\n";
                }
                $output->writeln("<success>{$notice}</success>");
            }
        );
        $http_server->on(
            'request',
            function (Request $request, Response $response) use ($app) {
                if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
                    return $response->end();
                }
                $slimRequest = \Slim\Http\Request::createFromEnvironment(
                    new \Slim\Http\Environment(
                        [
                            'SERVER_PROTOCOL' => 'HTTP/1.1',
                            'REQUEST_METHOD' => $request->server['request_method'],
                            'REQUEST_URI' => $request->server['request_uri'],
                            'SERVER_PORT' => $request->server['server_port'],
                            'HTTP_ACCEPT' => $request->header['accept'],
                            'HTTP_USER_AGENT' => $request->header['user-agent'],
                        ]
                    )
                );
                if(env('APP_ENV') === 'local'){
                    require __DIR__ . '/../routes.php';
                }
                $slimRequest->withMethod($request->server['request_method']);
                $slimRequest = $slimRequest->withQueryParams($request->get??[]);
                $slimRequest = $slimRequest->withParsedBody($request->post??[]);
                $processedResponse = $app->process($slimRequest, new \Slim\Http\Response());
                // Set all the headers you will find in $processedResponse into swoole's $response
                foreach ($processedResponse->getHeaders() as $k => $v) {
                    if (is_array($v)) {
                        $response->header($k, $v[0]);
                    } else {
                        $response->header($k, $v);
                    }
                }
                // Set the body
                $response->end((string) $processedResponse->getBody());
            }
        );
        $http_server->start();
    }

    /**
     * 重载 httpServer.
     * @param $input
     * @param $output
     * @return bool
     */
    private function Reload($input, $output)
    {
        $only_task = $input->getOption('only_task');
        $signal = $only_task ? SIGUSR2 : SIGUSR1;
        $pid = ServerHelper::getPid($this->PidFile);
        if ($pid < 1) {
            $output->writeln('<error>Http Server getPid is Err .</error>');
            return false;
        }
        if (! ServerHelper::isRunning($pid)) {
            return $output->writeln('<error>Http Server is Not Running. </error>');
        }
        // SIGUSR1(10):
        //  Send a signal to the management process that will smoothly restart all worker processes
        // SIGUSR2(12):
        //  Send a signal to the management process, only restart the task process
        ServerHelper::sendSignal($pid, $signal);
        return $output->writeln('<success>Http Server is Reload. </success>');
    }

    /**
     * 关闭 HttpServer.
     * @param $input
     * @param $output
     * @return bool|\Helpers\bool
     */
    private function Stop($input, $output)
    {
        $pid = ServerHelper::getPid($this->PidFile);
        if ($pid < 1) {
            $output->writeln('<error>Http Server getPid is Err .</error>');
            return false;
        }
        if (! ServerHelper::isRunning($pid)) {
            return $output->writeln('<error>Http Server is Not Running. </error>');
        }
        // SIGTERM = 15
        if (ServerHelper::killAndWait($pid, SIGTERM)) {
            $output->writeln('<success>Http Server is Stop. </success>');
            return ServerHelper::removePidFile($this->PidFile);
        }
        $output->writeln('<error>Http Server Not Stop. [Unkonw Err] </error>');
        return false;
    }
}
