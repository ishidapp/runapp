<?php

namespace App\Policies;

use App\User;
use App\Record;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
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

    public function view(User $user, Record $record) {
        return $user->id === $record->user_id;
    }
}
