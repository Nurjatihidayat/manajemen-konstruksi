<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\ActivityLog;
use App\Models\MaterialTransaction;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $orders = PurchaseOrder::with(['supplier','items.material'])->latest()->get();
        return view('purchase_orders.index', compact('orders'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $suppliers = Supplier::all();
        $materials = Material::orderBy('nama_material')->get();
        return view('purchase_orders.create', compact('suppliers','materials'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);

        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'expected_date'        => 'nullable|date',
            'notes'                => 'nullable|string',
            'items'                => 'required|array|min:1',
            'items.*.material_id'  => 'required|exists:materials,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.price'        => 'nullable|numeric|min:0',
        ]);

        $poNumber = 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $po = PurchaseOrder::create([
            'po_number'     => $poNumber,
            'supplier_id'   => $request->supplier_id,
            'status'        => 'pending',
            'expected_date' => $request->expected_date,
            'notes'         => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $po->items()->create([
                'material_id' => $item['material_id'],
                'quantity'    => $item['quantity'],
                'price'       => $item['price'] ?? null,
            ]);
        }

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Membuat Purchase Order ' . $poNumber,
        ]);

        return redirect()->route('purchase-orders.index')->with('success', 'PO berhasil dibuat.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        $purchaseOrder->load(['supplier','items.material']);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function receive(PurchaseOrder $purchaseOrder)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        if ($purchaseOrder->status == 'completed') {
            return back()->with('error', 'PO ini sudah selesai.');
        }

        // Add stock to master materials
        foreach ($purchaseOrder->items as $item) {
            $item->material->increment('jumlah_tersedia', $item->quantity);

            // Record transaction
            MaterialTransaction::create([
                'user_id' => auth()->id(),
                'material_id' => $item->material_id,
                'type' => 'in',
                'quantity' => $item->quantity,
                'description' => 'Penerimaan barang dari PO ' . $purchaseOrder->po_number . ' (Supplier: ' . $purchaseOrder->supplier->name . ')',
            ]);
        }

        $purchaseOrder->update(['status' => 'completed']);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Menerima barang PO ' . $purchaseOrder->po_number . '. Stok bertambah.',
        ]);

        return back()->with('success', 'Barang masuk dicatat. Stok bertambah.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if (!in_array(auth()->user()->role, ['gudang','admin'])) abort(403);
        if ($purchaseOrder->status == 'completed') {
            return back()->with('error', 'PO yang sudah selesai tidak bisa dihapus.');
        }
        $purchaseOrder->delete();
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'description' => 'Membatalkan PO ' . $purchaseOrder->po_number,
        ]);
        return redirect()->route('purchase-orders.index')->with('success', 'PO dibatalkan.');
    }
}
