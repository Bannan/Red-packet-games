<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RedPrice as RedPriceResource;
use App\Models\Screening;

class ScreeningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function packets(Screening $screening)
    {
        return RedPriceResource::collection($screening->red_prices);
    }
}
