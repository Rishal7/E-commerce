<?php

namespace App\Console\Commands;

use App\Jobs\ExportProducts;
use App\Models\ScheduledExport;
use Bus;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ExecuteScheduledExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute scheduled exports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDateTime = date("Y-m-d H:i:s");

        $scheduledExports = ScheduledExport::where('date', '<=', $currentDateTime)
            ->where('executed', false)
            ->get();

        foreach ($scheduledExports as $scheduledExport) {
            $categoryIds = json_decode($scheduledExport->categories, true);

            $query = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.name', 'products.price', 'categories.name as category');

            if (!empty($categoryIds)) {
                $query->whereIn('categories.id', $categoryIds);
            }
            $data = $query->get()->toArray();

            $data = array_map(function ($item) {
                return (array) $item;
            }, $data);

            if (empty($data)) {
                return redirect()->back()->with('error', 'No data to export.');
            }

            $dataChunks = array_chunk($data, 10);

            $batch = Bus::batch([])->dispatch();

            foreach ($dataChunks as $key => $chunk) {
                $batch->add(new ExportProducts($chunk, $key + 1, count($dataChunks)));
            }

            Redis::set('export_batch_id', $batch->id);

            $csvFilename = 'final_export_' . $batch->id . '.csv';

            Redis::set('export_filename', $csvFilename);

            // $scheduledExport->delete();

            DB::table('scheduled_exports')
                ->where('id', $scheduledExport->id)
                ->update(['executed' => true]);

        }
    }
}