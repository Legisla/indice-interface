<?php

namespace App\Enums;

enum Initiator: string
{
    case CONSOLE = 'console';

    case CRON = 'cron';

    case WEB = 'web';
}
