<?php declare (strict_types = 1);
/**
 *  HouCMF [ 用心做好每个站 用心服务好每个客户 ]
 *
 * @link     https://houphp.cn
 * @document https://doc.houphp.cn
 * @license  https://github.com/houjit/houphp/blob/master/LICENSE
 */
namespace hou;

class Application
{
    /**
     * @var string
     */
    protected static $version = '1.0.5';

    public static function welcome()
    {
        $appVersion = self::$version;
        $swooleVersion = SWOOLE_VERSION;
        echo <<<EOL
  ____    _                           
 / ___|  (_)  _ __ ___    _ __    ___ 
 \\___ \\  | | | '_ ` _ \\  | '_ \\  / __|
  ___) | | | | | | | | | | |_) | \\__ \\
 |____/  |_| |_| |_| |_| | .__/  |___/
                         |_|           Version: {$appVersion}, Swoole: {$swooleVersion}


EOL;
    }

    public static function println($strings)
    {
        echo $strings . PHP_EOL;
    }

    public static function echoSuccess($msg)
    {
        self::println('[' . date('Y-m-d H:i:s') . '] [INFO] ' . "\033[32m{$msg}\033[0m");
    }

    public static function echoError($msg)
    {
        self::println('[' . date('Y-m-d H:i:s') . '] [ERROR] ' . "\033[31m{$msg}\033[0m");
    }

    public static function run()
    {
        self::welcome();
        global $argv;
        $count = count($argv);
        $funcName = $argv[$count - 1];
        $command = explode(':', $funcName);
        switch ($command[0]) {
            case 'http':
                $className = \hou\Server\Http::class;
                break;
            case 'ws':
                $className = \hou\Server\WebSocket::class;
                break;
            case 'mqtt':
                $className = \hou\Server\MqttServer::class;
                break;
            case 'main':
                $className = \hou\Server\MainServer::class;
                break;
            default:
                // 用户自定义server
                $configs = config('servers', []);
                if (isset($configs[$command[0]], $configs[$command[0]]['class_name'])) {
                    $className = $configs[$command[0]]['class_name'];
                } else {
                    exit(self::echoError("command {$command[0]} is not exist, you can use {$argv[0]} [http:start, ws:start, mqtt:start, main:start]"));
                }
        }
        switch ($command[1]) {
            case 'start':
                new $className();
                break;
            default:
                self::echoError("use {$argv[0]} [http:start, ws:start, mqtt:start, main:start]");
        }
    }
}
