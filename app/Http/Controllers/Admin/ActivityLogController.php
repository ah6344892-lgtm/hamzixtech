<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', ActivityLog::class);
        return view('admin.activity-logs.index', ['logs'=>ActivityLog::query()->with('user')->latest()->paginate(30)]);
    }
}
