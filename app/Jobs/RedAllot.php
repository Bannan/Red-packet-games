<?php

namespace App\Jobs;

use App\Models\Battle;
use App\Models\RedPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use App\Service\RedAllot as Service;
use Illuminate\Support\Facades\DB;

class RedAllot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 用户
     * @var
     */
    public $users;

    /**
     * 红包房间id
     * @var
     */
    public $rid;

    /**
     * 玩法 大 、小
     * @var
     */
    public $type;

    /**
     * Create a new job instance.
     *
     * RedAllot constructor.
     * @param Collection $users
     * @param int $rid
     * @param string $type
     */
    public function __construct(Collection $users, int $rid, string $type)
    {
        $this->users = $users;
        $this->rid = $rid;
        $this->type = $type;
    }

    /**
     * Execute the job.
     * @throws \Exception
     * @throws \Throwable
     */
    public function handle()
    {
        // 查找红包玩法
        $red = RedPrice::findOrFail($this->rid);

        // 红包分配算法
        $service = new Service($this->users, $this->rid, $red->min, $red->min);

        // 红包分配数据 $user->price
        $users = $service->getData();

        // 事物处理
        DB::transaction(function () use ($users, $red) {
            foreach ($users as $user) {
                // 记录用户红包记录
                $user->battles->create([
                    'red_price_id' => $this->rid,
                    'type' => $this->type,
                    'result' => $users->price,
                    'result_real' => round($users->price - ($red->service_fee / 100 * $users->price), 2)
                ]);
            }
        });

        // 通知本批用户红包发放完成
        RedCompleteNotice::dispatch($users);
    }
}
