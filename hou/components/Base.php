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
namespace hou\components;

class Base implements \ArrayAccess
{
    private $_container;

    public function __get($name)
    {
        if (method_exists($this, $method = 'get'.ucfirst($name))) {
            return $this->$method($name);
        }

        return null;
    }

    public function __set($name, $value)
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            return $this->$method($name, $value);
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_container[] = $value;
        } else {
            $this->_container[$offset] = $value;
        }
    }
    public function offsetExists($offset)
    {
        return isset($this->_container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->_container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->_container[$offset]) ? $this->_container[$offset] : null;
    }
}