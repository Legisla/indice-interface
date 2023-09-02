<?php

namespace App\Traits;

use App\Services\ScoreService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;
use League\Csv\Writer;

trait GeneratesCsv
{

    public function generateCsv(array $data, string $delimiter = ''): Writer
    {
        $csv = Writer::createFromString('');
        if ($delimiter) {
            $csv->setDelimiter($delimiter);
        }
        $csv->insertAll($data);
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');

        return $csv;
    }

    public function downloadCsv(array $data, string $title = 'data.csv'): Response
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $title . '"',
        ];

        return FacadeResponse::make($this->generateCsv($data, ';')->toString(), Response::HTTP_OK, $headers);
    }

    public function saveCsv(array $data, string $fileName, bool $append = false): void
    {
        if (!config('source.processment.csv_debug')) {
            return;
        }

        array_unshift(
            $data,
            array_keys($data[0])
        );

        if (!is_dir(storage_path('csv'))) {
            mkdir(storage_path('csv'));
        }

        $path = explode('/', $fileName.'.csv');

        if (count($path) > 1) {
            $folderPath = implode('/', array_slice($path, 0, -1));

            if (!is_dir(storage_path('csv/' . $folderPath))) {
                mkdir(storage_path('csv/' . $folderPath));
            }
        }

        array_unshift($path, 'csv');

        file_put_contents(
            storage_path(implode('/', $path)),
            $this->generateCsv($data)->toString(),
            $append ? FILE_APPEND : 0
        );
    }
}
