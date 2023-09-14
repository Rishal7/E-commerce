<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Import implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    public $data;
    public $header;

    protected $file;

    public function __construct($userId, $data, $header)
    {
        $this->userId = $userId;
        $this->data = $data;
        $this->header = $header;
    }

    public function handle()
    {

        foreach (array_chunk($this->data, 10) as $chunk) {
            foreach ($chunk as $sale) {
                $saleData = array_combine($this->header, $sale);
                
                $saleData['user_id'] = $this->userId;

                $category = Category::where('name', $saleData['category'])->first();

                if ($category) {
                    $saleData['category_id'] = $category->id;
                } else {
                    $newCategory = Category::create(['name' => $saleData['category']]);
                    $saleData['category_id'] = $newCategory->id;
                }

                unset($saleData['category']);

                Product::create($saleData);
            }
            Redis::setex('import_completed', 10, true);
        }

    }
}