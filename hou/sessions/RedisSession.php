<?php
// +----------------------------------------------------------------------
// | HouCMF [ 用心做好每个站 用心服务好每个客户 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://www.houjit.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Amos <amos@houjit.com>
// +----------------------------------------------------------------------
namespace hou\sessions;
use SessionHandler;

class RedisSession extends SessionHandler
{
    private $redis;
    
    private $lifeTime = 7200;
    
    private $config;

    private $prefix = 'SAIAPI_SESSION:';

    public function __construct($config)
    {
        $this->config = $config;
    }
    
    private function getRedisInstance()
    {
        if (empty($this->redis))
        {
            $redis = new \Redis();
            // todo 需要支持ssl连接
            $redis->connect($this->config['host'], $this->config['port'], $this->config['timeout']);
            if (!$this->config['auth']) {
                $redis->auth($this->config['auth']);
            }

            $this->redis = $redis;
        }
        return $this->redis;
    }

    public function read($id)
    {
        return $this->getRedisInstance()->get($this->prefix.$id);
    }

    public function write($id, $data)
    {
        if ($this->getRedisInstance()->setex($this->prefix.$id, $this->lifeTime, $data)) {
            return true;
        }

        return false;
    }

    public function destroy($id)
    {
        if($this->getRedisInstance()->delete($id)){//删除redis中的指定记录
            return true;
        }
        return false;
    }

    public function gc($maxlifetime)
    {
        return true;
    }

    public function __destruct()
    {
        session_write_close();
    }
}
