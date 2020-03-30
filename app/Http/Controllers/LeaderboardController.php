<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Support\Facades\DB;

class LeaderboardController
{
    public function index()
    {
        $top10Players = DB::table('members')
            ->select('members.*')
            ->selectRaw('COUNT(game_member.member_id) as game_count')
            ->selectRaw('AVG(game_member.score) as average_score')
            ->join('game_member', 'members.id', '=', 'game_member.member_id')
            ->havingRaw('COUNT(game_member.member_id) >= 10')
            ->orderByRaw('AVG(game_member.score) DESC')
            ->groupBy('members.id')
            ->get()
        ;

        return view('leaderboard.leaderboard', [
            'top10Players' => $top10Players,
            'bestScore' => $this->bestScoredGame(),
            'worstScore' => $this->worstScoredGame(),
        ]);
    }

    private function bestScoredGame()
    {
        return $this->firstGameByScore('DESC');
    }

    private function worstScoredGame()
    {
        return $this->firstGameByScore('ASC');
    }

    private function firstGameByScore(string $orderBy)
    {
        //TODO: this would need changing for the games if we allow more than 2 members

        return DB::table('game_member')
            ->select('game_member.*')
            ->addSelect('members.*')
            ->addSelect(['gm2.member_id as opponent_id', 'gm2.score as opponent_score'])
            ->addSelect(['m2.name as opponent_name'])
            ->join('members', 'members.id', '=', 'game_member.member_id')
            ->join('game_member as gm2', static function($join) {
                $join->on('gm2.game_id', '=', 'game_member.game_id')
                    ->whereRaw('gm2.member_id != game_member.member_id')
                    //Todo: I'd rather use the below but the last param seems to be converted to string?
                    //->where('gm2.member_id', '!=', 'game_member.member_id')
                ;
            })
            ->join('members as m2', 'm2.id', '=', 'gm2.member_id')
            ->orderBy('game_member.score', $orderBy)
            ->limit(1)
            ->first()
        ;
    }
}
