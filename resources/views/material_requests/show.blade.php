<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            🔍 Detail Permintaan: {{ $materialRequest->request_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md">
                <p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border-l-8 border-red-500 p-4 rounded-xl shadow-md">
                <p class="text-red-700 text-sm font-bold">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <!-- Header Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-gray-50">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Proyek</p>
                            <p class="font-black text-indigo-900">{{ $materialRequest->project->nama_proyek }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Manager</p>
                            <p class="font-bold text-gray-700">{{ $materialRequest->manager->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal</p>
                            <p class="font-bold text-gray-700">{{ $materialRequest->request_date }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</p>
                            @php
                                $statusColor = [
                                    'pending'  => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-blue-100 text-blue-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    'shipped'  => 'bg-blue-100 text-blue-700',
                                    'received' => 'bg-emerald-100 text-emerald-700',
                                ][$materialRequest->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $statusColor }}">{{ strtoupper($materialRequest->status) }}</span>
                        </div>
                        @if($materialRequest->notes)
                        <div class="md:col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Catatan</p>
                            <p class="text-sm text-gray-600">{{ $materialRequest->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Items Table -->
                    <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-4">Item Material</h4>
                    <table class="w-full text-left font-sans mb-8">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Gudang</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jumlah Diminta</th>
                                <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($materialRequest->items as $item)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $item->material->nama_material }}</td>
                                <td class="px-4 py-3 text-center text-indigo-600 font-bold">{{ $item->material->jumlah_tersedia }} {{ $item->material->satuan }}</td>
                                <td class="px-4 py-3 text-center font-black text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($item->priority == 'high')
                                        <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-black uppercase bg-red-100 text-red-700">🔴 Tinggi</span>
                                    @elseif($item->priority == 'medium')
                                        <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-100 text-amber-700">🟡 Sedang</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">🟢 Rendah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-50">
                        <!-- Gudang/Admin Actions -->
                        @if(in_array(auth()->user()->role, ['gudang','admin']))
                            @if($materialRequest->status == 'pending')
                            <form action="{{ route('material-requests.approve', $materialRequest) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-100 transition">
                                    ✅ SETUJUI
                                </button>
                            </form>
                            <form action="{{ route('material-requests.reject', $materialRequest) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-red-100 transition">
                                    ❌ TOLAK
                                </button>
                            </form>
                            @endif

                            @if($materialRequest->status == 'approved')
                            <form action="{{ route('material-requests.ship', $materialRequest) }}" method="POST" onsubmit="return confirm('Kirim barang dan kurangi stok gudang?')">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-100 transition">
                                    🚚 KIRIM BARANG
                                </button>
                            </form>
                            @endif
                        @endif

                        <!-- Manager Actions -->
                        @if(auth()->user()->role == 'manajer' || auth()->user()->role == 'admin')
                            @if($materialRequest->status == 'shipped')
                            <form action="{{ route('material-requests.receive', $materialRequest) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa barang telah diterima di lokasi proyek?')">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition">
                                    📦 KONFIRMASI PENERIMAAN
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('material-requests.index') }}" class="inline-flex items-center text-[10px] font-black text-indigo-400 hover:text-indigo-900 transition uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                KEMBALI
            </a>
        </div>
    </div>
</x-app-layout>
