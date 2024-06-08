<?php

namespace App\Enums;

enum ProjectStatus: int
{
    case TODO = 1;
    case IN_PROGRESS = 2;
    case DONE = 3;
}
