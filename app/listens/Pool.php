<?php declare(strict_types=1);
// +----------------------------------------------------------------------
// | houoole [ 厚匠科技 https://www.houjit.com ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: amos <amos@houjit.com>
// +----------------------------------------------------------------------
namespace app\listens;
use houoole\db\PDO;
use houoole\db\Redis;
use houoole\Singleton;

class Pool
{
    use Singleton;

    public function workerStart($server, $workerId)
    {
        $config = config('database', []);
        if (! empty($config)) {
            PDO::getInstance($config);
        }

        $config = config('redis', []);
        if (! empty($config)) {
            Redis::getInstance($config);
        }
    }
}
