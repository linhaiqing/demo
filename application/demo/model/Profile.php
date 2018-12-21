<?php
namespace app\demo\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 用户资料模型
 * @package app\demo\model
 * @example use app\demo\model\User;
 */
class Profile extends Model
{
    use SoftDelete;
    protected $deleteTime        = 'delete_time';
    protected $defaultSoftDelete = 0;
    // 设置当前模型的数据库连接
    protected $connection = '';
    // 数据表名称 @var string
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'id';
    // 保存自动完成列表
    protected $auto = ['name', 'ip'];
    // 新增自动完成列表
    protected $insert = ['status' => 1];
    // 更新自动完成列表
    protected $update = [];
    // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp = true;
    // 创建时间字段
    protected $createTime = 'create_time';
    // 更新时间字段
    protected $updateTime = 'update_time';
    // 时间字段取出后的默认时间格式
    protected $dateFormat = 'Y-m-d H:i:s';
    // 字段类型或者格式转换
    protected $type = ['info' => 'serialize'];
    // 查询数据集对象
    // protected $resultSetType = 'Collection';

    //init必须是静态方法，并且只在第一次实例化的时候执行
    protected static function init()
    {
        // User::beforeInsert(function ($user) {
        //     if ($user->status != 1) {
        //         return false;
        //     }
        // });
    }

    // 定义全局的查询范围
    protected function base($query)
    {
        // $query->where('delete_time',0);
    }


    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('Comment');
    }

    public function topics()
    {
        return $this->hasManyThrough('Topic', 'User');
    }

    public function roles()
    {
        return $this->belongsToMany('Role');
    }

    /**
     * 获取所有针对文章的评论。
     */
    public function comments1()
    {
        return $this->morphMany('Comment', 'commentable');
    }

    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }

    public function getStatusTextAttr($value, $data)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$data['status']];
    }

    public function setNameAttr($value)
    {
        return strtolower($value);
    }

    protected function setIpAttr()
    {
        return request()->ip();
    }

    public function searchNameAttr($query, $value, $data)
    {
        $query->where('name', 'like', $value . '%');
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }

    protected function scopeThinkphp($query)
    {
        $query->where('name', 'thinkphp')->field('id,name');
    }

}
