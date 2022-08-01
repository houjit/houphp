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
namespace app\entity;
use hou\mvc\Entity;

class User extends Entity
{
    /**
     * 对应的数据库表名
     */
    const TABLE_NAME = 'user';
    /**
     * 主键字段名
     */
    const PK_ID = 'id';

    //以下对应的数据库字段名
    public $id;
    public $name;
    public $password;

}