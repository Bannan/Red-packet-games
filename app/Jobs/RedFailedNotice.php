<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class RedFailedNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;

    /**
     * 给用户发送失败通知队列
     * RedFailedNotice constructor.
     * @param Collection $users
     */
    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * 执行给用户发送失败通知
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            // 调用 workman 通知 $user->api_token 即可
        }
    }
}
