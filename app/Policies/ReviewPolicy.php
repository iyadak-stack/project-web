<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function update(User $user, Review $review): bool
    {
        if ($user->current_role === 'admin') {
            return true;
        }

        return $review->appointment?->studentProfile?->user_id
            === $user->user_id;
    }

    public function delete(User $user, Review $review): bool
    {
        if ($user->current_role === 'admin') {
            return true;
        }

        return $review->appointment?->studentProfile?->user_id
            === $user->user_id;
    }
}