<?php

namespace App;

enum Role: string
{
    case SuperAdmin = "super_admin";
    case Admin = "admin";
    case Member = "member";

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => "Super Admin",
            self::Admin => "Admin",
            self::Member => "Member",
        };
    }

    public static function invitable(): array
    {
        return [self::Admin, self::Member];
    }
}
