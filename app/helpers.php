<?php
use Illuminate\Support\Facades\Route;

/**
 * 将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
 * @return string|string[]|null
 */
function route_class() {
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * active_class()讲解:
 * 如果 $condition 不为 True 即会返回字符串 `active`
 *
 * @param $condition
 * @param string $activeClass
 * @param string $inactiveClass
 *
 * @return string
 *
 * 1. if_route() - 判断当前对应的路由是否是指定的路由；
   2. if_route_param() - 判断当前的 url 有无指定的路由参数。
   3. if_query() - 判断指定的 GET 变量是否符合设置的值；
   4. if_uri() - 判断当前的 url 是否满足指定的 url； 5. if_route_pattern() - 判断当前的路由是否包含指定的字符；
   6. if_uri_pattern() - 判断当前的 url 是否含有指定的字符；
 *
 */
function category_nav_active($category_id) {
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

/**
 * 生成文章摘要
 * @param $value
 * @param int $length
 * @return string
 */
function make_excerpt($value, $length = 200) {
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model) {
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '') {
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);
    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';
    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;
    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model) {
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);
    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);
    // 蛇形命名，例如：传参 `User` 会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = snake_case($class_name);
    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return str_plural($snake_case_name);
}
