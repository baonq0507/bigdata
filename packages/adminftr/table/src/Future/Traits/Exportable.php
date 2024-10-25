<?php

namespace Adminftr\Table\Future\Traits;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use packages\adminftr\core\src\Http\Exports\DataExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait Exportable
{
    /**
     * The type of export file to generate (excel, csv, or pdf).
     *
     * @var string
     */
    public $type = 'excel';

    /**
     * Export the data based on the specified type.
     *
     * Determines which export method to call based on the `$type` property.
     *
     * @return BinaryFileResponse|Response
     */
    public function export()
    {
        if ($this->type == 'excel') {
            return $this->exportExcel();
        } elseif ($this->type == 'csv') {
            return $this->exportCsv();
        } elseif ($this->type == 'pdf') {
            return $this->exportPdf();
        }
    }

    /**
     * Export data to Excel.
     *
     * Retrieves the data and headings, then uses the `DataExport` class to generate an Excel file.
     *
     * @return BinaryFileResponse
     */
    protected function exportExcel()
    {
        $data = $this->applyTableQuery()->paginate($this->perPage);
        $headings = array_map(function ($column) {
            return $column->label;
        }, $this->defineColumns());

        return Excel::download(new DataExport($data, $headings), 'data.xlsx');
    }

    /**
     * Export data to CSV.
     *
     * Retrieves the data and headings, then uses the `DataExport` class to generate a CSV file.
     *
     * @return BinaryFileResponse
     */
    protected function exportCsv()
    {
        $data = $this->applyTableQuery()->get();
        $headings = array_map(function ($column) {
            return $column->label;
        }, $this->defineColumns());

        return Excel::download(new DataExport($data, $headings), 'data.csv');
    }

    /**
     * Export data to PDF.
     *
     * Retrieves the data and headings, then generates a PDF using the `Pdf` facade.
     * The view name for the PDF is left empty; customize this to include a proper view.
     *
     * @return Response
     */
    protected function exportPdf()
    {
        $data = $this->applyTableQuery()->get();
        $headings = array_map(function ($column) {
            return $column->label;
        }, $this->defineColumns());
        $pdf = PDF::loadView('', compact('data', 'headings'));

        return $pdf->download('data.pdf');
    }
}
