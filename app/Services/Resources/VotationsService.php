<?php

namespace App\Services\Resources;

use App\Models\Votation;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;

class VotationsService
{
    private $requesterService;

    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }

    public function process(): void
    {
        if (!$dateStart = Votation::getLastDate()) {
            $dateStart = $this->importService->importation->legislature_start;
        }

        $dateStart->startOfMonth();
        $dateEnd = $dateStart->copy()->endOfMonth();

        $this->importService->report(
            'importing votations from ' . $dateStart->format('d/m/Y').
            ' in a total of '. $dateStart->diffInMonths(Carbon::now()->addMonth()) . ' months'
        );

        $total = 0;
        while ($dateStart->diffInMonths(Carbon::now()->addMonth())) {

            $this->importService->report(
                'importing votations from ' . $dateStart->format('d/m/Y') . ' to ' . $dateEnd->format('d/m/Y')
            );

            $votations = $this->requesterService->getVotations($dateStart, $dateEnd);
            if ($votations) {
                $total += count($votations);

                $this->importService->startProgressBar(count($votations));

                foreach ($votations as $votation) {
                    $this->processIndividualVotation($votation, $dateStart);
                    $this->importService->advanceProgressBar();
                }

                $this->importService->finishProgressBar();
            }else{
                $this->importService->report('no votations found in the target period ',
                    'warn'
                );
            }

            $dateStart->addMonth()->startOfMonth();
            $dateEnd = $dateStart->copy()->endOfMonth();
        }

        $this->importService->report(
             $total . ' imported votations'
        );
    }

    /**
     * @param array          $votation
     * @param Carbon $searchDate
     * @return void
     */
    public function processIndividualVotation(array $votation, Carbon $searchDate)
    {
        if (Votation::findByExternalId($votation['id'])) {
            return;
        }

        $votesList = $this->requesterService->getVotationVotes($votation['id']);

//        $orientationList = [];$this->requesterService->getVotationOrientations($votation['id']);

        $votes = [];
        $votesList && $votesList->each(function ($item) use (&$votes) {
            $votes[$item->deputado_->id] = $item->tipoVoto;
        });

        $orientations = [];
//        $orientationList && $orientationList->each(function ($item) use (&$orientations) {
//            $orientations[$item->codPartidoBloco] = $item->orientacaoVoto;
//        });

        Votation::create([
            'external_id' => $votation['id'],
            'votes' => json_encode($votes),
            'orientations' => json_encode($orientations),
            'searched_date' => $searchDate
        ]);
    }

}
