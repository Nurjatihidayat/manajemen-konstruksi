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
                                                                          <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Lokasi</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Sedang Dikirim</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Rencana</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Kekurangan</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($project->projectMaterials as $pm)
                                    <tr class="hover:bg-indigo-50/30 transition-colors">
                                        <td class="px-6 py-4 font-black text-gray-900">{{ $pm->material->nama_material }}</td>
                                        <td class="px-6 py-4 text-center font-black text-indigo-600">{{ $pm->jumlah_tersedia }} <span class="text-[8px] text-gray-400">{{ $pm->material->satuan }}</span></td>
                                        <td class="px-6 py-4 text-center font-bold text-amber-500">{{ $pm->jumlah_dialokasikan }}</td>
                                        <td class="px-6 py-4 text-center text-gray-400">{{ $pm->jumlah_kebutuhan }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-black {{ $pm->sisa_kebutuhan > 0 ? 'text-red-500' : 'text-emerald-500' }}">
                                                {{ $pm->sisa_kebutuhan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                @if(Auth::user()->role == 'admin' || (Auth::user()->role == 'manajer' && $project->manager_id == auth()->id()))
                                                    <a href="{{ route('projects.materials.edit', [$project, $pm->material->id]) }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-600 hover:text-white rounded-xl transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('projects.materials.destroy', [$project, $pm->material->id]) }}" method="POST" onsubmit="return confirm('Hapus material ini dari proyek?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada material direncanakan --</td></tr>
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

            <!-- Progress Update Form (Manager) -->
            @if(Auth::user()->role == 'manajer' && $project->manager_id == auth()->id() || Auth::user()->role == 'admin')
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100" x-data="{ open: false }">
                <div class="p-8">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">📈 Update Progres & Pemakaian Material</h3>
                        <button @click="open = !open" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">
                            <span x-text="open ? 'TUTUP' : 'UPDATE SEKARANG'">UPDATE SEKARANG</span>
                        </button>
                    </div>
                    <div x-show="open" x-transition class="mt-6 border-t border-gray-50 pt-6">
                        <form action="{{ route('projects.progress.store', $project) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Persentase Progres (%) <span class="text-red-500">*</span></label>
                                    <input type="number" name="progress_percentage" required min="0" max="100" value="{{ $project->progres }}"
                                        class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Update <span class="text-red-500">*</span></label>
                                    <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                                        class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                                    <textarea name="description" required rows="2" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition" placeholder="Apa yang dikerjakan hari ini?"></textarea>
                                </div>
                            </div>

                            <!-- Material Usage Section -->
                            <div class="bg-slate-50 p-6 rounded-3xl mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-xs font-black text-indigo-900 uppercase tracking-widest">📦 Pemakaian Material Hari Ini</h4>
                                    <button type="button" id="addUsageItem" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-900">+ Tambah Material</button>
                                </div>
                                <div id="usageContainer" class="space-y-3"></div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Foto Dokumentasi</label>
                                    <input type="file" name="photo" accept="image/*" class="text-xs text-gray-400">
                                </div>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                    SIMPAN LAPORAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                const projectMaterials = @json($project->projectMaterials->load('material'));
                let usageIdx = 0;
                function addUsageRow() {
                    const container = document.getElementById('usageContainer');
                    const div = document.createElement('div');
                    div.className = 'grid grid-cols-12 gap-3 items-end bg-white p-3 rounded-2xl shadow-sm border border-gray-100';
                    div.innerHTML = `
                        <div class="col-span-7">
                            <select name="materials[${usageIdx}][material_id]" class="w-full border-transparent bg-gray-50 rounded-xl text-xs focus:ring-indigo-500">
                                <option value="">-- Pilih Material --</option>
                                ${projectMaterials.map(pm => `<option value="${pm.material_id}">${pm.material.nama_material} (Tersedia: ${pm.jumlah_tersedia} ${pm.material.satuan})</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="materials[${usageIdx}][quantity]" placeholder="Qty" class="w-full border-transparent bg-gray-50 rounded-xl text-xs focus:ring-indigo-500">
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <button type="button" class="remove-usage text-red-400 hover:text-red-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    `;
                    container.appendChild(div);
                    div.querySelector('.remove-usage').onclick = () => div.remove();
                    usageIdx++;
                }
                document.getElementById('addUsageItem').onclick = addUsageRow;
            </script>
            @endif

            <!-- Progress History -->
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter mb-8 pb-4 border-b border-gray-50">🕒 Riwayat Update & Pemakaian</h3>
                    <div class="space-y-8">
                        @forelse($project->progressUpdates as $update)
                        <div class="flex gap-6 relative">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 rounded-full bg-indigo-600 ring-4 ring-indigo-50"></div>
                                <div class="w-0.5 flex-1 bg-gray-100 my-1"></div>
                            </div>
                            <div class="flex-1 pb-8">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-sm font-black text-gray-800">{{ $update->date }} <span class="text-[10px] text-gray-400 font-bold uppercase ml-2">— {{ $update->progress_percentage }}%</span></h4>
                                </div>
                                <p class="text-xs text-gray-600 italic mb-4">"{{ $update->description }}"</p>
                                
                                @if($update->photo_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $update->photo_path) }}" class="w-48 rounded-2xl shadow-lg border border-gray-100">
                                </div>
                                @endif

                                @if($update->materialUsages->count() > 0)
                                <div class="bg-gray-50 p-4 rounded-2xl inline-block min-w-[300px]">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Material Digunakan:</p>
                                    <ul class="space-y-1">
                                        @foreach($update->materialUsages as $usage)
                                        <li class="text-[11px] font-bold text-gray-700 flex justify-between">
                                            <span>{{ $usage->material->nama_material }}</span>
                                            <span class="text-indigo-600">{{ $usage->quantity_used }} {{ $usage->material->satuan }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-center py-8 text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada riwayat update --</p>
                        @endforelse
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

