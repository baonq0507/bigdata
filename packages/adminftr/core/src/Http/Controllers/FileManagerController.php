<?php

namespace Adminftr\Core\Http\Controllers;

use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    public function index()
    {
        return view('future::file-manager');
    }
}
