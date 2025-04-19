<?php

namespace App\Policies;

use App\Models\User;
use App\Models\posts;
use Illuminate\Auth\Access\Response;

class PostsPolicy
{
    public function modify(User $user, posts $posts): bool
    {
        return false;
    }
}
