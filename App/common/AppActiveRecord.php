<?php

namespace common;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class AppActiveRecord extends ActiveRecord
{

    /**
     * @var string
     */
    protected $raw_sql = '';

    /**
     * 返回
     * @param $where mixed 查询条件
     * @param int $count 条数
     * @param string $column 字段名
     * @param string $order_by 排序
     * @return array|ActiveRecord[] 
     */
    public function get_all($where, $count = 0, $column = '*', $order_by = '')
    {
        $query = static::find()->select($column)->where($where);
        if (!empty($order_by)) {
            $query->orderBy($order_by);
        }
        if (!empty($count)) {
            $query->limit($count);
        }
        return $query->all();
    }

    /**
     * 查询单条记录
     * @param $where mixed 条件
     * @param string $fields mixed 字段名
     * @param string $order_by mixed 排序
     * @return array|null|ActiveRecord 
     */
    public function get_one($where, $fields = '*', $order_by = '')
    {
        $query = static::find()->select($fields)->where($where);
        if (!empty($order_by)) {
            $query->orderBy($order_by);
        }
        return $query->one();
    }

    /**
     * 获取单条记录的单个字段值
     * @param $where mixed 条件
     * @param $field mixed 字段名
     * @return false|null|string
     */
    public function get_field($where, $field)
    {
        return static::find()->where($where)->select($field)->scalar();
    }

    /**
     * 获取多个字段
     * @param $where mixed 条件
     * @param $fileds mixed 字段名
     * @return array|boolean 
     */
    public function get_fields($where, $fileds)
    {
        return static::find()->where($where)->select($fileds)->column();
    }

    /**
     * 更新一条记录
     * @param $where mixed 更新条件
     * @param $attributes array 键值对
     */
    public function update_one($where, $attributes)
    {
        $item = static::findOne($where);
        foreach ($attributes as $field_name => $field_value) {
            $item->$field_name = $field_value;
        }
        $item->save(0);
    }

    /**
     * 获取分布数据
     * @param $where mixed 查询条件
     * @param $current_page int 当前页
     * @param $page_size int 每页数据条数
     * @param $order_by mixed 排序
     * @return array|boolean 
     */
    public function pager($where, $current_page, $page_size, $order_by)
    {
        $data = [
            'current_page' => $current_page,
            'page_size' => $page_size,
            'count' => 0,
            'list' => []
        ];
        $offset = $current_page * $page_size;
        $query = static::find()->where($where);
        $data['count'] = $query->count();
        $data['list'] = $query->offset($offset)->limit($page_size)->orderBy($order_by)->all();
        return $data;
    }

    /**
     * 删除一条记录
     * @param $where
     * @return false|int
     */
    public function delete_one($where)
    {
        return static::findOne($where)->delete();
    }

    /**
     * 对像转化为数组
     * @param array $data
     * @return array|bool
     */
    public function to_array($data)
    {
        if ($data) {
            return ArrayHelper::toArray($data);
        } else {
            return false;
        }
    }

    //TODO maybe based on event 、 behavior injection
    public function get_sql()
    {

    }

}
