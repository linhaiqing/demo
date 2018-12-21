<?php

namespace app\demo\controller;

use app\demo\model\User;
use app\demo\model\Profile;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
    protected $middleware = ['InAppCheck'];
    // 该方法会在调用控制器的方法之前首先执行
    protected function initialize()
    {

    }

    //空操作
    public function _empty($name)
    {
        return '空操作:' . $name;
    }

    /**
     * 查询列表
     * @author haiqing
     * @see  https://www.kancloud.cn/manual/thinkphp5_1/354045
     * @link http://tp5.com/demo/index
     * @throws  抛出 Exception
     * @param  参数
     * @date     2018-12-20
     * @version 1.0.0
     * @example 例子
     * @return  json    用户列表
     */
    public function index()
    {
        $method = input('method', 1, 'intval');
        switch ($method) {
            case 1:
                // 根据主键(或数组)获取多个数据
                $data = User::all('3,4');
                break;
            case 2:
                //获取某个字段或者某个列的值
                $data = User::where('status', 1)->column('name', 'id');
                break;
            case 3:
                // //动态查询
                // 根据name字段查询用户
                $data = User::getByName('thinkphp');
                break;
            case 4:
                //数据分批处理
                $data = User::chunk(100, function ($users) {
                    foreach ($users as $user) {
                    }
                });
                break;
            case 5:
                //查询数组
                $data = User::where('id', 'gt', 10)->hidden(['delete_time'])->append(['status_text'])->select();
                //5.0
                // $data = collection($user)->hidden(['create_time', 'update_time'])->append(['status_text'])->each(function ($item, $key) {
                //     $item->name = $key;
                // });
                break;
            default:
                return ajax([], '没有这个方法', '404');
                break;
        }
        return ajax($data);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 新增
     * @author haiqing
     * @date     2018-12-20
     * @see  https://www.kancloud.cn/manual/thinkphp5_1/354042
     * @link http://tp5.com/demo/index/save
     * @version 1.0.0
     * @param  Request $request 请求参数
     * @example 例子
     * @throws  抛出 Exception
     * @return  json
     */
    public function save(Request $request)
    {
        $method = input('method', 1, 'intval');
        $name   = input('name', 1, 'string');
        $email  = input('email', 1, 'thinkphp@qq.com');
        switch ($method) {
            case 1:
                // 第一种是实例化模型对象后赋值并保存：
                $user        = new User;
                $user->name  = 'thinkphp';
                $user->email = 'thinkphp@qq.com';
                $user->save(); //1
                break;
            case 2:
                //也可以直接传入数据到save方法批量赋值：
                $user = new User;
                $rs   = $user->save([
                    'name'  => 'thinkphp',
                    'email' => 'thinkphp@qq.com',
                ]);
                if (!$rs) {
                    return $user->getError();
                }
                break;
            case 3:
                //或者直接在实例化的时候传入数据
                $user = new User([
                    'name'  => 'thinkphp',
                    'email' => 'thinkphp@qq.com',
                ]);
                $rs = $user->save();
                //实例化传入的模型数据也不会经过修改器处理。
                break;
            case 4:
                //如果你通过外部提交赋值给模型，并且希望指定某些字段写入，可以使用：
                $user = new User;
                // post数组中只有name和email字段会写入
                $param  = ['name' => 'thinkphp', 'email' => 'thinkphp@qq.com', 't' => 't'];
                $rs     = $user->allowField(['name', 'email'])->save($param);
                $data[] = $user->id;
                break;
            case 5:
                //添加多条数据
                $user = new User;
                $list = [
                    ['id' => 1, 'name' => 'thinkphp', 'email' => 'thinkphp@qq.com'],
                    ['id' => 2, 'name' => 'onethink', 'email' => 'onethink@qq.com'],
                ];
                $user = $user->saveAll($list);
                break;
            case 6:
                //静态方法,最佳实践
                $user = User::create([
                    'name'  => 'thinkphp',
                    'email' => 'thinkphp@qq.com', 't' => 't',
                ], ['name', 'email']);
                break;
            default:
                return ajax([], '没有这个方法', '404');
                break;
        }
        return ajax($user);
    }

    /**
     * 查询
     * @author haiqing
     * @date     2018-12-20
     * @link http://tp5.com/demo/index/read
     * @version 1.0.0
     * @param  Request $request 请求参数
     * @example 例子
     * @throws  抛出 Exception
     * @return  json
     */
    public function read($id = 0)
    {
        // 取出主键为1的数据
        $data = User::where('id', 'gt', 0)->hidden(['create_time', 'update_time'])->append(['status_text'])->find();
        // 5.1
        // $data = User::where('id', 'gt', 0)->find();
        // $data = collection($user)->hidden(['create_time', 'update_time'])->append(['status_text'])->toArray();
        return ajax($data);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id = 0)
    {
        //查找并更新.这种方式是最佳的更新方式。
        $user        = User::get(1);
        $user->name  = 'thinkphp';
        $user->email = 'thinkphp@qq.com';
        $user->score = Db::raw('score+1');
        $rs          = $user->force()->save();
        $data[]      = $rs;

        //直接更新数据
        $user = new User;
        // save方法第二个参数为更新条件
        $rs = $user->allowField(true)->save([
            'name'  => 'thinkphp',
            'score' => ['inc', 1],
            'email' => 'thinkphp@qq.com', 't' => 't',
        ], ['id' => 1]);
        $data[] = $rs;

        //静态方法
        $rs     = User::where('id', 1)->update(['name' => 'thinkphp']);
        $data[] = $rs;
        $rs     = User::update(['id' => 1, 'name' => 'thinkphp']);
        $data[] = $rs;
        //上面两种写法的区别是第一种是使用的数据库的update方法，而第二种是使用的模型的update方法（可以支持模型的修改器、事件和自动完成）。

        return $data;
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id = 0)
    {
        //删除当前模型
        $user   = User::order('id', 'desc')->find();
        $rs     = $user->delete(true);
        $data[] = $rs;

        //根据主键删除
        $user   = User::order('id', 'desc')->find();
        $rs     = User::destroy($user['id'], true);
        $data[] = $rs;

        //条件删除
        $rs = User::destroy(function ($query) {
            $query->where('id', '>', 100);
        });
        $data[] = $rs;

        return $data;
    }

    /**
     * 一对一关联
     * @author haiqing
     * @see  https://www.kancloud.cn/manual/thinkphp5_1/354057
     * @link http://tp5.com/demo/index/hasone
     * @throws  抛出 Exception
     * @param  参数
     * @date     2018-12-20
     * @version 1.0.0
     * @example 例子
     * @return  json   
     */
    public function hasone()
    {
        $data = [];
        $method = input('method', 1);
        switch ($method) {
            case 1:
                $user = User::get(1);
                // 输出Profile关联模型的email属性
                echo $user->profile->user_id;
                break;
            case 2:
                // 根据关联数据查询
                // 注意第一个参数是关联方法名（不是关联模型名）
                $data[] = User::hasWhere('profile', ['nickname' => 'think'])->select();

                // 可以使用闭包查询
                $data[] = User::hasWhere('profile', function ($query) {
                    $query->where('nickname', 'like', 'think%');
                })->select();
                break;
            case 3:
                //预载入查询
                $users = User::with('profile')->limit(1)->select();
                foreach ($users as $user) {
                    echo $user->profile->name;
                }
                // 如果要对关联模型进行约束，可以使用闭包的方式。
                $users = User::with(['profile'  => function($query) {
                    $query->field('user_id,name,email');
                }])->limit(1)->select();
                foreach ($users as $user) {
                    echo $user->profile->name;
                }
                
                break;
            case 4:
                //使用JOIN方式的查询
                $users = User::withJoin([
                    'profile'   =>  ['name', 'email']
                ], 'INNER')->select();
                foreach ($users as $user) {
                    echo $user->profile->name;
                }
                break;
            case 5:
                // 关联保存
                $user = User::get(1);
                // 新增关联数据
                $user->profile()->save(['email' => 'thinkphp']);
                break;
            case 6:
                //定义相对关联
                $profile = Profile::get(1);
                // 输出User关联模型的属性
                echo $profile->user->account;
                break;
            case 7:
                $user = User::get(1,'profile');
                // 输出Profile关联模型的email属性
                echo $user->email;
                break;
            case 8:
                // 查询
                $blog = User::get(1);
                $blog->name = '更改标题';
                $blog->profile->nickname = '更新内容';
                // 更新当前模型及关联模型
                $blog->together('profile')->save();
                break;

            default:
                // code...
                break;
        }

        return ajax($data);
    }

    /**
     * 一对多关联
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function hasmany()
    {
        $data = [];
        $method = input('method', 1);
        switch ($method) {
            case 1:
                //关联查询
                $user = User::get(1);
                $data = $user->profiles()->where('status',1)->select();
                break;
            case 2:
                //关联查询
                $data = User::has('profiles','>',1)->select();
                break;
            
            default:
                // code...
                break;
        }
        return ajax($data);

    }

    /**
     * 发布任务
     * @author haiqing
     * @see  https://github.com/coolseven/notes/tree/master/thinkphp-queue
     * @link http://tp5.com/demo/index/push
     * @throws  抛出 Exception
     * @param  参数
     * @date     2018-12-20
     * @version 1.0.0
     * @example php think queue:work --queue helloJobQueue
     * @return  json   
     */
    public function push()
    {
        // 1.当前任务将由哪个类来负责处理。 
      //   当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法
      $jobHandlerClassName  = 'app\demo\job\Hello'; 
      // 2.当前任务归属的队列名称，如果为新队列，会自动创建
      $jobQueueName       = "helloJobQueue"; 
      // 3.当前任务所需的业务数据 . 不能为 resource 类型，其他类型最终将转化为json形式的字符串
      //   ( jobData 为对象时，需要在先在此处手动序列化，否则只存储其public属性的键值对)
      $jobData            = [ 'ts' => time(), 'bizId' => uniqid() , 'a' => 1 ] ;
      // 4.将该任务推送到消息队列，等待对应的消费者去执行
      $isPushed = \think\Queue::push( $jobHandlerClassName , $jobData , $jobQueueName );   
      // database 驱动时，返回值为 1|false  ;   redis 驱动时，返回值为 随机字符串|false
      if( $isPushed !== false ){  
          $rs =  date('Y-m-d H:i:s') . " a new Hello Job is Pushed to the MQ"."<br>";
      }else{
          $rs =  'Oops, something went wrong.';
      }
      return ajax($rs);
    }
}
