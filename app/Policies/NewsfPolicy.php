<?php

namespace App\Policies;

use App\Models\User;
use App\Models\newsf;
use Illuminate\Auth\Access\Response;

class NewsfPolicy
{
    
    public function modify(User $user, newsf $news): Response
    {
        return $user->id === $news->user_id 
           ?Response::allow()
           :Response::deny('Not the owner of the posts'); 
    }
}
