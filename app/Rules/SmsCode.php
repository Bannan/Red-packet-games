<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use PhpParser\Node\Scalar\String_;

class SmsCode implements Rule
{
    private $fn;

    /**
     * SmsCode constructor.
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
        $key = Request::getClientIp() . $this->fn . $value;
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
