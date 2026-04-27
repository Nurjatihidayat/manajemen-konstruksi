<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('📦 Master Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
            <div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md flex items-center justify-between mb-6">
                <div>
                    <h4 class="text-emerald-800 font-black uppercase text-sm tracking-widest mb-1">Berhasil!</h4>
                    <p class="text-emerald-700 text-xs font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">Daftar Material Global</h3>
                        <a href="{{ route('master-materials.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                            + TAMBAH MATERIAL
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Material</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Satuan</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Min/Max/Reorder</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($materials as $item)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-500">{{ $item->kode_material ?? '-' }}</td>
                                    <td class="px-6 py-4 font-black text-gray-900">{{ $item->nama_material }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-indigo-600 text-lg">{{ $item->jumlah_tersedia }}</td>
                                    <td class="px-6 py-4 text-center text-gray-500 text-xs">{{ $item->satuan }}</td>
                                    <td class="px-6 py-4 text-center text-xs">
                                        <span class="text-gray-400">Min:</span> <span class="font-bold">{{ $item->min_stock }}</span> <br>
                                        <span class="text-gray-400">Max:</span> <span class="font-bold">{{ $item->max_stock }}</span> <br>
                                        <span class="text-orange-400 font-bold">Reorder: {{ $item->reorder_point }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->jumlah_tersedia <= $item->min_stock)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-red-100 text-red-700">KRITIS</span>
                                        @elseif($item->jumlah_tersedia <= $item->reorder_point)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-100 text-amber-700">WARNING</span>
                                        @elseif($item->jumlah_tersedia >= $item->max_stock && $item->max_stock > 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-blue-100 text-blue-700">OVERSTOCK</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">AMAN</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('master-materials.edit', $item) }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-600 hover:text-white rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('master-materials.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus master material ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada data material --</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
