<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use App\Models\Material;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class StockOpnameController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $opnames = StockOpname::with('user')->latest()->get();
        return view('stock_opnames.index', compact('opnames'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $materials = Material::orderBy('nama_material')->get();
        return view('stock_opnames.create', compact('materials'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);

        $request->validate([
            'date'                       => 'required|date',
            'notes'                      => 'nullable|string',
            'items'                      => 'required|array|min:1',
            'items.*.material_id'        => 'required|exists:materials,id',
            'items.*.physical_stock'     => 'required|integer|min:0',
            'items.*.notes'              => 'nullable|string',
        ]);

        $opname = StockOpname::create([
            'date'    => $request->date,
            'user_id' => auth()->id(),
            'status'  => 'draft',
            'notes'   => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $material = Material::findOrFail($item['material_id']);
            $diff = $item['physical_stock'] - $material->jumlah_tersedia;
            $opname->items()->create([
                'material_id'    => $item['material_id'],
                'system_stock'   => $material->jumlah_tersedia,
                'physical_stock' => $item['physical_stock'],
                'difference'     => $diff,
                'notes'          => $item['notes'] ?? null,
            ]);
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Membuat draft Stock Opname tanggal ' . $request->date,
        ]);

        return redirect()->route('stock-opnames.show', $opname)->with('success', 'Draft Stock Opname berhasil disimpan.');
    }

    public function show(StockOpname $stockOpname)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $stockOpname->load(['user','items.material']);
        return view('stock_opnames.show', compact('stockOpname'));
    }

    public function complete(StockOpname $stockOpname)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        if ($stockOpname->status == 'completed') {
            return back()->with('error', 'Stock Opname ini sudah selesai.');
        }

        // Apply adjustments to master stock
        foreach ($stockOpname->items as $item) {
            if ($item->difference != 0) {
                // Record transaction for adjustment
                MaterialTransaction::create([
                    'user_id' => auth()->id(),
                    'material_id' => $item->material_id,
                    'type' => $item->difference > 0 ? 'in' : 'out',
                    'quantity' => abs($item->difference),
                    'description' => 'Penyesuaian stok via Stock Opname #' . $stockOpname->id . ' (Fisik: ' . $item->physical_stock . ', Sistem: ' . $item->system_stock . ')',
                ]);
            }
            
            $item->material->update(['jumlah_tersedia' => $item->physical_stock]);
        }

        $stockOpname->update(['status' => 'completed']);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Menyelesaikan Stock Opname ID#' . $stockOpname->id . '. Stok disesuaikan.',
        ]);

        return back()->with('success', 'Stock Opname selesai. Stok telah disesuaikan dengan fisik.');
    }

    public function destroy(StockOpname $stockOpname)
    {
        if ($stockOpname->status == 'completed') {
            return back()->with('error', 'Stock Opname yang sudah selesai tidak bisa dihapus.');
        }
        $stockOpname->delete();
        return redirect()->route('stock-opnames.index')->with('success', 'Draft Stock Opname dihapus.');
    }
}
