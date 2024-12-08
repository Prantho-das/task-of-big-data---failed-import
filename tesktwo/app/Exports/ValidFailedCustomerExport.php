<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ValidFailedCustomerExport implements FromCollection
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return collect($this->rows);
    }
}
