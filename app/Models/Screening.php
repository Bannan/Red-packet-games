<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
