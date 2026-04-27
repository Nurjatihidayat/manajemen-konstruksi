<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">📊 Detail Stock Opname — {{ $stockOpname->date }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))<div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md"><p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p></div>@endif
            @if(session('error'))<div class="bg-red-50 border-l-8 border-red-500 p-4 rounded-xl shadow-md"><p class="text-red-700 text-sm font-bold">{{ session('error') }}</p></div>@endif

            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-gray-50">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Petugas</p>
                            <p class="font-black text-indigo-900">{{ $stockOpname->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</p>
                            @if($stockOpname->status == 'completed')
                                <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">✅ SELESAI</span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-100 text-amber-700">⏳ DRAFT</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Catatan</p>
                            <p class="text-sm text-gray-600">{{ $stockOpname->notes ?? '-' }}</p>
                        </div>
                    </div>

                    <table class="w-full text-left font-sans mb-8">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Sistem</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Fisik</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Selisih</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($stockOpname->items as $item)
                            <tr class="hover:bg-indigo-50/20 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $item->material->nama_material }}</td>
                                <td class="px-4 py-3 text-center font-bold text-gray-500">{{ $item->system_stock }}</td>
                                <td class="px-4 py-3 text-center font-black text-indigo-700">{{ $item->physical_stock }}</td>
                                <td class="px-4 py-3 text-center font-black {{ $item->difference > 0 ? 'text-emerald-600' : ($item->difference < 0 ? 'text-red-600' : 'text-gray-400') }}">
                                    {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $item->notes ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($stockOpname->status == 'draft')
                    <div class="pt-6 border-t border-gray-50">
                        <p class="text-xs text-amber-600 font-bold mb-4">⚠️ Setelah dikonfirmasi, stok master material akan disesuaikan dengan stok fisik dan tidak dapat diubah kembali.</p>
                        <form action="{{ route('stock-opnames.complete', $stockOpname) }}" method="POST" onsubmit="return confirm('Konfirmasi dan sesuaikan stok? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition">
                                ✅ KONFIRMASI & SESUAIKAN STOK
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('stock-opnames.index') }}" class="inline-flex items-center text-[10px] font-black text-indigo-400 hover:text-indigo-900 transition uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                KEMBALI
            </a>
        </div>
    </div>
</x-app-layout>
