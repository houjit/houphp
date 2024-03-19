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
            'reactor_num'           => swoole_cpu_num(),
            'worker_num'            => swoole_cpu_num(),
            'task_worker_num'       => swoole_cpu_num(),
//            'enable_static_handler' => true,
//            'package_max_length'    => 20 * 1024 * 1024,
//            'buffer_output_size'    => 10 * 1024 * 1024,
//            'socket_buffer_size'    => 128 * 1024 * 1024,
//            'heartbeat_idle_time'        => 600, // 一个连接如果600秒内未向服务器发送任何数据，此连接将被强制关闭
//            'heartbeat_check_interval'   => 60, // 每60秒遍历一次
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
