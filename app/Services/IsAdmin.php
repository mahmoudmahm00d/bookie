<?php

namespace App\Services;

use App\Models\User;

class IsAdmin
{
    public static function check($user)
    {
        if (!$user || !$user->id) {
            return false;
        }

        return $user->id == 1;
    }
}
