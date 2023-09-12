<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class Import implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $userId;
    public $data;
    public $header;

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

                // Check if the category already exists
                $category = Category::where('name', $saleData['category'])->first();

                if ($category) {
                    // Category already exists, use its ID
                    $saleData['category_id'] = $category->id;
                } else {
                    // Category doesn't exist, create it
                    $newCategory = Category::create(['name' => $saleData['category']]);
                    $saleData['category_id'] = $newCategory->id;
                }

                unset($saleData['category']);


                // Create the product using the category_id
                Product::create($saleData);
            }
        }
    }

    public function failed(Throwable $exception)
    {

    }
}