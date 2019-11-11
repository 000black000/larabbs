<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

class Reply extends Model
{
    use Notifiable;

    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //自己艾特自己 的 这种情况，不给予通知
    public function noticeUser($instance, $at_id)
    {
        if ($this->user_id != $at_id) {
            User::where('id', '=', $at_id)->increment('notification_count'); // 未读消息+1
            $user = User::where('id', '=', $at_id)->first(); // 返回被@的人的用户实例
            $user->notify($instance); // 当通过 mail 频道来发送通知的时候，通知系统将会自动寻找你的 notifiable 实体中的 email 属性
        }
    } 
}
