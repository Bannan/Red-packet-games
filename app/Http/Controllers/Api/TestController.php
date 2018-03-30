<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\RedAllot;

class TestController extends Controller
{
    public function index()
    {
        $users = User::limit(5)->get()->pluck('api_token')->toArray();
        $service = new RedAllot($users, 10, 0.1);
        $infos = $service->getAllotInfo();
        return [
            'infos' => $infos,
            'min_key' => collect($infos)->min(),
            'min' => collect($infos)->min(),
            'max' => collect($infos)->max(),
        ];
    }
}
