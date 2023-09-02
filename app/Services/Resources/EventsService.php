<?php

namespace App\Services\Resources;

use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;
use App\Models\Event;

class EventsService
{
    private $requesterService;

    public function __construct(private ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }


    public function process()
    {
        if (!$dateStart = Event::getLastDate()) {
            $dateStart = $this->importService->importation->legislature_start;
        }

        $dateEnd = $dateStart->copy()->addMonth();

        $this->importService->report(
            'importing events from ' . $dateStart->format('d/m/Y') .
            ' in a total of ' . $dateStart->diffInMonths(Carbon::now()->addMonth()) . ' months'
        );

        $total = 0;
        while ($dateStart->diffInMonths(Carbon::now()->addMonth())) {

            $this->importService->report(
                'importing events from ' . $dateStart->format('d/m/Y') . ' to ' . $dateEnd->format('d/m/Y')
            );

            $events = $this->requesterService->getEventsByRange($dateStart, $dateEnd);
            if ($events) {
                $total += count($events);
                $this->importService->startProgressBar(count($events));

                foreach ($events as $event) {
                    $this->processIndividualEvent($event, $dateStart);
                    $this->importService->advanceProgressBar();
                }

                $this->importService->finishProgressBar();
            } else {
                $this->importService->report('no events found in the target period ',
                    'warn'
                );
            }

            $dateStart->addMonth();
            $dateEnd = $dateStart->copy()->addMonth();
        }

        $this->importService->report(
            $total . ' imported events'
        );
    }


    public function processIndividualEvent(array $event, Carbon $searchDate)
    {
        if (Event::findByExternalId($event['id'])) {
            return;
        }

        $presenceList = $this->requesterService->getEventPresence($event['id']);

        $presence = [];
        if ($presenceList) {
            $presenceList->each(function ($item) use (&$presence) {
                $presence[] = $item->id;
            });
        }

        Event::create([
            'external_id' => $event['id'],
            'presence' => json_encode($presence),
            'searched_date' => $searchDate
        ]);
    }


}
