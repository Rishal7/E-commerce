<?php

namespace App\Console\Commands;

use App\Imports\ProductsImport;
use App\Jobs\Import;
use App\Models\ScheduledImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExecuteScheduledImports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute scheduled imports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDateTime = date("Y-m-d H:i:s");

        $scheduledImports = ScheduledImport::where('date', '<=', $currentDateTime)
            ->where('executed', false)
            ->get();

        foreach ($scheduledImports as $scheduledImport) {
            $scheduledTime = $scheduledImport->date;
            $userId = $scheduledImport->user_id;

            Log::info($userId);

            if ($scheduledTime <= $currentDateTime) {
                $file = storage_path('app/public/' . $scheduledImport->file);

                if (file_exists($file)) {
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
                            $batch->add(new Import($userId, $chunk, $header));
                        }

                        // $scheduledImport->delete();

                        DB::table('scheduled_imports')
                            ->where('id', $scheduledImport->id)
                            ->update(['executed' => true]);

                        // Delete the file from storage
                        Storage::disk('local')->delete('public/' . $scheduledImport->file);
                    }
                }
            }
        }
    }
}