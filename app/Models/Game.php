<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    /**
     * 游戏场次
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
