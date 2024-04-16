<?php

namespace App\Services;


use App\Enums\ImportationStatus;
use App\Enums\Initiator;
use App\Enums\Stages;
use App\Models\Amendment;
use App\Models\Body;
use App\Models\Congressperson;
use App\Models\CongresspersonAxis;
use App\Models\Expense;
use App\Models\Front;
use App\Models\Event;
use App\Models\CongresspersonIndicator;
use App\Models\Importation;
use App\Models\Proposition;
use App\Models\CongresspersonProposition;
use App\Models\Votation;
use App\Services\Resources\AmendmentsService;
use App\Services\Resources\BodiesService;
use App\Services\Resources\EventsService;
use App\Services\Resources\ExpensesService;
use App\Services\Resources\FrontsService;
use App\Services\Resources\IndicatorsService;
use App\Services\Resources\PositionsService;
use App\Services\Resources\PropositionsService;
use App\Services\Resources\VotationsService;
use App\Services\Resources\PartiesService;
use App\Services\Resources\CongressPeopleService;
use App\Traits\ShowsCommandProgress;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ImportationFailed;

class ImportService
{
    use ShowsCommandProgress;

    private ?Command $command;

    public Importation $importation;

    public function __construct(Command $command = null)
    {
        $this->command = $command;
    }
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function doImportation(Initiator $initiator, bool $cleanStart = false, string $filename = ''): void
    {
        list($legislature_start, $legislature_end) = $this->getLegislatureDates(config('source.legislature_id'));
    
        $this->importation = Importation::createOrGetLast(
            config('source.legislature_id'),
            $initiator,
            $cleanStart,
            [], // Stages são removidos
            $legislature_start,
            $legislature_end,
            $filename
        );
    }

    /**
     * @throws GuzzleException
     */
    public function retryImportation(): void
    {
        $importation = Importation::getLastFailed();

        if (!$importation) {
            $this->report('Retry: no failed importation found.');
            return;
        }

        $this->importation = $importation;

        $this->report('Retry: a failed importation has been found. Reprocessing...');

        $this->processImportation();
    }

    /**
     * @param bool $cleanStart
     * @return void
     * @throws GuzzleException
     */
    private function processImportation(bool $cleanStart = false): void
    {
        try {

            $startingTime = microtime(true);
            ini_set('max_execution_time', 30000);

            $this->report(
                'starting ' . ($cleanStart ? 'clean' : '') . ' importation id ' .
                $this->importation->id . ' with stages: ' . $this->importation->getStagesFormated()
            );

            foreach (Stages::cases() as $stage) {
                $this->importStep(
                    $stage,
                );
            }

            $this->importation->finish();

            $this->report('finishing mportation id ' . $this->importation->id .
                ' with stages: ' . $this->importation->getStagesFormated() .
                ' in ' .
                number_format(
                    microtime(true) - $startingTime,
                    3,
                    ',',
                    ''
                ) . ' seconds'
            );

        } catch (GuzzleException|Exception $e) {

            $this->report('Error: ' . mountErrorMessage($e));

            $this->importation->fail();

            $this->report('sending email reporting error to admin');

            $this->sendFailureMail();

            $this->report('importation id ' . $this->importation->id . ' failed with stages: ' . $this->importation->getStagesFormated());

            throw $e;
        }
    }

    /**
     * @return void
     */
    private function sendFailureMail(): void
    {
        Mail::to(config('source.processment.mail.failure'))->send(new ImportationFailed($this->importation));
    }

    /**
     * @throws Exception
     */
    private function generateStages(): array
    {
        $onConfig = config('source.import');
        $ret = [];
        foreach (Stages::cases() as $stage) {
            if (!$onConfig) {
                throw new Exception('Missing config for stage ' . $stage->value);
            }

            if ($onConfig[$stage->value]) {
                $ret[] = ['stage' => $stage->value, 'status' => 'pending'];
            }

            unset($onConfig[$stage->value]);
        }

        if (count($onConfig) > 0) {
            throw new Exception('Missing Enum for stages ' . implode(', ', array_keys($onConfig)));
        }

        if(!$ret) {
            throw new Exception('No stages to import');
        }

        return $ret;
    }


    private function checkStages(Stages $stageToCheck): bool
    {
        foreach ($this->importation->getStages() as $item) {
            if ($item['stage'] == $stageToCheck->value) {
                return $item['status'] == 'pending';
            }
        }

        return false;
    }

    private function updateStage(Stages $stageToCheck): void
    {
        $this->importation->updateStages(array_map(function ($item) use ($stageToCheck) {
            if ($item['stage'] == $stageToCheck->value) {
                $item['status'] = 'done';
            }
            return $item;
        }, $this->importation->getStages()));
    }

    /**
     * @param Stages $stage
     * @return void
     * @throws GuzzleException
     * @uses AmendmentsService
     * @uses BodiesService
     * @uses EventsService
     * @uses ExpensesService
     * @uses FrontsService
     * @uses IndicatorsService
     * @uses PositionsService
     * @uses PropositionsService
     * @uses VotationsService
     * @uses PartiesService
     * @uses CongressPeopleService
     */
    private function importStep(Stages $stage): void
    {
        try {

            $startingTime = microtime(true);
            if (!$this->checkStages($stage)) {
                $this->report('not ' . $stage->yeldVerb() . $stage->value);
                return;
            }

            $this->report($stage->yeldVerb() . $stage->value);

            $className = $stage->processClass();

            (new $className($this))->process();

            $this->updateStage($stage);

            $this->report('finish ' . $stage->yeldVerb() . $stage->value . ' in ' .
                number_format(microtime(true) - $startingTime,
                    3, ',', '') . ' seconds');

        } catch (GuzzleException|Exception $e) {
            $this->report('Error: ' . mountErrorMessage($e));

            $this->importation->fail();

            throw $e;

        }
    }


    private function getLegislatureDates($idLegislature)
    {
        $details = (new RequesterService)->getLegislatureDetails($idLegislature);

        if (!isset($details['dataInicio']) || !isset($details['dataFim'])) {
            throw new Exception('Legislature start date not found');
        }

        return [
            Carbon::create($details['dataInicio'])->startOfDay(),
            Carbon::create($details['dataFim'])->endOfDay(),
        ];
    }


    public function purge(): void
    {
        $currentLegislature = config('source.legislature_id');

        $this->report('Purging data');
        Body::purge();
        Event::purge();
        Expense::purge();
        Front::purge();
        Votation::purge();
        CongresspersonProposition::purge();
        Proposition::purge();
        CongresspersonAxis::purge();
        CongresspersonIndicator::purge();
        Congressperson::purge();
        Amendment::purge();
    }

}
