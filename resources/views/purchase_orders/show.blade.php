<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">🛒 Detail PO: {{ $purchaseOrder->po_number }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))<div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md"><p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p></div>@endif
            @if(session('error'))<div class="bg-red-50 border-l-8 border-red-500 p-4 rounded-xl shadow-md"><p class="text-red-700 text-sm font-bold">{{ session('error') }}</p></div>@endif

            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-gray-50">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Supplier</p>
                            <p class="font-black text-indigo-900">{{ $purchaseOrder->supplier->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Est. Tiba</p>
                            <p class="font-bold text-gray-700">{{ $purchaseOrder->expected_date ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</p>
                            @php $sc=['pending'=>'bg-amber-100 text-amber-700','approved'=>'bg-blue-100 text-blue-700','completed'=>'bg-emerald-100 text-emerald-700','cancelled'=>'bg-red-100 text-red-700'][$purchaseOrder->status]??'bg-gray-100 text-gray-700'; @endphp
                            <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $sc }}">{{ strtoupper($purchaseOrder->status) }}</span>
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-4">Item PO</h4>
                    <table class="w-full text-left font-sans mb-8">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Harga/Unit</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php $grandTotal = 0; @endphp
                            @foreach($purchaseOrder->items as $item)
                            @php $total = ($item->price ?? 0) * $item->quantity; $grandTotal += $total; @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $item->material->nama_material }}</td>
                                <td class="px-4 py-3 text-center font-black">{{ $item->quantity }} {{ $item->material->satuan }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}</td>
                                <td class="px-4 py-3 text-center font-bold text-indigo-700">{{ $item->price ? 'Rp ' . number_format($total, 0, ',', '.') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @if($grandTotal > 0)
                        <tfoot>
                            <tr class="border-t-2 border-indigo-100">
                                <td colspan="3" class="px-4 py-3 text-right font-black text-gray-700 uppercase text-xs">Grand Total</td>
                                <td class="px-4 py-3 text-center font-black text-indigo-700">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    @if($purchaseOrder->status == 'pending')
                    <div class="pt-6 border-t border-gray-50">
                        <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}" method="POST" onsubmit="return confirm('Konfirmasi barang masuk? Stok akan bertambah otomatis.')">
                            @csrf
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition">
                                📦 KONFIRMASI BARANG MASUK
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('purchase-orders.index') }}" class="inline-flex items-center text-[10px] font-black text-indigo-400 hover:text-indigo-900 transition uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                KEMBALI
            </a>
        </div>
    </div>
</x-app-layout>
