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
namespace app\service;
use app\dao\User as UserDao;
use hou\Singleton;

class User
{
    use Singleton;

    /**
     * @param $id
     * @return mixed
     * @desc 通过uid查询用户信息
     */
    public function getUserInfoByUId($id)
    {
        return UserDao::getInstance()->fetchById($id);
    }

    /**
     * @return mixed
     * @desc 获取所有用户列表
     */
    public function getUserInfoList()
    {
        return UserDao::getInstance()->fetchAll();
    }

    /**
     * @param array $array
     * @return bool
     * @desc 添加一个用户
     */
    public function add(array $array)
    {
        return UserDao::getInstance()->add($array);
    }

    /**
     * @param array $array
     * @param $id
     * @return bool
     * @throws \Exception
     * @desc 按id更新一个用户
     */
    public function updateById(array $array, $id)
    {
        return UserDao::getInstance()->update($array, "id={$id}");
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     * @desc 按id删除用户
     */
    public function deleteById($id)
    {
        return UserDao::getInstance()->delete("id={$id}");
    }
}