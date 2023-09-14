<?php

namespace App\Http\Controllers;

use App\Jobs\ExportProducts;
use App\Models\Category;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Redis;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.export', [
            'categories' => Category::all(),
        ]);
    }

    public function export(Request $request)
    {
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.name', 'products.price', 'categories.name as category');

        $categoryIds = $request->input('categories', []);

        if (!empty($categoryIds)) {
            $query->whereIn('categories.id', $categoryIds);
        }

        $data = $query->get()->toArray();

        // Convert stdClass objects to arrays
        $data = array_map(function ($item) {
            return (array) $item;
        }, $data);

        if (empty($data)) {
            return redirect()->back()->with('error', 'No data to export.');
        }

        $dataChunks = array_chunk($data, 10);

        // Create a batch and dispatch it
        $batch = Bus::batch([])->dispatch();

        foreach ($dataChunks as $key => $chunk) {
            $batch->add(new ExportProducts($chunk, $key + 1, count($dataChunks)));
        }

        Redis::set('export_batch_id', $batch->id);

        $csvFilename = 'final_export_' . $batch->id . '.csv';

        Redis::set('export_filename', $csvFilename);

        session()->flash('export_completed', false);

        return redirect()->back();
    }

    public function download()
    {
        $fileName = Redis::get('export_filename');
        $filePath = storage_path("app/{$fileName}");

        if (!$filePath) {
            abort(404);
        }

        return response()->download($filePath);

    }

    public function checkProgress()
    {
        $batchID = Redis::get('export_batch_id');

        $batch = Bus::findBatch($batchID);

        $down = Redis::get('export_completed');

        $fileName = 'final_export_' . $batch->id . '.csv';

        return view('admin.export-progress', [
            'batch' => $batch,
            'down' => $down,
            'filePath' => $fileName
        ]);
    }

}