<?php

namespace App\Enums;

enum StudentStatusEnum: string
{
    case ACTIVE = "active";
    case RUSTICATED = "rusticated";
    case GRADUATED = "graduated";
    case BLOCKED = "blocked";
}
