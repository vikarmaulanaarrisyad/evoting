<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard.index');
        } else if (auth()->user()->hasRole('panitia')) {
            return view('panitia.dashboard.index');
        } else {
            return view('pemilih.dashboard.index');
        }
    }
}
