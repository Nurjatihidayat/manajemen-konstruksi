<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Material;
use App\Models\ProjectMaterial;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'totalProjects' => 0,
            'totalMaterials' => 0,
            'criticalMaterials' => 0,
            'pendingRequests' => 0,
            'recentActivities' => [],
            'recentProjects' => [],
        ];

        if ($user->role == 'admin') {
            $stats['totalProjects'] = Project::count();
            $stats['totalMaterials'] = Material::count();
            $stats['criticalMaterials'] = Material::whereColumn('jumlah_tersedia', '<=', 'reorder_point')->count();
            $stats['pendingRequests'] = \App\Models\MaterialRequest::where('status', 'pending')->count();
            $stats['recentProjects'] = Project::with('manager')->latest()->take(5)->get();
            $stats['recentActivities'] = ActivityLog::with('user')->latest()->take(10)->get();

        } elseif ($user->role == 'manajer') {
            $stats['totalProjects'] = Project::where('manager_id', $user->id)->count();
            
            // Pending requests specifically for their projects
            $stats['pendingRequests'] = \App\Models\MaterialRequest::where('manager_id', $user->id)
                ->where('status', 'pending')->count();
            
            // Shortages in their projects
            $stats['criticalMaterials'] = ProjectMaterial::where('sisa_kebutuhan', '>', 0)
                ->whereHas('project', function($query) use ($user) {
                    $query->where('manager_id', $user->id);
                })->count();
                
            $stats['recentProjects'] = Project::with('manager')->where('manager_id', $user->id)->latest()->take(5)->get();
            $stats['recentActivities'] = ActivityLog::with('user')->where('user_id', $user->id)->latest()->take(10)->get();

        } else { // gudang
            $stats['totalProjects'] = Project::count();
            $stats['totalMaterials'] = Material::count();
            
            // Material kritis (stok <= reorder_point)
            $stats['criticalMaterials'] = Material::whereColumn('jumlah_tersedia', '<=', 'reorder_point')->count();
            
            // All pending requests for warehouse to process
            $stats['pendingRequests'] = \App\Models\MaterialRequest::where('status', 'pending')->count();
            
            $stats['recentProjects'] = Project::latest()->take(5)->get();
            $stats['recentActivities'] = ActivityLog::with('user')->whereHas('user', function($q) {
                $q->whereIn('role', ['gudang', 'admin']);
            })->latest()->take(10)->get();
        }

        return view('dashboard', $stats);
    }
}
