<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
