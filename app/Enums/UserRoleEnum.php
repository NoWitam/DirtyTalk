<?php

namespace App\Enums;

enum UserRoleEnum : int {
    case ADMIN = 1;
    case USER = 2;

    public function label() : string
    {
        return match($this) {
            static::USER => "Użytkownik",
            static::ADMIN => "Administrator"
        };
    }
}