<?php
namespace App\Observers;
use App\Models\Link;
use Illuminate\Support\Facades\Cache;
/**
 * 手动添加的模型监控器，需要到 AppServiceProvider 中注册
 */
class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
