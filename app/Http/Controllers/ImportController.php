<?php

namespace App\Http\Controllers;

use App\Jobs\Import;
use App\Imports\ProductsImport;
use App\Models\ScheduledImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $batchID = Redis::get('import_batch_id');

        if ($batchID) {
            $batch = Bus::findBatch($batchID);
            return view('admin.import', [
                'batch' => $batch,
            ]);
        } else {
            return view(
                'admin.import'
            );
        }

    }

    public function import()
    {
        if (request()->hasFile('file')) {
            $file = request()->file('file');

            $importData = Excel::toArray(new ProductsImport, $file);

            if (count($importData) > 0) {
                $data = $importData[0];


                $chunks = array_chunk($data, 10);
                $header = [];
                $batch = Bus::batch([])->dispatch();

                Redis::set('import_batch_id', $batch->id);

                foreach ($chunks as $key => $chunk) {
                    if ($key === 0) {
                        $header = $chunk[0];
                        unset($chunk[0]);
                    }

                    $batch->add(new Import(auth()->id(), $chunk, $header));
                }

                return back();
            }
        }

        return back()->with('error', 'Please select a file');
    }

    public function checkProgress()
    {
        $batchID = Redis::get('import_batch_id');

        $batch = Bus::findBatch($batchID);

        $down = Redis::get('import_completed');

        return view('admin.import-progress', [
            'batch' => $batch,
            'down' => $down,
        ]);
    }
}