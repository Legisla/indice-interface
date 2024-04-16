<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExternalImportService;
use App\Services\ImportService;
use App\Services\ScoreService;
use App\Services\Resources\ExpensesService;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Congressperson;
use App\Models\Expense;
use App\Enums\Initiator;




# USAGE:
# php artisan import:congressperson-indicators /caminho/para/o/arquivo.csv
ini_set('memory_limit', '128M');

class ImportCongresspersonIndicators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:congressperson-indicators 
        { --csv_file= : csv file }
        { --initiator=  : cron or command  }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os indicadores dos congressistas a partir de um arquivo CSV';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csvFile = $this->option('csv_file');
        $initiator = Initiator::from($this->option('initiator'));

        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            $this->error("O arquivo CSV não existe ou não é legível.");
            return 1;
        }

        $this->info('Iniciando importação...');

        // Aqui você chama o seu serviço para fazer a importação.
        Congressperson::deactivateAll();

        Excel::import(new ExternalImportService(), $csvFile);
        
        $this->info('Importação concluída.');

        // Chama a função para calcular as médias dos estados
        $importService = new ImportService();
        $filename = basename($csvFile);
        $importService->doImportation($initiator,false,  $filename);
        $scoreService = new ScoreService($importService);
        $scoreService->calculateGeneralAverages();
        $scoreService->calculateAxisScores();

        $this->info('Médias dos estados calculadas.');

        //Expense::purge();
        //Coleta os gastos de gabinete
        $expensesService = new ExpensesService($importService);
        
        $expensesService->process();

        $this->info('Gastos de gabinete calculados.');
        $importService->importation->finish();

        return 0;
    }
}
