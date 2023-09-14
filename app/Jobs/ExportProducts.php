<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use App\Events\ExportProgressEvent;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportProducts implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $data;
    protected $jobIndex;
    protected $totalJobs;

    public function __construct(array $data, $jobIndex, $totalJobs)
    {
        $this->data = $data;
        $this->jobIndex = $jobIndex;
        $this->totalJobs = $totalJobs;
    }


    public function handle()
    {
        if (empty($this->data)) {
            return;
        }

        $batchId = $this->batch()->id;

        // Load existing JSON data if any
        $jsonFilename = 'temp_export_' . $batchId . '.json';
        $existingData = [];

        if (Storage::disk('local')->exists($jsonFilename)) {
            $existingDataJson = Storage::disk('local')->get($jsonFilename);
            $existingData = json_decode($existingDataJson, true);
        }

        $combinedData = array_merge($existingData, $this->data);

        $jsonData = json_encode($combinedData);

        Storage::disk('local')->put($jsonFilename, $jsonData);

        if ($this->jobIndex === $this->totalJobs) {

            $this->finalizeCsvExport($batchId);

            Redis::setex('export_completed', 20, true);
        }
    }

    public function finalizeCsvExport($batchId)
    {
        $jsonFilename = 'temp_export_' . $batchId . '.json';
        $csvFilename = 'final_export_' . $batchId . '.csv';

        $jsonData = Storage::disk('local')->get($jsonFilename);

        $dataArray = json_decode($jsonData, true);

        $export = new ProductsExport($dataArray);

        Excel::store($export, $csvFilename, 'local');

        // Delete the JSON file after CSV generation
        Storage::disk('local')->delete($jsonFilename);

    }

}