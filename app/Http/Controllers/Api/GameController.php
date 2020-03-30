<?php

namespace App\Http\Controllers\Api;

use App\Game;
use App\Http\Resources\GameResource;
use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;

class GameController
{
    public const MAX_PLAYERS = 4;
    public const MIN_PLAYERS = 2;

    public function show(Game $game): GameResource
    {
        GameResource::withoutWrapping();

        return new GameResource($game);
    }

    public function index()
    {
        return new GamesResource(Game::with('members')->paginate());
    }

    public function store(Request $request)
    {
        //Todo: add validation for existing member: (something like?)
        //, Rule::exists('members')->where(static function($query) use ($request) {
        //                $query->where('id', $request->get('player_1'));
        //            })],
        $request->validate([
            'player_1' => ['required'],
            'player_1_score' => ['required', 'integer'],
            'player_2' => ['required'],
            'player_2_score' => ['required', 'integer'],
        ]);

        $game = Game::create();

        $game->members()->attach($this->getPlayersScoreArray($request));

        return new GameResource($game);
    }

    private function getPlayersScoreArray(Request $request): array
    {
        $playersScoreArray = [];
        for ($i = 1; $i <= self::MAX_PLAYERS + 1; $i++) {
            $player = $request->get("player_{$i}");
            $score = $request->get("player_{$i}_score");
            if ($i <= self::MIN_PLAYERS || isset($player, $score)) {
                //Only add to the array the required minimum players
                //Or any additional ones that are set
                $playersScoreArray[$player] = ['score' => $score];
            }
        }

        return $playersScoreArray;
    }
}
