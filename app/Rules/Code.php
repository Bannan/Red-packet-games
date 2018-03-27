<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class Code implements Rule
{
    private $fn;

    /**
     * Code constructor.
     * @param String $fn
     */
    public function __construct(String $fn)
    {
        $this->fn = $fn;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $key = Request::getClientIp() . $this->fn;
        if (Cache::get($key) == $value) {
            Cache::forget($key);
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '验证码 错误。';
    }
}
