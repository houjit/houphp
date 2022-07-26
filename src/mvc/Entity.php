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
namespace hou\mvc;

class Entity
{
    /**
     * Entity constructor.
     * @param array $array
     * @desc 把数组填充到entity
     */
    public function __construct(array $array)
    {
        if (empty($array)) {
            return $this;
        }

        foreach ($array as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}