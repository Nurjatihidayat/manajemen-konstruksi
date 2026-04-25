<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('🏗️ Detail Proyek') }}: {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Progress Alerts -->
            @if($project->progres < 100)
            <div class="bg-amber-50 border-l-8 border-amber-500 p-6 rounded-2xl shadow-md flex items-center justify-between">
                <div>
                    <h4 class="text-amber-800 font-black uppercase text-sm tracking-widest mb-1">Status: Sedang Berjalan</h4>
                    <p class="text-amber-700 text-xs font-semibold">Projek masih dalam tahap konstruksi dan pengerjaan lapangan.</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-amber-600">{{ $project->progres }}%</span>
                </div>
            </div>
            @else
            <div class="bg-emerald-50 border-l-8 border-emerald-500 p-6 rounded-2xl shadow-md flex items-center justify-between">
                <div>
                    <h4 class="text-emerald-800 font-black uppercase text-sm tracking-widest mb-1">Status: Proyek Selesai</h4>
                    <p class="text-emerald-700 text-xs font-semibold">Seluruh tahapan pengerjaan telah rampung 100%.</p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-emerald-600">✓ 100%</span>
                </div>
            </div>
            @endif

            <!-- Project Info Card -->
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-8 pb-6 border-b border-gray-50">
                        <div>
                            <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter mb-2">Informasi Proyek</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2 text-sm">
                                <p class="text-gray-500 font-bold"><span class="text-indigo-400">LOC:</span> {{ $project->lokasi }}</p>
                                <p class="text-gray-500 font-bold"><span class="text-indigo-400">PERIOD:</span> {{ $project->tanggal_mulai }} <span class="text-pink-400">>></span> {{ $project->tanggal_selesai }}</p>
                                <p class="text-gray-500 font-bold"><span class="text-indigo-400">MANAGER:</span> {{ $project->manager->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if(Auth::user()->role == 'admin' || (Auth::user()->role == 'manajer' && $project->manager_id == auth()->id()))
                        <a href="{{ route('projects.edit', $project) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-amber-100 transition transform hover:-translate-y-1">
                            EDIT DATA
                        </a>
                        @endif
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">Inventaris Material</h3>
                            @if(Auth::user()->role == 'admin' || 
                                (Auth::user()->role == 'manajer' && $project->manager_id == auth()->id()) ||
                                (Auth::user()->role == 'gudang' && $project->id == Auth::user()->assigned_project_id))
                            <a href="{{ route('projects.materials.create', $project) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition transform hover:-translate-y-1">
                                + TAMBAH ITEM
                            </a>
                            @endif
                        </div>

                        <div class="overflow-x-auto" x-data="{ openModal: null, materialId: null, materialName: '' }">
                            <table class="w-full text-left font-sans">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tersedia</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kebutuhan</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kekurangan</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($project->materials as $material)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        <td class="px-6 py-4 font-black text-gray-900">{{ $material->nama_material }}</td>
                                        <td class="px-6 py-4 text-center font-bold">{{ $material->jumlah_tersedia }}</td>
                                        <td class="px-6 py-4 text-center text-gray-500">{{ $material->jumlah_kebutuhan }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-black {{ $material->kekurangan > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                                                {{ $material->kekurangan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($material->kekurangan > 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-red-100 text-red-700">KRITIKAL</span>
                                            @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700">AMAN</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                @if(Auth::user()->role == 'gudang' || Auth::user()->role == 'admin')
                                                    <button @click="openModal = 'order'; materialId = {{ $material->id }}; materialName = '{{ $material->nama_material }}'" 
                                                        class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    </button>
                                                    <button @click="openModal = 'stock_in'; materialId = {{ $material->id }}; materialName = '{{ $material->nama_material }}'" 
                                                        class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    </button>
                                                    <button @click="openModal = 'dispatch'; materialId = {{ $material->id }}; materialName = '{{ $material->nama_material }}'" 
                                                        class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                                    </button>
                                                @endif

                                                @if(Auth::user()->role == 'admin' || 
                                                   (Auth::user()->role == 'manajer' && $project->manager_id == auth()->id()) ||
                                                   (Auth::user()->role == 'gudang' && $project->id == Auth::user()->assigned_project_id))
                                                    <a href="{{ route('projects.materials.edit', [$project, $material]) }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-600 hover:text-white rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('projects.materials.destroy', [$project, $material]) }}" method="POST" onsubmit="return confirm('Hapus material ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Data Kosong --</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Modals -->
                            <template x-if="openModal">
                                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-indigo-900/40 backdrop-blur-md transition-all">
                                    <div class="bg-white rounded-3xl shadow-3xl max-w-md w-full p-10 ring-1 ring-gray-100">
                                        <div class="flex justify-between items-center mb-8">
                                            <h4 class="text-2xl font-black text-indigo-900 uppercase tracking-tighter" 
                                                x-text="openModal === 'order' ? 'Pre-Order Material' : (openModal === 'stock_in' ? 'Stok Masuk' : 'Keluar Unit')"></h4>
                                            <button @click="openModal = null" class="text-gray-300 hover:text-red-500 transition">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        
                                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-6">Item: <span x-text="materialName" class="text-indigo-600"></span></p>

                                        <form :action="'{{ route('projects.materials.transaction', [$project, ':material']) }}'.replace(':material', materialId)" method="POST" class="space-y-6">
                                            @csrf
                                            <input type="hidden" name="type" :value="openModal">
                                            
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Volume/Jumlah</label>
                                                <input type="number" name="quantity" required min="1" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Catatan Logistik</label>
                                                <textarea name="description" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition" rows="3" placeholder="..."></textarea>
                                            </div>

                                            <div class="flex justify-end space-x-4 pt-6">
                                                <button type="button" @click="openModal = null" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase text-gray-400 hover:bg-gray-50 transition tracking-widest">Batal</button>
                                                <button type="submit" 
                                                    :class="{
                                                        'bg-indigo-600 hover:bg-indigo-700': openModal === 'order',
                                                        'bg-emerald-600 hover:bg-emerald-700': openModal === 'stock_in',
                                                        'bg-amber-600 hover:bg-amber-700': openModal === 'dispatch'
                                                    }"
                                                    class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase text-white shadow-xl transition-all hover:scale-105 tracking-[0.1em]">
                                                    SIMPAN LOGISTIK
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-start">
                <a href="{{ route('projects.index') }}" class="text-[10px] font-black text-indigo-400 hover:text-indigo-900 flex items-center transition uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    KEMBALI KE LIST PROYEK
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
