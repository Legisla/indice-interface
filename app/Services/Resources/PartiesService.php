<?php

namespace App\Services\Resources;

use App\Models\Party;
use App\Services\ImportService;
use App\Services\RequesterService;
use GuzzleHttp\Exception\GuzzleException;

class PartiesService
{
    private RequesterService $requesterService;

    public function __construct(private readonly ImportService $importService)
    {
        $this->requesterService = new RequesterService();
    }
    /**
     * @throws GuzzleException
     */
    public function process(): void
    {
        $parties = $this->requesterService->getParties();

        if ($parties->isEmpty()) {
            throw new Exception('No party data found');
        }

        $this->importService->iterateProgressBar($parties, function ($item) {

            $partyDetails = $this->requesterService->getPartyDetails($item->id);
            $party = Party::findByExternalId($item->id);

            $party->fill([
                'external_id' => $partyDetails->get('id'),
                'name' => $partyDetails->get('nome'),
                'acronym' => $partyDetails->get('sigla'),
                'number' => $partyDetails->get('numeroEleitoral'),
                'url_logo' => $partyDetails->get('urlLogo'),
                'url_site' => $partyDetails->get('urlWebSite'),
            ])->save();
        });
    }
}
