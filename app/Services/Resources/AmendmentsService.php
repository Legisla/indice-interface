<?php

namespace App\Services\Resources;

use App\Models\Amendment;
use App\Models\Congressperson;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;
use App\Helpers\Format;

class AmendmentsService
{
    private $requesterService;

    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }


    public function process()
    {
        $dateStart = $this->importService->importation->legislature_start;
        $dateEnd = $this->importService->importation->legislature_end;

        $this->importService->report("Importing amendments for the period between " . $dateStart->format('Y') .
            " and " . $dateEnd->format('Y') . ' Memory usage: ' . show_memory());

        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function (Congressperson $congressperson) use ($dateStart, $dateEnd) {

                if (config('source.processment.debug_memory')) {
                    $this->importService->report('Importing amendments of congressperson id ' . $congressperson->id . ' Memory usage: ' . show_memory());
                }

                $amendments = $this->requesterService->getAmendments(
                    str_replace(' ', '+', $congressperson->name),
                    $dateStart,
                    $dateEnd,
                );

                $amendments = Format::parseCsvStringToArray($amendments);

                $total = 0.00;
                foreach ($amendments as $amendment) {
                    $total += Format::convertNumberToIso($amendment['Valor pago']);
                };

                Amendment::updateOrCreate(
                    $congressperson->id,
                    $total
                );
            });
    }

}
