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
namespace app\model;
use houoole\db\BaseModel;

class Model extends BaseModel
{
    /**
     * 添加数据
     **/
    public function add($data)
    {
        return $this->insert($this->table, $data);
    }
    public function edit($data,$where)
    {
        $update = $this->update($this->table, $data, $where);
        return $update->rowCount();
    }
    /**
     * 如果数据库字段有调整，根据数据库字段内容进行替换
     **/
    public function replace($data, $where, $type)
    {
        $this->replace($this->table, [ "type" => $type, "column" => $data ], $where);
    }
    public function del()
    {
        $del = $this->delete($this->table,$where);
        return $del->rowCount();
    }
    public function find($where,field=[],$join=[])
    {
        return $this->get($this->table,$join,$field, $where);
    }
    /**
     * 获取数据列表
     **/
    public function column($where,$field=[],$order=null,$join=[])
    {
        // 排序
       if(!empty($order) && $order == 'rand')
       {
            return $this->rand($this->table, $join, $field, $where)
       } else {
            $order = ['id','desc'];
       }

       // 重写select查询，medoo无排序等查询
       $map = [];
       $result = [];
       $column_map = [];

       $index = 0;

       $column = $where === null ? $join : $columns;

       $is_single = (is_string($column) && $column !== '*');

       $query = $this->exec($this->selectContext($table, $map, $join, $columns, $where), $map);

       $this->columnMap($columns, $column_map, true);

       if (! $this->statement) {
           return false;
       }

       if ($columns === '*') {
           return $query->fetchAll(PDO::FETCH_ASSOC);
       }

       while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
           $current_stack = [];
           $this->dataMap($data, $columns, $column_map, $current_stack, true, $result);
       }

       if ($is_single) {
           $single_result = [];
           $result_key = $column_map[$column][0];

           foreach ($result as $item) {
               $single_result[] = $item[$result_key];
           }

           return $single_result;
       }

       return $result;
    }
    /**
     * 判断数据是否为空
     **/
    public function isEmpty($where,$join=[])
    {
        return $this->has($where, $join);
    }
}
