<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Notifications\TopicReplied;
use App\Notifications\AtUser;

class ReplyNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reply;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 通知被艾特的人
        $name = array_unique(get_between($this->reply->content, '@', ' '));

        empty($name) ?
            $this->newReply()
            :
            $this->newAT($name);
    }

    public function newAT($name)
    {
        $content = $this->reply->content;
        $users = $this->reply->user->whereIn('name', $name)->get();
        if(!empty($users)) {
            foreach ($users as $key => $user) {
                $link = route('users.show', $user->id);
                $replace = "<a href=" . $link . ">" .$user->name . "</a>";
                $content = str_ireplace($user->name, $replace, $content);

                // 通知被@的人
                $this->reply->noticeUser(new AtUser($this->reply), $user->id);
            }
        }
        \DB::table('replies')->where('id', '=', $this->reply->id)->update(['content' => $content]);
    }

    public function newReply()
    {
        // 通知话题作者有新的评论
        $this->reply->topic->user->updateIncrementCount(new TopicReplied($this->reply));
    }
}
