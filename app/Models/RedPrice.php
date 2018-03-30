<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RedPrice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'double',
    ];

    /**
     * 所属场次
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screening()
    {
        return $this->belongsTo(Screening::class);
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
