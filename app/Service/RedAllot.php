<?php

namespace App\Service;


class RedAllot
{
    private $reds = [];

    /**
     * RedAllot constructor.
     * @param array $users
     * @param float $money
     * @param float $min
     * @param float $max
     */
    public function __construct(array $users, float $money, float $min, float $max)
    {
        $this->allot($users, $money, $min, $max);
    }


    /**
     * 返回多个用户抢的红包信息
     * @return array
     */
    public function getMoneyInfos(): array
    {
        return $this->reds;
    }


    /**
     * 红包分配方法
     * @param array $users
     * @param float $money
     * @param float $min
     * @param float $max
     * @return array
     */
    function allot(array $users, float $money, float $min, float $max)
    {
        $num = count($users);
        if ($min * $num > $money) {
            return [];
        }
        if ($max * $num < $money) {
            return [];
        }
        while ($num >= 1) {
            $num--;
            $kmix = max($min, $money - $num * $max);
            $kmax = min($max, $money - $num * $min);
            $kAvg = $money / ($num + 1);
            $kDis = min($kAvg - $kmix, $kmax - $kAvg);
            $r = ((float)(rand(1, 10000) / 10000) - 0.5) * $kDis * 2;
            $k = round($kAvg + $r, 2);
            $money -= $k;
            $this->reds[$users[$num]] = $k;
        }
    }

}