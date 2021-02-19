<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    /**
     * 当有新的评论(回复)时,评论数(回复数)加1
     * @param Reply $reply
     */
    public function created(Reply $reply)
    {
        //$reply->topic->increment('reply_count', 1);
        //改进:
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    /**
     * 过滤 xss 攻击
     * @param Reply $reply
     */
    public function creating(Reply $reply)
    {
        //$reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }
}
