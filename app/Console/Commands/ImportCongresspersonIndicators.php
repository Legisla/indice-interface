<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExternalImportService;
use Maatwebsite\Excel\Facades\Excel;

# USAGE:
# php artisan import:congressperson-indicators /caminho/para/o/arquivo.csv

class ImportCongresspersonIndicators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:congressperson-indicators {csv_file}';

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
        $csvFile = $this->argument('csv_file');

        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            $this->error("O arquivo CSV não existe ou não é legível.");
            return 1;
        }

        $this->info('Iniciando importação...');

        // Aqui você chama o seu serviço para fazer a importação.
        Excel::import(new ExternalImportService(), $csvFile);
        
        $this->info('Importação concluída.');

        return 0;
    }
}
