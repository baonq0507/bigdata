<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function updateImage(Request $request, $id)
    {
        $contract = Contract::find($id);
        if ($request->hasFile('invoice_image')) {
            $file = $request->file('invoice_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('invoices', $filename, 'public');
            $request->merge(['invoice_image' => $path]);
        }
        if ($request->hasFile('product_image')) {
            $files = $request->file('product_image');
            $paths = [];
            foreach ($files as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $paths[] = $path;
            }
            $request->merge(['product_image' => $paths]);

        }
        $contract->update($request->all());
        return response()->json($contract);
    }
}
