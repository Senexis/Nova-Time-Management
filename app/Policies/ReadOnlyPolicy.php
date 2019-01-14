<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class ReadOnlyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the word press post.
     *
     * @param  \App\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create word press posts.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the word press post.
     *
     * @param  \App\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the word press post.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the word press post.
     *
     * @param  \App\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the word press post.
     *
     * @param  \App\User $user
     *
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}