<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use App\Events\ExportProgressEvent;

class ExportProducts implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $data;
    protected $filename;
    protected $totalRecords;

    public function __construct($data, $filename)
    {
        $this->data = $data;
        $this->filename = $filename;
    }

    public function handle()
    {
        if (empty($this->data)) {
            return;
        }

        $csvData = $this->arrayToCsv($this->data);

        $batchId = $this->batch()->id;
        $tempFilename = 'temp_export_' . $batchId . '.csv';

        if (!Storage::disk('local')->exists($tempFilename)) {
            $this->initializeTempFile($tempFilename, $csvData);
            Storage::disk('local')->append($tempFilename, $csvData);
        } else {
            Storage::disk('local')->append($tempFilename, $csvData);
        }

    }


    private function initializeTempFile($filename, $csvData)
    {
        $output = fopen('php://temp', 'w');
        fputcsv($output, array_keys($this->data[0]));
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        $csv = rtrim($csv, "\n");
        Storage::disk('local')->append($filename, $csv);
    }


    private function arrayToCsv(array $array)
    {
        if (empty($array)) {
            return '';
        }

        $output = fopen('php://temp', 'w');

        foreach ($array as $row) {
            fputcsv($output, $row);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        $csv = rtrim($csv, "\n");

        return $csv;
    }

}