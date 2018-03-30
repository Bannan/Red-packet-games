<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/30
 * Time: 16:06
 */

namespace App\Service;


class RedAllot
{
    // 红包信息
    private $reds = [];

    /**
     * RedAllot constructor.
     * @param array $users
     * @param float $price
     * @param float $min
     */
    public function __construct(array $users, float $price, float $min)
    {
        $this->allot($users, $price, $min);
    }

    /**
     * 计算用户所得红包金额
     * @param array $users
     * @param float $price
     * @param float $min
     */
    public function allot(array $users, float $price, float $min)
    {
        $people = count($users) - 1;
        $no_people = $people;
        $data = [];
        for ($i = 0; $i <= $people; $i++) {
            if ($people == $i) {
                $data[$users[$i]] = round($price, 2);
            } else {
                $data[$users[$i]] = round($this->randFloat($min, $this->qujian($price, $no_people)), 2);
                $price = $price - $data[$users[$i]];
                $no_people--;
            }
        }
        $this->reds = $data;
    }

    /**
     * 返回红包信息
     * @return array
     */
    public function getAllotInfo(): array
    {
        return $this->reds;
    }

    /**
     * 取区间
     * @param $number1
     * @param $number2
     * @return float
     */
    protected function qujian($number1, $number2)
    {
        return round($number1 / $number2, 2);
    }

    /**
     * 取小数
     * @param int $min
     * @param int $max
     * @return float|int
     */
    protected function randFloat($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}