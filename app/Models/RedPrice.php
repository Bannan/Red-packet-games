<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedPrice extends Model
{
    protected $guarded = [];

    /**
     * 所属场次
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screening()
    {
        return $this->belongsTo(Screening::class);
    }
}
