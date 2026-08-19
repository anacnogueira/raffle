<?php

namespace App\Policies;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RafflePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function onlyPublished(?User $user, Raffle $raffle): bool
    {
        if ($user?->admin) {
            return true;
        }

        return filled($raffle->published_at);
    }

}
