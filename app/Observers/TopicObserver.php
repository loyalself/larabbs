<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    /**
     * 话题保存时进行 xss 过滤和生成摘要
     * @param Topic $topic
     */
    public function saving(Topic $topic)
    {
        /**
         *  问题:
         *  $topic->body = clean($topic->body, 'user_topic_body');
         * 当添加这行代码保存话题时报错:Array and string offset access syntax with curly braces is deprecated:
         *   是因为当前 xss 过滤插件版本不兼容的问题
         */
        //$topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);


        /**
         * 如 slug 字段无内容，即使用翻译器对 title 进行翻译.
         * 在 saving 的过程中,新的模型 id 还未生成,所以队列拿不到数据会抛异常:No query results for model
         * 所以要改到模型保存成功后即将以下代码放到 saved 里
         */
        /*if ( ! $topic->slug) {
            //$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            //改进: 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }*/
    }

    /**
     * 当话题被删除的时候，数据库里的回复信息没有存在的价值，只会占用空间。
     * 所以接下来我们将监听话题删除成功的事件，在此事件发生时，我们会删除此话题下所有的回复
     * @param Topic $topic
     */
    public function deleted(Topic $topic)
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }

    /**
     * 此事件发生在创建和编辑时、数据入库以后。在saved() 方法中调用，确保了我们在分发任务时， $topic->id 永远有值。
     *
     * 需要注意的是， artisan horizon 队列工作的守护进程是一个常驻进程，它不会在你的代码改变时进行重启，
     * 当我们修改代码以后，需要在命令行中对其进行重启操作。
     */
    public function saved(Topic $topic){
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }

    public function updating(Topic $topic)
    {
        if ( ! $topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }
}
