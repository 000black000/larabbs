<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));// strip_tags()：剥去HTML标签； preg_replace（）：匹配正则表达式进行替换
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = snake_case($class_name);

    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return str_plural($snake_case_name);
}

    /**
     * 用正则匹配，,截取指定 两个字符之间 的 字符串
     * @param  [string] $text 目标字符串
     * @param  [string] $start   开始字符串
     * @param  [string] $end     结束字符串
     * @return [string]          开始字符串 和 结束字符串 之间的内容
     */
    function get_between($text, $start, $end)
    {   
        $str = "/(?<=$start).*?(?=$end)/";
        preg_match_all($str, $text, $data);
        return $data[0];
    }

    /**
     * 把模型实例 打印成 数组输出
     */
    function dda($model)
    {
        if(method_exists($model, 'toArray')) {
            dd($model->toArray());
        } else {
            dd($model);
        }
    }
