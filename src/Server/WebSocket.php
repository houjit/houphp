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
use hou\Listener;
use hou\Route;
use Swoole\WebSocket\Server;

class WebSocket
{
    protected $_server;

    protected $_config;

    /** @var \hou\Route */
    protected $_route;

    public function __construct()
    {
        $config = config('servers');
        $wsConfig = $config['ws'];
        $this->_config = $wsConfig;
        $this->_server = new Server($wsConfig['ip'], $wsConfig['port'], $config['mode']);
        $this->_server->set($wsConfig['settings']);

        if ($config['mode'] == SWOOLE_BASE) {
            $this->_server->on('managerStart', [$this, 'onManagerStart']);
        } else {
            $this->_server->on('start', [$this, 'onStart']);
        }

        $this->_server->on('workerStart', [$this, 'onWorkerStart']);

        foreach ($wsConfig['callbacks'] as $eventKey => $callbackItem) {
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

    public function onStart(\Swoole\Server $server)
    {
        Application::echoSuccess("Swoole WebSocket Server running：ws://{$this->_config['ip']}:{$this->_config['port']}");
        Listener::getInstance()->listen('start', $server);
    }

    public function onManagerStart(\Swoole\Server $server)
    {
        Application::echoSuccess("Swoole WebSocket Server running：ws://{$this->_config['ip']}:{$this->_config['port']}");
        Listener::getInstance()->listen('managerStart', $server);
    }

    public function onWorkerStart(\Swoole\Server $server, int $workerId)
    {
        $this->_route = Route::getInstance();
        Listener::getInstance()->listen('workerStart', $server, $workerId);
    }
}