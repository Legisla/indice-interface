<?php

namespace App\Services\Resources;

use App\Enums\Configs;
use App\Models\Congressperson;
use App\Models\Expense;
use App\Models\SiteConfig;
use App\Models\State;
use App\Services\ImportService;
use App\Services\RequesterService;
use Carbon\Carbon;


class ExpensesService
{
    public function __construct(private ImportService $importService)
    {
    }

    public function process()
    {
        $this->importService->iterateProgressBar(Congressperson::getAllCurrent(),
            function ($congressperson) {
                $this->processCongressPerson($congressperson);
            });

        $this->importService->report('expenses imported. now calculating state and national averages');
        $this->calculateAverageExpenditure();
    }

    /**
     * @param \App\Models\Congressperson $congressperson
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function processCongressPerson(Congressperson $congressperson): void
    {
        if ($lastOpenMonth = Expense::getLastOpenByCongresspersonId($congressperson)) {
            $targetMonth = new Carbon($lastOpenMonth->year . '-' . $lastOpenMonth->month . '-01');
        } else {
            $targetMonth = new Carbon(config('source.date.start'));
        }

        while ($targetMonth->diffInMonths(Carbon::now()->addMonth())) {
            Expense::creatOrUpdateByMonthAndCongressperson($congressperson, $targetMonth->year, $targetMonth->month,
                (new RequesterService())->getTotalExpenditureByMonth($congressperson->external_id, $targetMonth->year, $targetMonth->month)
            );

            $targetMonth->addMonth();
        }

        $congressperson->setExpenditure(Expense::getTotalExpenditureByCongressperson($congressperson));
    }


    public function calculateAverageExpenditure(): void
    {
        $nationalTotal = 0;
        $nationalCount = 0;
        $stateTotal = [];
        $stateCount = [];
        Congressperson::getAllCurrent()->each(function ($item) use (&$nationalTotal, &$nationalCount, &$stateTotal, &$stateCount) {
            $nationalTotal += $item->expenditure;
            $nationalCount++;

            if (!isset($stateTotal[$item->fk_state_id])) {
                $stateTotal[$item->fk_state_id] = 0;
                $stateCount[$item->fk_state_id] = 0;
            }

            $stateTotal[$item->fk_state_id] += $item->expenditure;
            $stateCount[$item->fk_state_id]++;
        });

        foreach ($stateTotal as $key => $value) {
            State::setAverageExpenditure($key, $value / $stateCount[$key]);
        }

        SiteConfig::setConfigByKey(
            Configs::NATIONAL_AVERAGE,
            number_format($nationalTotal / $nationalCount, 2, '.', '')
        );

    }


}
