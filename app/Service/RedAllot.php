<?php

namespace App\Service;


use Illuminate\Support\Collection;

class RedAllot
{
    private $users;
    private $money;
    private $min;
    private $max;

    /**
     * RedAllot constructor.
     * @param Collection $users
     * @param float $money
     * @param float $min
     * @param float $max
     * @throws \Exception
     */
    public function __construct(Collection $users, float $money, float $min, float $max)
    {
        $this->users = $users;
        $this->money = $money;
        $this->min = $min;
        $this->max = $max;

        $this->allotRed();
    }

    /**
     * 返回数据
     * @return Collection
     */
    public function getData() : Collection
    {
        return $this->users;
    }

    /**
     * 分配红包
     */
    protected function allotRed()
    {
        $num = $this->users->count();

        throw_if($this->min * $num > $this->money || $this->max * $num < $this->money,
            \Exception::class,
            '红包参数配置错误'
        );

        while ($num >= 1) {
            $num--;
            $kmix = max($this->min, $this->money - $num * $this->max);
            $kmax = min($this->max, $this->money - $num * $this->min);
            $kAvg = $this->money / ($num + 1);
            $kDis = min($kAvg - $kmix, $kmax - $kAvg);
            $r = ((float)(rand(1, 10000) / 10000) - 0.5) * $kDis * 2;
            $k = round($kAvg + $r, 2);
            $this->money -= $k;
            $this->users[$num]->price = $k;
        }
    }

}