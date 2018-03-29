<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Http\Resources\Screening as ScreeningResource;

class GameController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Game::all();
    }

    public function screenings(Game $game)
    {
        return ScreeningResource::collection($game->screenings);
    }
}
