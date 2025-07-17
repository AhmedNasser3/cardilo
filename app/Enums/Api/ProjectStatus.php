<?php

namespace App\Enums\Api;

enum ProjectStatus: string
{
    case ACTIVE = 'Active';
    case PREVIEW = 'preview';
    case PROGRESSING = 'progressing';
    case CANCELLED = 'cancelled';
    case CLOSED = 'closed';
}