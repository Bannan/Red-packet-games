<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\RedAllot;

class TestController extends Controller
{
    public function index()
    {
        $users = User::all();
        $service = new RedAllot($users, 100, 1, 70);
        return $service->getData();
    }
}
