<?php

namespace App\Observers;

use App\Models\Topic;

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
         * 当添加这行代码保存话题时报错:Array and string offset access syntax with curly braces is deprecated
         */
        //$topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
}
