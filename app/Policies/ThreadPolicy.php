<?php

namespace App\Policies;

use App\Thread;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Thread $thread)
    {
        
        return $user->id === $thread->user_id
                    ? Response::allow()
                    : Response::deny('You are not authorize ! ! !');
    }

    public function delete(User $user, Thread $thread)
    {
        
        return $user->id === $thread->user_id
                    ? Response::allow()
                    : Response::deny('You are not authorize ! ! !');
    }
}
