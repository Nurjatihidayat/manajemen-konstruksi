<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">📊 Stock Opname</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))<div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md"><p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p></div>@endif
            @if(session('error'))<div class="bg-red-50 border-l-8 border-red-500 p-4 rounded-xl shadow-md"><p class="text-red-700 text-sm font-bold">{{ session('error') }}</p></div>@endif

            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">Riwayat Stock Opname</h3>
                        <a href="{{ route('stock-opnames.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">+ BUAT OPNAME</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Petugas</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Catatan</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($opnames as $op)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $op->date }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $op->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($op->status == 'completed')
                                            <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">SELESAI</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-100 text-amber-700">DRAFT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">{{ Str::limit($op->notes, 50) ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('stock-opnames.show', $op) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @if($op->status == 'draft')
                                            <form action="{{ route('stock-opnames.destroy', $op) }}" method="POST" onsubmit="return confirm('Hapus draft opname ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada stock opname --</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
