<?php

namespace App;

trait VotableTrait
{
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function DownVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}