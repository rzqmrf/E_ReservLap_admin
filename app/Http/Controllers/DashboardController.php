<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Dashboard::all();
        return view('dashboard', ['data' => $data]);
    }
}
