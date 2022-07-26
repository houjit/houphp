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
declare (strict_types = 1);
namespace hou\pool;
use hou\Singleton;
use hou\coroutine\Coroutine;


/**
 * Class Context
 * @package hou\coroutine
 * @desc 保持嵌套协程的context传递
 */
class Context implements PoolInterface
{

    use Singleton;
    /**
     * @var array context pool
     */
    private $pool = [];

    /**
     * @return \hou\coroutine\Context
     * @desc 可以任意协程获取到context
     */
    public function get()
    {
        $id = Coroutine::getPid();
        if (isset($this->pool[$id])) {
            return $this->pool[$id];
        }

        return null;
    }

    /**
     * @desc 清除context
     */
    public function release()
    {
        $id = Coroutine::getPid();
        if (isset($this->pool[$id])) {
            unset($this->pool[$id]);
            Coroutine::clear($id);
        }
    }

    /**
     * @param $context
     * @desc 设置context
     */
    public function put($context)
    {
        $id = Coroutine::getPid();
        $this->pool[$id] = $context;
    }

    public function getLength()
    {
        return count($this->pool);
    }
}