<?php

namespace App\Jobs;

use Exception;
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
            // $this->type = max | min
            $price_minus = $users->{$this->type}('price');

            foreach ($users as $user) {
                // 找出这个输掉的用户, 扣除系统发送的红包金额
                if ($user->price === $price_minus) {
                    $user->balance -= $red->value;
                }

                // 计算扣除手续费后的收益
                $price_add = round($users->price - ($red->service_fee / 100 * $users->price), 2);

                // 用户余额增加
                $user->balance += $price_add;
                $user->save();

                // 记录用户红包记录
                $user->battles->create([
                    'red_price_id' => $this->rid,
                    'type' => $this->type,
                    'result' => $users->price,
                    'result_real' => $price_add,
                ]);
            }
        });

        // 通知本批用户红包发放完成
        RedCompleteNotice::dispatch($users);
    }

    /**
     * 给用户发送失败通知.
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        foreach ($this->users as $user) {
            // 调用 workman 通知 $user->api_token 失败
        }
    }
}
