<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Initiator;
use App\Http\Controllers\Controller;
use App\Models\Importation;
use App\Services\ImportService;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;
use League\Csv\Writer;
use GuzzleHttp\Exception\GuzzleException;
use App\Traits\GeneratesCsv;

class CustomAdminPages extends Controller
{

    use GeneratesCsv;

    public function showAllData(ScoreService $scoreService): View
    {
        $tableData = $scoreService->getAllData();
        $lastImportationEnd = Importation::getLastCompletedEnd();

        return view('rawData', compact('tableData', 'lastImportationEnd'));
    }

    /**
     * @throws \League\Csv\InvalidArgument
     * @throws \League\Csv\CannotInsertRecord
     * @throws \League\Csv\UnavailableFeature
     * @throws \League\Csv\Exception
     */
    public function allDataCsv(ScoreService $scoreService): Response
    {
        return $this->downloadCsv($scoreService->getAllData(true),"data.csv");
    }

    public function indicatorsDataCsv(ScoreService $scoreService): Response
    {
        return $this->downloadCsv($scoreService->getIndicatorsData(true),"indicators.csv");
    }

    /**
     * @param Request $request
     * @return void
     * @throws GuzzleException
     */
    public function import(Request $request)
    {
        (new ImportService())->doImportation(Initiator::WEB, $request->get('cleanstart'));
    }
}
