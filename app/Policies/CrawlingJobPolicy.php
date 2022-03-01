<?php

namespace App\Policies;

use App\Models\CrawlingJob;
use App\Models\SSO\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrawlingJobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\SSO\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // sure no prob?
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\SSO\User  $user
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CrawlingJob $crawlingJob)
    {
        // if it's an admin or owner
        return $user->hasRole('administrator') || $crawlingJob->user->id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\SSO\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // sure
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\SSO\User  $user
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CrawlingJob $crawlingJob)
    {
        // owner or admin
        return $user->hasRole('administrator') || $crawlingJob->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\SSO\User  $user
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CrawlingJob $crawlingJob)
    {
        // owner or admin
        return $user->hasRole('administrator') || $crawlingJob->user->id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\SSO\User  $user
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CrawlingJob $crawlingJob)
    {
        // admin only
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\SSO\User  $user
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CrawlingJob $crawlingJob)
    {
        // admin only
        return $user->hasRole('administrator');
    }
}
