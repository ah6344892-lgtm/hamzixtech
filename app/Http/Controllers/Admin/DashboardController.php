<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('view dashboard'), 403);
        return view('admin.dashboard');
    }
}
