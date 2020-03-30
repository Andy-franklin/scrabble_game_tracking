<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class)->withPivot('score');
    }

    public function opponents(Member $member): BelongsToMany
    {
        return $this
            ->members()
            ->where('member_id', '!=', $member->id)
        ;
    }

    public function winner(): Member
    {
        $winner = null;
        foreach ($this->members()->get() as $member) {
            if (null === $winner) {
                $winner = $member;
            }

            $currentScore = $member->pivot->score;

            if ($currentScore > $winner->pivot->score) {
                $winner = $member;
            }
        }

        return $winner;
    }
}
