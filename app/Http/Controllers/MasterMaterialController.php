<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\ActivityLog;

class MasterMaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('master_materials.index', compact('materials'));
    }

    public function create()
    {
        return view('master_materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_material' => 'nullable|unique:materials,kode_material',
            'nama_material' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'jumlah_tersedia' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
        ]);

        $material = Material::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menambahkan Master Material: ' . $material->nama_material
        ]);

        return redirect()->route('master-materials.index')->with('success', 'Master Material berhasil ditambahkan.');
    }

    public function edit(Material $master_material)
    {
        return view('master_materials.edit', compact('master_material'));
    }

    public function update(Request $request, Material $master_material)
    {
        $request->validate([
            'kode_material' => 'nullable|unique:materials,kode_material,' . $master_material->id,
            'nama_material'  => 'required|string|max:255',
            'satuan'         => 'required|string|max:50',
            'min_stock'      => 'required|integer|min:0',
            'max_stock'      => 'required|integer|min:0',
            'reorder_point'  => 'required|integer|min:0',
        ]);

        // jumlah_tersedia TIDAK diubah di sini. Hanya lewat PO/StockOpname.
        $master_material->update($request->only(['kode_material','nama_material','satuan','min_stock','max_stock','reorder_point']));

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Memperbarui Master Material: ' . $master_material->nama_material
        ]);

        return redirect()->route('master-materials.index')->with('success', 'Master Material berhasil diperbarui.');
    }

    public function destroy(Material $master_material)
    {
        $nama = $master_material->nama_material;
        $master_material->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menghapus Master Material: ' . $nama
        ]);

        return redirect()->route('master-materials.index')->with('success', 'Master Material berhasil dihapus.');
    }
}
