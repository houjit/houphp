<?php declare (strict_types = 1);
/**
 *  HouCMF [ 用心做好每个站 用心服务好每个客户 ]
 *
 * @link     https://houphp.cn
 * @document https://doc.houphp.cn
 * @license  https://github.com/houjit/houphp/blob/master/LICENSE
 */
namespace hou\Server;
use hou\Application;
use hou\Context;
use hou\Listener;
use hou\Route;
use hou\Server\Protocol\HTTP\SimpleRoute;
use Swoole\Http\Server;
use Swoole\Server as HttpServer;

class Http
{
    protected $_server;

    protected $_config;

    /** @var \hou\Route */
    protected $_route;

    public function __construct()
    {
        $config = config('servers');
        $httpConfig = $config['http'];
        $this->_config = $httpConfig;
        if (isset($httpConfig['settings']['only_simple_http']))
        {
            $this->_server = new HttpServer($httpConfig['ip'], $httpConfig['port'], $config['mode']);
            $this->_server->on('workerStart', [$this, 'onHouWorkerStart']);
            $this->_server->on('receive', [$this, 'onReceive']);
            unset($httpConfig['settings']['only_simple_http']);
        } else {
            $this->_server = new Server(
                $httpConfig['ip'],
                $httpConfig['port'],
                $config['mode'],
                $httpConfig['sock_type']
            );
            $this->_server->on('workerStart', [$this, 'onWorkerStart']);
            $this->_server->on('request', [$this, 'onRequest']);
        }
        $this->_server->set($httpConfig['settings']);

        if ($config['mode'] == SWOOLE_BASE) {
            $this->_server->on('managerStart', [$this, 'onManagerStart']);
        } else {
            $this->_server->on('start', [$this, 'onStart']);
        }

        foreach ($httpConfig['callbacks'] as $eventKey => $callbackItem) {
            [$class, $func] = $callbackItem;
            $this->_server->on($eventKey, [$class, $func]);
        }

        if (isset($this->_config['process']) && ! empty($this->_config['process'])) {
            foreach ($this->_config['process'] as $processItem) {
                [$class, $func] = $processItem;
                $this->_server->addProcess($class::$func($this->_server));
            }
        }

        $this->_server->start();
    }

    public function onStart(HttpServer $server)
    {
        Application::echoSuccess("Swoole Http Server running：http://{$this->_config['ip']}:{$this->_config['port']}");
        Listener::getInstance()->listen('start', $server);
    }

    public function onManagerStart(HttpServer $server)
    {
        Application::echoSuccess("Swoole Http Server running：http://{$this->_config['ip']}:{$this->_config['port']}");
        Listener::getInstance()->listen('managerStart', $server);
    }

    public function onWorkerStart(HttpServer $server, int $workerId)
    {
        $this->_route = Route::getInstance();
        Listener::getInstance()->listen('workerStart', $server, $workerId);
    }

    public function onHouWorkerStart(HttpServer $server, int $workerId)
    {
        $this->_route = SimpleRoute::getInstance();
        Listener::getInstance()->listen('houWorkerStart', $server, $workerId);
    }

    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        Context::set('SwRequest', $request);
        Context::set('SwResponse', $response);
        $this->_route->dispatch($request, $response);
    }

    public function onReceive($server, $fd, $from_id, $data)
    {
        $this->_route->dispatch($server, $fd, $data);
    }
}
