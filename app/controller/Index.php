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
namespace app\controller;
use app\service\User as UserService;

class Index extends Base
{
    public function index()
    {
        return $this->template(['name' => 'HouPHP']);
    }

    public function tong()
    {
        return $this->json('i am tong ge');
    }

    /**
     * @return false|string
     * @throws \Exception
     * @desc 返回一个用户信息
     */
    public function user()
    {
        $uid = $this->request->getQueryParam('uid');
        if (empty($uid)) {
            throw new \Exception("uid 不能为空 ");
        }
        $result = UserService::getInstance()->getUserInfoByUId($uid);
        return $this->json($result);
    }

    /**
     * @return false|string
     * @desc 返回用户列表
     */
    public function list()
    {
        $result = UserService::getInstance()->getUserInfoList();
        return $this->json($result);

    }

    /**
     * @return bool
     * @desc 添加用户
     */
    public function add()
    {
        $array = [
            'name' => $this->request->getQueryParam('name'),
            'password' => $this->request->getQueryParam('password'),
        ];

        return $this->json(UserService::getInstance()->add($array));
    }

    /**
     * @return bool
     * @throws \Exception
     * @desc 更新用户信息
     */
    public function update()
    {
        $array = [
            'name' => $this->request->getQueryParam('name'),
            'password' => $this->request->getQueryParam('password'),
        ];
        $id = $this->request->getQueryParam('id');
        return $this->json(UserService::getInstance()->updateById($array, $id));
    }

    /**
     * @return mixed
     * @throws \Exception
     * @desc 删除用户信息
     */
    public function delete()
    {
        $id = $this->request->getQueryParam('id');
        return $this->json(UserService::getInstance()->deleteById($id));
    }

}