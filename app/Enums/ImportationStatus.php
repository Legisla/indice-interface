<?php

namespace App\Enums;

enum ImportationStatus: string
{
    case STARTED = 'started';

    case FINISHED = 'finished';

    case CANCELED = 'canceled';

    case FAILED = 'failed';
}
