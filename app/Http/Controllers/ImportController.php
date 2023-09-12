<?php

namespace App\Http\Controllers;

use App\Jobs\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Redis;

class ImportController extends Controller
{
    public function index()
    {
        $batchID = Redis::get('import_batch_id');

        if ($batchID) {
            # code...
            $batch = Bus::findBatch($batchID);
            return view('admin.import', [
                'batch' => $batch,
            ]);
        }
        else {
            return view('admin.import'
        );
        }
        
    }

    public function import()
    {

        if (request()->has('csv')) {
            $data = file(request()->csv);
            $chunks = array_chunk($data, 10);
            $header = [];
            $batch = Bus::batch([])->dispatch();

            Redis::set('import_batch_id', $batch->id);
            Redis::setex('import_completed', 20, true);

            foreach ($chunks as $key => $chunk) {

                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new Import(auth()->id(), $data, $header));

            }

            return back()->with('success', 'Imported successfully');

        }
        return back()->with('error', 'Plaese select a file');
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
