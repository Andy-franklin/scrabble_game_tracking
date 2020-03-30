<?php

namespace App\Http\Controllers;

use App\Game;
use App\Member;
use Illuminate\Http\Request;

class GameController
{
    public const MAX_PLAYERS = 4;
    public const MIN_PLAYERS = 2;

    public function show(Game $game)
    {
        return view('game.single', ['game' => $game]);
    }

    public function index()
    {
        $games = Game::all();

        return view('game.index', ['games' => $games]);
    }

    public function create()
    {
        $members = Member::all();

        return view('game.create', ['members' => $members]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_1' => 'required',
            'player_1_score' => 'required',
            'player_2' => 'required',
            'player_2_score' => 'required',
        ]);

        $game = Game::create();

        $game->members()->attach($this->getPlayersScoreArray($request));

        return redirect('/game')->with('success', 'Game Saved');
    }

    public function edit(Game $game)
    {
        $members = Member::all();

        return view('game.update', ['game' => $game, 'members' => $members]);
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'player_1' => 'required',
            'player_1_score' => 'required',
            'player_2' => 'required',
            'player_2_score' => 'required',
        ]);

        $game->members()->sync($this->getPlayersScoreArray($request));

        return redirect('/game')->with('success', 'Game Saved');
    }

    public function destroy()
    {
        //@TODO:
    }

    private function getPlayersScoreArray(Request $request): array
    {
        $playersScoreArray = [];
        for ($i = 0; $i <= self::MAX_PLAYERS; $i++) {
            $player = $request->get("player_{$i}");
            $score = $request->get("player_{$i}_score");
            if ($i <= self::MIN_PLAYERS - 1 || isset($player, $score)) {
                //Only add to the array the required minimum players
                //Or any additional ones that are set
                $playersScoreArray[$player] = ['score' => $score];
            }
        }

        return $playersScoreArray;
    }
}
