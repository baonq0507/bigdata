<?php

namespace Adminftr\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function getFile($filename)
    {
        $filePath = 'avatars/' . $filename;
        if (!Storage::disk('private')->exists($filePath)) {
            abort(404);
        }

        return response()->file(Storage::disk('private')->path($filePath));
    }
}
