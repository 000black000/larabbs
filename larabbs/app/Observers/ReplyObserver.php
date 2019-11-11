<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

use App\Jobs\ReplyNotice;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();

        dispatch(new ReplyNotice($reply));// 使用队列，来发送‘回复话题’ 的 ‘消息通知’
    }

    public function creating(Reply $reply)
    {
        //加上空格的原因是：如果在回复末尾艾特某人，后面不追加内容。会出现查看不了个人信息的bug。因为：会执行 trim 全局中间件所以会导致过滤掉了 (@Jourdon) 后面追加的空格，导致正则表达式无法匹配，导致无法点击查看被艾特的人的个人信息
        //所以在全局中间件 trim 过滤后，再在结尾补上空格，就行了
        $reply->content = clean($reply->content . ' ', 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        //删除评论 帖子的回复数也要相应减少
        $reply->topic->updateReplyCount();
    }
}
