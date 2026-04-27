<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\Material;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'manajer') {
            $requests = MaterialRequest::with(['project','items.material'])
                ->where('manager_id', $user->id)
                ->latest()->get();
        } elseif ($user->role == 'gudang' || $user->role == 'admin') {
            $requests = MaterialRequest::with(['project','manager','items.material'])
                ->latest()->get();
        } else {
            abort(403);
        }

        return view('material_requests.index', compact('requests'));
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->role == 'manajer') {
            $projects = Project::where('manager_id', $user->id)->get();
        } else {
            $projects = Project::all();
        }
        $materials = Material::orderBy('nama_material')->get();
        return view('material_requests.create', compact('projects', 'materials'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['manajer', 'admin'])) abort(403);

        $request->validate([
            'project_id'           => 'required|exists:projects,id',
            'request_date'         => 'required|date',
            'notes'                => 'nullable|string',
            'items'                => 'required|array|min:1',
            'items.*.material_id'  => 'required|exists:materials,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.priority'     => 'required|in:low,medium,high',
        ]);

        // Batasan Manager: tidak boleh melebihi rencana kebutuhan
        if ($user->role == 'manajer') {
            $project = Project::findOrFail($request->project_id);
            if ($project->manager_id != $user->id) abort(403);
        }

        $reqNumber = 'MR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $mr = MaterialRequest::create([
            'request_number' => $reqNumber,
            'project_id'     => $request->project_id,
            'manager_id'     => $user->id,
            'status'         => 'pending',
            'request_date'   => $request->request_date,
            'notes'          => $request->notes,
        ]);

        foreach ($request->items as $item) {
            // Strict Plan Validation for Managers
            if ($user->role == 'manajer') {
                $project = Project::findOrFail($request->project_id);
                $pm = $project->projectMaterials()->where('material_id', $item['material_id'])->first();
                
                if ($pm && $item['quantity'] > $pm->sisa_kebutuhan) {
                    return back()->with('error', 'Permintaan untuk ' . $pm->material->nama_material . ' melebihi sisa rencana (' . $pm->sisa_kebutuhan . ').')->withInput();
                }
            }

            $mr->items()->create([
                'material_id' => $item['material_id'],
                'quantity'    => $item['quantity'],
                'priority'    => $item['priority'],
            ]);
        }

        ActivityLog::create([
            'user_id'     => $user->id,
            'description' => 'Mengajukan Permintaan Material ' . $reqNumber,
        ]);

        return redirect()->route('material-requests.index')->with('success', 'Permintaan material berhasil diajukan.');
    }

    public function show(MaterialRequest $materialRequest)
    {
        $user = auth()->user();
        if ($user->role == 'manajer' && $materialRequest->manager_id != $user->id) abort(403);

        $materialRequest->load(['project','manager','items.material']);
        return view('material_requests.show', compact('materialRequest'));
    }

    public function approve(MaterialRequest $materialRequest)
    {
        if (auth()->user()->role != 'gudang' && auth()->user()->role != 'admin') abort(403);
        $materialRequest->update(['status' => 'approved']);
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Menyetujui permintaan material ' . $materialRequest->request_number,
        ]);
        return back()->with('success', 'Permintaan disetujui.');
    }

    public function reject(MaterialRequest $materialRequest)
    {
        if (auth()->user()->role != 'gudang' && auth()->user()->role != 'admin') abort(403);
        $materialRequest->update(['status' => 'rejected']);
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Menolak permintaan material ' . $materialRequest->request_number,
        ]);
        return back()->with('success', 'Permintaan ditolak.');
    }

    public function ship(MaterialRequest $materialRequest)
    {
        if (auth()->user()->role != 'gudang' && auth()->user()->role != 'admin') abort(403);
        if ($materialRequest->status != 'approved') {
            return back()->with('error', 'Hanya permintaan yang disetujui yang bisa dikirim.');
        }

        // Deduct stock from master materials
        foreach ($materialRequest->items as $item) {
            $material = $item->material;
            if ($material->jumlah_tersedia < $item->quantity) {
                return back()->with('error', 'Stok tidak cukup untuk material: ' . $material->nama_material);
            }
            $material->jumlah_tersedia -= $item->quantity;
            $material->save();

            // Record transaction
            MaterialTransaction::create([
                'user_id' => auth()->id(),
                'material_id' => $material->id,
                'type' => 'out',
                'quantity' => $item->quantity,
                'description' => 'Pengiriman untuk permintaan ' . $materialRequest->request_number . ' (Proyek: ' . $materialRequest->project->nama_proyek . ')',
            ]);

            // Add to project allocation (project_materials)
            $projectMat = $materialRequest->project->projectMaterials()
                ->where('material_id', $material->id)->first();
            
            if ($projectMat) {
                $projectMat->jumlah_dialokasikan += $item->quantity;
                $projectMat->total_diterima += $item->quantity;
                $projectMat->save();
            } else {
                // If not in planning, but requested and shipped, we add it to project materials
                $materialRequest->project->projectMaterials()->create([
                    'material_id' => $material->id,
                    'jumlah_kebutuhan' => 0, // Not planned but requested
                    'jumlah_tersedia' => 0,
                    'jumlah_dialokasikan' => $item->quantity,
                    'total_diterima' => $item->quantity,
                ]);
            }
        }

        $materialRequest->update(['status' => 'shipped']);
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Mengirim barang untuk permintaan ' . $materialRequest->request_number,
        ]);
        return back()->with('success', 'Barang berhasil dikirim. Stok gudang berkurang dan alokasi proyek bertambah.');
    }

    public function receive(MaterialRequest $materialRequest)
    {
        $user = auth()->user();
        if ($user->role != 'manajer' && $user->role != 'admin') abort(403);
        if ($materialRequest->manager_id != $user->id && $user->role != 'admin') abort(403);

        if ($materialRequest->status != 'shipped') {
            return back()->with('error', 'Hanya permintaan yang dikirim yang bisa diterima.');
        }

        // Move from allocation to project stock
        foreach ($materialRequest->items as $item) {
            $projectMat = $materialRequest->project->projectMaterials()
                ->where('material_id', $item->material_id)->first();
            
            if ($projectMat) {
                // Deduct from allocation and add to project stock
                $projectMat->jumlah_dialokasikan = max(0, $projectMat->jumlah_dialokasikan - $item->quantity);
                $projectMat->jumlah_tersedia += $item->quantity;
                $projectMat->save();
            }
        }

        $materialRequest->update(['status' => 'received']);
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Mengonfirmasi penerimaan barang untuk permintaan ' . $materialRequest->request_number,
        ]);
        return back()->with('success', 'Penerimaan dikonfirmasi. Stok proyek bertambah.');
    }
}
