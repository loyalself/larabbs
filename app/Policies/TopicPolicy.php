<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    /**
     * 只允许作者对话题有编辑权限
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic)
    {
        //return $topic->user_id == $user->id;
        return $user->isAuthorOf($topic);  //优化
    }
    //只允许作者对话题有删除权限
    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
