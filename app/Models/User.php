<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'robot' => 'boolean',
        'balance' => 'double',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'robot', 'balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'openid', 'safety_code', 'robot'
    ];

    /**
     * 上级成员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * 所有上级成员
     * @return \Illuminate\Support\Collection
     */
    public function parentAll()
    {
        return $this->link_id ? static::whereIn('id', explode(',', $this->link_id))->get() : collect();
    }

    /**
     * 下级成员
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * 获取所有下级
     * @return mixed
     */
    public function childrenAll()
    {
        return static::whereRaw('find_in_set(?, `link_id`)', $this->id)->get();
    }

    /**
     * 用户的对战记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function battles()
    {
        return $this->hasMany(Battle::class);
    }

    /**
     * 用户流水金额包括下级
     * @return mixed
     */
    public function allFlowingWater()
    {
        return Battle::whereRaw('user_id in (select id from users where find_in_set(?, `link_id`))', $this->id)->sum('result_real');
    }
}
