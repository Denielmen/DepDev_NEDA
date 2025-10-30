<?php

namespace App\Helpers;

class AdminHelper
{
    /**
     * Check if the current authenticated user is a read-only admin
     */
    public static function isReadOnlyAdmin(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $readOnlyAdmins = ['Admin_Jennifer', 'Admin_Evelyn'];
        return in_array(auth()->user()->user_id ?? '', $readOnlyAdmins);
    }
}
