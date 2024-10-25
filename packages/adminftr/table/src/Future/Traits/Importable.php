<?php

namespace Adminftr\Table\Future\Traits;

use Adminftr\Core\Http\Imports\DataImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use packages\adminftr\core\src\Http\Exports\DataExport;

trait Importable
{
    /**
     * The uploaded file for import.
     *
     * @var mixed
     */
    public $importFile;

    /**
     * Import data from Excel file.
     *
     * Validates the uploaded file, processes the file, and transforms the data.
     * Returns an Excel file download response containing the processed data.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function importExcel()
    {
        // Validate the uploaded file
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Store the uploaded file temporarily
        $filePath = $this->importFile->store('temp');

        // Create an instance of DataImport and import the data
        $import = new DataImport;
        Excel::import($import, $filePath);

        // Retrieve imported data
        $products = $import->getData();
        $newProducts = [];
        $header = [];

        // Extract headers from the first product
        foreach ($products[0] as $key => $value) {
            $key = ucwords(str_replace('_', ' ', $key)); // Format header names
            $header[] = $key;
        }

        foreach ($products as $product) {
            if ($product['product_description'] != null) {
                // Count the number of semicolons in product description
                $count = substr_count($product['product_description'], ';');

                if ($count == 1) {
                    // Split product description and process based on content
                    $value = explode(';', $product['product_description']);
                    if (preg_match('/[áàảãạăắằẳẵặâấầẩẫậéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ]/i', $value[0])) {
                        $value = explode('#&', $value[0]);
                    } else {
                        $value = explode('#&', $value[1]);
                    }
                    // Clean and update product description
                    if (! empty($value[1])) {
                        $value[1] = str_replace(['.#', '0# ', '.# ', '#', '&'], '', $value[1]);
                        $product['product_description'] = $value[1];
                    } else {
                        $value[0] = str_replace(['.#', '.# ', '0# ', '#', '&'], '', $value[0]);
                        $product['product_description'] = $value[0];
                    }
                    $newProducts[] = $product;
                } elseif ($count >= 1) {
                    // Process product description with multiple semicolons
                    $natural = ($count + 1) / 2;
                    $values = explode(';', $product['product_description'], $count);

                    if (preg_match('/[áàảãạăắằẳẵặâấầẩẫậéèẻẽẹêếềểễệíìĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ]/i', $values[0])) {
                        $value = implode(';', array_slice($values, 0, $natural));
                    } else {
                        $value = implode(';', array_slice($values, $natural));
                    }
                    $value = explode('#&', $value);
                    if (! empty($value[1])) {
                        $value[1] = str_replace(['.#', '0# ', '.# ', '#', '&'], '', $value[1]);
                        $product['product_description'] = $value[1];
                    }
                    $newProducts[] = $product;
                }
            }
        }

        // Convert processed products to a Collection
        $newProducts = new Collection($newProducts);

        // Return an Excel file download response with the processed data
        return Excel::download(new DataExport($newProducts, $header), 'data.xlsx');
    }
}
