<?php

namespace App\Console\Commands;

use App\Services\ImportService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Exception;
use App\Enums\Initiator;

class DadosAbertosRetry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dadosabertos:retry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retenta a importação de dados';

    /**
     * @return void
     */
    public function handle(): void
    {
        try {

            ini_set('memory_limit', '512M');

            (new ImportService($this))->retryImportation();

        } catch (Exception|GuzzleException $e) {
            $this->error(
                mountErrorMessage($e)
            );
        }
    }
}
