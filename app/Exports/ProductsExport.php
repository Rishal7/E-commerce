<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings, ShouldQueue, FromArray
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection($this->data);
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'name',
            'price',
            'category',
        ];
    }
}
