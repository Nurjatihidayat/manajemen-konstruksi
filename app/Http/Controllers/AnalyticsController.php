<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Project;
use App\Models\MaterialTransaction;
use App\Models\StockOpnameItem;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != 'admin') abort(403);

        // 1. Accuracy (Opname differences)
        $accuracyData = StockOpnameItem::selectRaw('SUM(ABS(difference)) as total_diff, COUNT(*) as total_items')
            ->first();
        
        // 2. Top Moving Materials
        $topMoving = MaterialTransaction::select('material_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('material_id')
            ->orderByDesc('total_qty')
            ->with('material')
            ->take(5)
            ->get();

        // 3. Project Progress Dist
        $projects = Project::select('nama_proyek', 'progres')->get();

        // 4. Critical Stock Count
        $criticalCount = Material::whereColumn('jumlah_tersedia', '<=', 'reorder_point')->count();

        return view('analytics.index', compact('accuracyData', 'topMoving', 'projects', 'criticalCount'));
    }
}
