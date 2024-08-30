<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function welcome(): View
    {
        return view('pages/home/dashboard-umum');
    }
}
