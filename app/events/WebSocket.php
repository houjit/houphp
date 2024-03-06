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
namespace app\events;
use Swoole\WebSocket\Server;

class WebSocket
{
    public static function onOpen(Server $server, $request)
    {
        echo "server: handshake success with fd{$request->fd}\n";
    }

    public static function onMessage(Server $server, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $server->push($frame->fd, 'this is server');
    }

    public static function onClose(Server $server, $fd)
    {
    }
}
