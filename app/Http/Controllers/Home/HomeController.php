<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

class HomeController extends FatherController
{
    public function index(Request $request)
    {
        return view('home/index/index');
    }
}