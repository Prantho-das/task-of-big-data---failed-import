<?php

namespace App\Imports;

use App\Exports\ValidFailedCustomerExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Facades\Excel;

class InsertValidCustomer implements ToCollection, WithChunkReading
{
    public $validRows = [];
    public $invalidRows = [];
    public $failedFilePath;

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $validation = validator($row->toArray(), [
                '0' => 'required|string|max:255',
                '1' => 'required|email',
                '2' => 'required',
                '3' => 'required|in:M,F',
            ]);

            if ($validation->fails()) {
                $this->invalidRows[] = array_merge($row->toArray(), ['errors' => $validation->errors()->toArray()]);
            } else {
                $this->validRows[] = $row->toArray();
            }
        }
        // Insert valid rows in chunks to avoid memory issues
        if (!empty($this->validRows)) {
            // DB::table('your_table')->insert($this->validRows);
            $this->validRows = []; // Clear validRows after insert
        }
        if (!empty($this->invalidRows)) {
            $this->failedFilePath = 'failed_data_' . time() . '.xlsx';
            Excel::store(new ValidFailedCustomerExport($this->invalidRows), $this->failedFilePath, 'public');
        }

    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }
    public function returnInfo(){
        return [
            'validRows' => count($this->validRows),
            'invalidRows' => count($this->invalidRows),
            'failedFilePath' => $this->failedFilePath ? asset('storage/' . $this->failedFilePath) : null,
        ];
    }
}
