<?php

namespace App\Services\Resources;

use App\Services\ImportService;
use App\Services\RequesterService;

class PositionsService
{
    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }

    public function process()
    {

    }

}
