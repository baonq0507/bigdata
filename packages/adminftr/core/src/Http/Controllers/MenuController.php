<?php

namespace Adminftr\Core\Http\Controllers;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('future::menu');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu::create');
    }
}
