<?php declare (strict_types = 1);
/**
 *  HouCMF [ 用心做好每个站 用心服务好每个客户 ]
 *
 * @link     https://houphp.cn
 * @document https://doc.houphp.cn
 * @license  https://github.com/houjit/houphp/blob/master/LICENSE
 */
namespace hou;

class Config
{
    private static $instance;

    private static $config = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $keys
     * @param null $default
     * @return null|mixed
     */
    public function get($keys, $default = null)
    {
        $keys = explode('.', strtolower($keys));
        if (empty($keys)) {
            return null;
        }

        $file = array_shift($keys);

        if (empty(self::$config[$file])) {
            if (! is_file(CONFIG_PATH . $file . '.php')) {
                return null;
            }
            self::$config[$file] = include CONFIG_PATH . $file . '.php';
        }
        $config = self::$config[$file];

        while ($keys) {
            $key = array_shift($keys);
            if (! isset($config[$key])) {
                $config = $default;
                break;
            }
            $config = $config[$key];
        }

        return $config;
    }
}
