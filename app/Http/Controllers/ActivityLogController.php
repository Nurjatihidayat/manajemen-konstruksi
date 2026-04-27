<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != 'admin') abort(403);
        
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('activity_logs.index', compact('logs'));
    }
}
