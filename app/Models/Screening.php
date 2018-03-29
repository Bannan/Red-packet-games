<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Screening extends Model
{

    protected $guarded = [];

    /**
     * 所属游戏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * 红包金额列表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function red_prices()
    {
        return $this->hasMany(RedPrice::class);
    }

    /**
     * 转化缩略图地址
     * @param $thumb
     * @return string
     */
    protected function getThumbAttribute($thumb)
    {
        return asset(Storage::url($thumb));
    }
}
