<?php declare (strict_types = 1);
/**
 *  HouCMF [ 用心做好每个站 用心服务好每个客户 ]
 *
 * @link     https://houphp.cn
 * @document https://doc.houphp.cn
 * @license  https://github.com/houjit/houphp/blob/master/LICENSE
 */
namespace hou\Server\Protocol;

interface MqttInterface
{
    // 1
    public function onMqConnect($server, int $fd, $fromId, $data);

    // 12
    public function onMqPingreq($server, int $fd, $fromId, $data): bool;

    // 14
    public function onMqDisconnect($server, int $fd, $fromId, $data): bool;

    // 3
    public function onMqPublish($server, int $fd, $fromId, $data);

    // 8
    public function onMqSubscribe($server, int $fd, $fromId, $data);

    // 10
    public function onMqUnsubscribe($server, int $fd, $fromId, $data);
}
