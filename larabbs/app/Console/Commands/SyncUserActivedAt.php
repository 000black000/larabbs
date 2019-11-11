<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SyncUserActivedAt extends Command
{
    protected $signature = 'larabbs:sync-user-actived-at';
    protected $description = '将用户最后登录时间从 Redis 同步到数据库中';

    public function handle(User $user)
    {
        $user->syncUserActivedAt(); //执行的方法，把昨天存在redis的数据（用户最后活跃时间），存进数据库表，并清空前一天的 redis 数据
        $this->info("同步成功！");
    }
}
