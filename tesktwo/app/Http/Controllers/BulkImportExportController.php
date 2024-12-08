<?php

namespace App\Http\Controllers;

use App\Exports\ValidFailedCustomerExport;
use App\Imports\InsertValidCustomer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BulkImportExportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bulk-import-export.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        $import = new InsertValidCustomer();
        Excel::import($import, $request->file('file'));
        $result = $import->returnInfo();

return response()->json([
    'message' => 'Import completed.',
    'imported_count' => $result['validRows'],
    'failed_count' => $result['invalidRows'],
    'failed_file_url' => $result['failedFilePath'],
]);

       

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
