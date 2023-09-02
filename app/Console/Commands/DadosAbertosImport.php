<?php

namespace App\Console\Commands;

use App\Services\ImportService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Exception;
use App\Enums\Initiator;

class DadosAbertosImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dadosabertos:import
       { --initiator=  : cron or command  }
       { --clean=  : ignore last failed  }
       { --purge=  : clear all data from the current legislature before reinporting }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicia a importação de dados';

    /**
     * @return void
     */
    public function handle(): void
    {
        try {

            ini_set('memory_limit', '512M');

            if ($this->option('initiator')) {

                if (!$initiator = Initiator::tryFrom($this->option('initiator'))) {
                    throw new Exception('Invalid initiator');
                }

            } else {
                $initiator = Initiator::CONSOLE;
            }

            if($this->option('purge')) {
                (new ImportService($this))->purge();
            }

            (new ImportService($this))->doImportation($initiator, $this->option('clean') ?: false);

        } catch (Exception|GuzzleException $e) {
            $this->error(
                mountErrorMessage($e)
            );
        }
    }
}
