<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Material;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class MaterialController extends Controller
{
    public function create(Project $project)
    {
        $this->authorizeMaterialAction($project);
        return view('materials.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorizeMaterialAction($project);

        $request->validate([
            'nama_material' => 'required',
            'jumlah_tersedia' => 'required|integer|min:0',
            'jumlah_kebutuhan' => 'required|integer|min:0',
        ]);

        $project->materials()->create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menambah material ' . $request->nama_material . ' ke proyek ' . $project->nama_proyek
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Material added successfully.');
    }

    public function edit(Project $project, Material $material)
    {
        $this->authorizeMaterialAction($project);
        return view('materials.edit', compact('project', 'material'));
    }

    public function update(Request $request, Project $project, Material $material)
    {
        $this->authorizeMaterialAction($project);

        $request->validate([
            'nama_material' => 'required',
            'jumlah_tersedia' => 'required|integer|min:0',
            'jumlah_kebutuhan' => 'required|integer|min:0',
        ]);

        $material->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Memperbarui material ' . $material->nama_material . ' pada proyek ' . $project->nama_proyek
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Material updated successfully.');
    }

    public function destroy(Project $project, Material $material)
    {
        $this->authorizeMaterialAction($project);

        $nama = $material->nama_material;
        $material->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menghapus material ' . $nama . ' dari proyek ' . $project->nama_proyek
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Material deleted successfully.');
    }

    public function transaction(Request $request, Project $project, Material $material)
    {
        $request->validate([
            'type' => 'required|in:order,stock_in,dispatch',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $type = $request->type;
        $quantity = $request->quantity;

        // Authorization check for Gudang
        if (auth()->user()->role == 'gudang' && $project->id != auth()->user()->assigned_project_id) {
            abort(403, 'Akses ditolak. Anda tidak ditugaskan di proyek ini.');
        }

        // Logic check: cannot dispatch more than available
        if ($type == 'dispatch' && $material->jumlah_tersedia < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk pengiriman.');
        }

        // Perform stock adjustments
        if ($type == 'stock_in') {
            $material->jumlah_tersedia += $quantity;
            $material->save();
        } elseif ($type == 'dispatch') {
            $material->jumlah_tersedia -= $quantity;
            $material->save();
        }
        // Note: 'order' type does not affect stock count yet

        // Log the transaction
        MaterialTransaction::create([
            'user_id' => auth()->id(),
            'material_id' => $material->id,
            'type' => $type,
            'quantity' => $quantity,
            'description' => $request->description
        ]);

        $status_msg = [
            'order' => 'Order ke supplier berhasil dicatat.',
            'stock_in' => 'Barang masuk berhasil dicatat. Stok bertambah.',
            'dispatch' => 'Pengiriman ke proyek berhasil dicatat. Stok berkurang.'
        ];

        return redirect()->route('projects.show', $project)->with('success', $status_msg[$type]);
    }

    private function authorizeMaterialAction(Project $project)
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            return true;
        }

        if ($user->role == 'manajer' && $project->manager_id == $user->id) {
            return true;
        }

        if ($user->role == 'gudang' && $project->id == $user->assigned_project_id) {
            return true;
        }

        abort(403, 'Anda tidak memiliki akses untuk tindakan ini pada proyek ini.');
    }
}
