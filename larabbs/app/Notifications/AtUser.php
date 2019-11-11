<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\Reply;

class AtUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->reply->topic->link(['#reply' . $this->reply->id]);
        return (new MailMessage)
                    ->line($this->reply->user->name . ' 在 ' . $this->reply->topic->title . ' 的评论中提及到你')
                    ->action('点击查看', $url);
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_name'        => $this->reply->user->name,
            'user_id'          => $this->reply->user->id,
            'user_avatar'      => $this->reply->user->avatar,
            'topic_title'      => $this->reply->topic->title,
            'topic_url'        => $this->reply->topic->link(['#reply' . $this->reply->id]),
            'reply_content'    => $this->reply->content,
            'reply_created_at' => $this->reply->created_at,
        ];
    }
}
