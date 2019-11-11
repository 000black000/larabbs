<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body'); //我们引入了插件：HTMLPurifier user_topic_body 是我们为话题内容定制的。在 config/purifier.php 里面配置的

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容,或者属性被更改（针对用户修改帖子标题的情况），即使用翻译器对 title 进行翻译
        // 用 isDirty () 去判断一个模型或者给定的属性是否被更改了
        if ( empty($topic->slug) || $topic->isDirty('title') ) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}