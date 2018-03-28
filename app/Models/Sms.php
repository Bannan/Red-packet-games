<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $guarded = [];

    protected $casts = [
        'vars' => 'array',
        'result' => 'object',
    ];
}
