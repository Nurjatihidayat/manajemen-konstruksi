<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            📋 Permintaan Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md flex items-center justify-between">
                <p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border-l-8 border-red-500 p-4 rounded-xl shadow-md">
                <p class="text-red-700 text-sm font-bold">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">Daftar Permintaan</h3>
                        @if(auth()->user()->role == 'manajer' || auth()->user()->role == 'admin')
                        <a href="{{ route('material-requests.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                            + AJUKAN PERMINTAAN
                        </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No. Permintaan</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek</th>
                                    @if(auth()->user()->role != 'manajer')
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Manager</th>
                                    @endif
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tgl Request</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Item</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($requests as $req)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 font-black text-indigo-700 text-sm">{{ $req->request_number }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $req->project->nama_proyek }}</td>
                                    @if(auth()->user()->role != 'manajer')
                                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $req->manager->name ?? '-' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">{{ $req->request_date }}</td>
                                    <td class="px-6 py-4 text-center font-bold">{{ $req->items->count() }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusColor = [
                                                'pending'  => 'bg-amber-100 text-amber-700',
                                                'approved' => 'bg-blue-100 text-blue-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                'shipped'  => 'bg-emerald-100 text-emerald-700',
                                                'received' => 'bg-green-100 text-green-700',
                                            ][$req->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $statusColor }}">{{ strtoupper($req->status) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('material-requests.show', $req) }}" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition inline-flex">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada permintaan --</td>
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
