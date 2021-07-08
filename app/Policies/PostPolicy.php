<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function view( User $user,Post $post ){
        if($post->user_id === $user->id){
            return true;
        }
        return false;
    }

    public function show($user,$post ){
        
        return $post->user_id === $user->id;
    }
}

