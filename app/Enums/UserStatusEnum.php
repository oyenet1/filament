<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = "active";
    case BLOCKED = "blocked";
    case ONLEAVE = "onleave";
    case SACKED = "sacked";
    case RETIRED = "retired";
}
