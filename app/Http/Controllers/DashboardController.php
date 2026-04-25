<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Material;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            $totalProjects = Project::count();
            $totalMaterials = Material::count();
            $totalShortages = Material::where('kekurangan', '>', 0)->count();
            $recentProjects = Project::with('manager')->latest()->take(5)->get();
            $recentActivities = ActivityLog::with('user')->latest()->take(10)->get();
        } elseif ($user->role == 'manajer') {
            $totalProjects = Project::where('manager_id', $user->id)->count();
            $totalMaterials = Material::whereHas('project', function($query) use ($user) {
                $query->where('manager_id', $user->id);
            })->count();
            $totalShortages = Material::where('kekurangan', '>', 0)
                ->whereHas('project', function($query) use ($user) {
                    $query->where('manager_id', $user->id);
                })->count();
            $recentProjects = Project::with('manager')->where('manager_id', $user->id)->latest()->take(5)->get();
            $recentActivities = ActivityLog::with('user')->where('user_id', $user->id)->latest()->take(10)->get();
        } else { // gudang
            if ($user->assigned_project_id) {
                $totalProjects = 1;
                $totalMaterials = Material::where('project_id', $user->assigned_project_id)->count();
                $totalShortages = Material::where('project_id', $user->assigned_project_id)
                    ->where('kekurangan', '>', 0)->count();
                $recentProjects = Project::with('manager')->where('id', $user->assigned_project_id)->get();
                $recentActivities = MaterialTransaction::with('user')->whereHas('material', function($q) use ($user) {
                    $q->where('project_id', $user->assigned_project_id);
                })->latest()->take(10)->get();
            } else {
                $totalProjects = 0;
                $totalMaterials = 0;
                $totalShortages = 0;
                $recentProjects = collect();
                $recentActivities = collect();
            }
        }

        return view('dashboard', compact('totalProjects', 'totalMaterials', 'totalShortages', 'recentProjects', 'recentActivities'));
    }
}
