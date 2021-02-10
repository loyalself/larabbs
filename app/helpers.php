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
