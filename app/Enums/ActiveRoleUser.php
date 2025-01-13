<?php

namespace App\Enums;

enum ActiveRoleUser: string
{
    case Teacher = 'teacher';

    public function label(): string
    {
        return match ($this) {
            ActiveRoleUser::Teacher => 'Professor',
        };
    }
}
