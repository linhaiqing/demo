<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 返回格式
 * @author haiqing
 * @date    2018-12-20
 * @version 1.0.0
 * @param   integer    $code 状态码
 * @param   string     $msg  消息
 * @param   array      $data 数据
 * @return  json             json格式
 */
function ajax($data = [], $msg = 'success', $code = 200)
{
    $data = ['code' => $code, 'msg' => $msg, 'data' => $data];
    return json($data);
}