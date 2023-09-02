<?php

namespace App\Services\Resources;

use App\Models\Body;
use App\Models\Congressperson;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;

class BodiesService
{
    private RequesterService $requesterService;

    public function __construct(private readonly ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }

    public function process(): void
    {
        $dateStart = $this->importService->importation->legislature_start;

        $bodies = $this->requesterService->getBodies(
            $dateStart,
            $dateStart->copy()->addYears(3)->endOfYear()
        );

        if ($bodies) {

            Body::setAllInactive();

            $this->importService->startProgressBar(count($bodies));

            Congressperson::resetMemberships(config('source.legislature_id'));

            foreach ($bodies as $body) {
                $this->processIndividualBody($body);
                $this->importService->advanceProgressBar();
            }
            $this->importService->finishProgressBar();
        } else {
            $this->importService->report('no bodies found', 'warn');
        }
    }

    public function processIndividualBody($body)
    {
        if ($prohibitedWordsFound = array_filter(config('source.bodies_exception'), function ($words) use ($body) {
            return strContainsSimplify($body['nome'], $words);
        })) {
            $this->importService->report(
                "body {$body['nome']} is prohibited. Found: " . implode(',', $prohibitedWordsFound),
                'warn'
            );
            return;
        }

        $members = $this->requesterService->getBodiesMembers($body['id']);

        if (!$members) {
            $this->importService->report("no members found for body {$body['nome']}", 'warn');
            return;
        }

        $membersData = [];
        $members->each(function ($member) use (&$membersData) {
            if (!isset($membersData[$member->id])) {
                $membersData[$member->id] = [];
            }
            $membersData[$member->id][] = $member->titulo;
        });

        foreach ($membersData as $memberId => $memberships) {
            Congressperson::findByExternalId($memberId)?->addMembership($body['id'],$memberships);
        }

        Body::updateOrCreateByExternalId(
            $body['id'],
            $body['nome'],
            json_encode($membersData),
        );
    }
}
