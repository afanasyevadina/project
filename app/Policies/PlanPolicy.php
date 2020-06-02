<?php

namespace App\Policies;

use App\User;
use App\Plan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if(in_array($user->role, ['admin', 'manager'])) {
            return true;
        }
    }

    public function update(User $user, Plan $plan)
    {
        return $user->person_id == $plan->teacher_id;
    }

}
