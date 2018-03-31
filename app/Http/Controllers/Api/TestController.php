<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\RedAllot;

class TestController extends Controller
{
    public function index()
    {
        $users = User::get()->pluck('api_token')->toArray();
        $service = new RedAllot($users, 100, 1, 70);
        $infos = $service->getMoneyInfos();
        return [
            'infos' => $infos,
            'min_key' => collect($infos)->search(collect($infos)->min()),
            'min' => collect($infos)->min(),
            'max' => collect($infos)->max(),
            'sum' => collect($infos)->sum(),
        ];
    }
}
