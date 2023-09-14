<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProductsImport implements ToArray
{
    use Importable, Batchable;
    protected $row;
    protected $userId; 
    
    public function array(array $row)
    {
        
    }
}