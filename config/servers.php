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

return [
    'mode' => SWOOLE_PROCESS,
    'http' => [
        'ip' => '0.0.0.0',
        'port' => 9501,
        'sock_type' => SWOOLE_SOCK_TCP,
        'callbacks' => [
        ],
        'settings' => [
            'worker_num' => swoole_cpu_num(),
            'pid_file'   => __DIR__.'/../bin/server.pid',
            'log_file'   => __DIR__.'/../bin/swoole.log',
            'debug_mode' => true,
            'display_errors' => true,
            'log_level' => SWOOLE_LOG_DEBUG,
        ],
    ],
    'ws' => [
        'ip' => '0.0.0.0',
        'port' => 9503,
        'sock_type' => SWOOLE_SOCK_TCP,
        'callbacks' => [
            "open" => [\app\events\WebSocket::class, 'onOpen'],
            "message" => [\app\events\WebSocket::class, 'onMessage'],
            "close" => [\app\events\WebSocket::class, 'onClose'],
        ],
        'settings' => [
            'worker_num' => swoole_cpu_num(),
            'open_websocket_protocol' => true,
        ],
    ],
    'hot_update' => [
        'enable'  => env('APP_DEBUG', false),
        'name'    => ['*.php'],
        'include' => [ __DIR__.'/../app'],
        'exclude' => [],
    ],
];
