<?php

namespace App\Services\Resources;

use App\Models\Front;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;

class FrontsService
{

    private $requesterService;

    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }

    public function process()
    {
        $fronts = $this->requesterService->getFronts();

        if ($fronts) {

            Front::setAllInactive();

            $this->importService->startProgressBar(count($fronts));
            foreach ($fronts as $front) {
                $this->processIndividualFront($front);
                $this->importService->advanceProgressBar();
            }
            $this->importService->finishProgressBar();
        } else {
            $this->importService->report('no fronts found', 'warn');
        }
    }


    public function processIndividualFront($front)
    {
        $details = $this->requesterService->getFrontDetails($front->id);

        Front::updateOrCreateByExternalId(
            $front->id,
            $details['coordenador']->id
        );
    }

}
