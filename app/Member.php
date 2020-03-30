<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    private $wins = null;

    private $losses = null;

    protected $fillable = [
        'name',
        'bio',
        'phone_number',
        'email',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withPivot('score');
    }

    public function getWins(): int
    {
        if (null === $this->wins) {
            $this->getWinsAndLosses();
        }

        return $this->wins;
    }

    public function getLosses(): int
    {
        if (null === $this->losses) {
            $this->getWinsAndLosses();
        }

        return $this->losses;
    }

    public function averageScore(): int
    {
        if ($this->games()->count() === 0) {
            return 0;
        }

        return $this->games()->sum('score') / $this->games()->count();
    }

    public function bestMatch()
    {
        $bestGame = null;

        /** @var Game $game */
        foreach ($this->games()->get() as $game) {
            if (null === $bestGame) {
                $bestGame = $game;
            }

            if ($game->score > $bestGame->score) {
                $bestGame = $game;
            }
        }

        return $bestGame;
    }

    private function getWinsAndLosses(): void
    {
        $wins = 0;
        $losses = 0;

        /** @var Game $game */
        foreach ($this->games()->get() as $game) {
            if ($game->winner()->id === $this->id) {
                $wins++;
            } else {
                $losses++;
            }
        }

        $this->wins = $wins;
        $this->losses = $losses;
    }
}
