<?php

namespace App\Services\Resources;

use App\Models\Congressperson;
use App\Models\Proposition;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;

class PropositionsService
{
    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }

    public function process(): void
    {
        $congresspeople = Congressperson::getAllCurrent();
        $count = 0;
        $total = $congresspeople->count();
        $congresspeople->each(function ($congressperson)  use (&$count,$total){
            $count++;
            $this->importService->report(
                'starting congressperson '.$congressperson->external_id. ' ('.$count.'/'.$total.')',
                'alert'
            );
            $this->processCongressPersonPropositions($congressperson);
        });
    }

    public function processCongressPersonPropositions(Congressperson $congressperson): void
    {
        $lastProposition = Proposition::getLastFromCongressperson($congressperson);

        if($lastProposition) {
            $targetMonth = $lastProposition->searched_month_start;
        } else {
            $targetMonth = $this->importService->importation->legislature_start;
        }

        $endOfMonth = $targetMonth->copy()->addMonth();

        $total = 0;
        while ($targetMonth->diffInMonths(Carbon::now()->addMonth())) {
            $this->importService->report(
                'congressperson '.$congressperson->external_id. ': importing propositons from ' .
                $targetMonth->format('d/m/Y') . ' to ' . $endOfMonth->format('d/m/Y'),

            );

            $propositions = (new RequesterService())->getPropositionDataByCongresspersonByDateRange(
                $congressperson->external_id,
                $targetMonth,
                $endOfMonth
            );

            if($propositions){
                $total += count($propositions);

                $this->importService->startProgressBar(count($propositions));

               foreach($propositions as $proposition){
                  $savedProposition = $this->processIndividualProposition($proposition, $targetMonth);
                  $this->registerPropositionCognressperson($savedProposition, $congressperson);
                    $this->importService->advanceProgressBar();
               }
                $this->importService->finishProgressBar();

            }else{
                $this->importService->report('congressperson '.$congressperson->external_id. ': no propositions found in the target period ',
                    'warn'
                );
            }

            $targetMonth->addMonth();
            $endOfMonth = $targetMonth->copy()->addMonth();
        }

        $this->importService->report(
            $total . ' propositions imported'
        );
    }

    public function processIndividualProposition( array $proposition, Carbon $searchedMonth)
    {
        if( $foundProposition = Proposition::getByExternalId($proposition['id']) ){
            return $foundProposition;
        }

        $requesterService = (new RequesterService());


       return Proposition::create([
            'external_id' => $proposition['id'],
            'uri' => $proposition['uri'],
            'acronymType' => $proposition['siglaTipo'],
            'typeCode' => $proposition['codTipo'],
            'number' => $proposition['numero'],
            'year' => $proposition['ano'],
            'menu' => $proposition['ementa'],
            'details' => $requesterService->getPropositionDetails($proposition['id']),
            'authors' => $requesterService->getPropositionAuthors($proposition['id']),
            'themes' => $requesterService->getPropositionThemes($proposition['id']),
            'searched_month_start' => $searchedMonth->format('Y-m-d'),
        ]);
    }

    public function registerPropositionCognressperson(Proposition $proposition, Congressperson $congressperson)
    {
        if(!$proposition->checkIfIsRelated($congressperson)){
            $proposition->congressperson()->attach($congressperson->id);
        }
    }


}
