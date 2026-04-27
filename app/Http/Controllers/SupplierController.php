<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\ActivityLog;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menambahkan Supplier: ' . $supplier->name
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Memperbarui Supplier: ' . $supplier->name
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $nama = $supplier->name;
        $supplier->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => 'Menghapus Supplier: ' . $nama
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
