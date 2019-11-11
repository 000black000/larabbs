<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class a extends Command
{
    /**
     * 供我们调用的命令
     *
     * @var string
     */
    protected $signature = 'command:name';//'larabbs:calculate-active-user

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 最终执行的方法.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
