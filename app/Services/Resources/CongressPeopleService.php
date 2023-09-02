<?php

namespace App\Services\Resources;

use App\Helpers\Format;
use App\Models\Congressperson;
use App\Services\ImportService;
use App\Services\RequesterService;
use GuzzleHttp\Exception\GuzzleException;

class CongressPeopleService
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
        $congresspersonData = $this->requesterService->getCongressperson();

        if ($congresspersonData->isEmpty()) {
            throw new Exception('No congressperson data found');
        }

        $this->importService->iterateProgressBar($congresspersonData, function ($item) {

            $congresspersonDtls = Format::congresspersonDetails(
                $this->requesterService->getCongresspersonDetail($item->id)
            );

            $congressperson = Congressperson::findOrCreateByExternalId($item->id);

            if ($congressperson) {
                $congressperson->fill($congresspersonDtls)->save();
            } else {
                Congressperson::create($congresspersonDtls);
            }
        });
    }

}
