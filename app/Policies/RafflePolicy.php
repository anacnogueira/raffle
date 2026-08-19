<?php

namespace App\Policies;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RafflePolicy
{
    /**
     * Determine whether the user can view unpublished raffles.
     */
    public function onlyPublished(?User $user, Raffle $raffle): bool
    {
        if ($user?->admin) {
            return true;
        }

        return filled($raffle->published_at);
    }

     /**
     * Determine whether the user can view draw an winner for the raffle.
     */
    public function drawWinner(?User $user, Raffle $raffle): bool
    {
        return !! $user?->admin;
    }
}
