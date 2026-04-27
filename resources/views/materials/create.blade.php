<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-indigo-900 leading-tight tracking-tighter uppercase">
                📦 Tambah Material Proyek
            </h2>
            <div class="text-xs font-bold text-gray-400 tracking-widest uppercase">
                {{ $project->nama_proyek }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-10">
                    <form action="{{ route('projects.materials.store', $project) }}" method="POST">
                        @csrf

                        <div class="space-y-8">
                            <!-- Section: Material Selection -->
                            <div class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100">
                                <h3 class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-4">Informasi Material</h3>
                                
                                <div class="mb-6">
                                    <x-input-label for="nama_material" :value="__('Nama Material')" class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2" />
                                    <x-text-input id="nama_material" 
                                        class="w-full bg-white border-transparent rounded-2xl focus:ring-indigo-500 shadow-inner transition font-bold" 
                                        type="text" name="nama_material" 
                                        :value="old('nama_material')" 
                                        placeholder="Contoh: Semen, Pasir, Batu Bata" 
                                        required autofocus />
                                    <x-input-error :messages="$errors->get('nama_material')" class="mt-2" />
                                    <p class="text-[9px] text-gray-400 mt-2 italic">* Jika material sudah ada di Master, sistem akan otomatis menghubungkannya.</p>
                                </div>

                                <div>
                                    <x-input-label for="jumlah_tersedia" :value="__('Stok Awal (Jika Material Baru)')" class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2" />
                                    <x-text-input id="jumlah_tersedia" 
                                        class="w-full bg-white border-transparent rounded-2xl focus:ring-indigo-500 shadow-inner transition font-bold" 
                                        type="number" name="jumlah_tersedia" 
                                        :value="old('jumlah_tersedia', 0)" 
                                        required />
                                    <x-input-error :messages="$errors->get('jumlah_tersedia')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Section: Project Specific -->
                            <div class="bg-amber-50/50 p-6 rounded-2xl border border-amber-100">
                                <h3 class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-4">Kebutuhan Proyek</h3>
                                
                                <div>
                                    <x-input-label for="jumlah_kebutuhan" :value="__('Target Kebutuhan Proyek')" class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2" />
                                    <x-text-input id="jumlah_kebutuhan" 
                                        class="w-full bg-white border-transparent rounded-2xl focus:ring-indigo-500 shadow-inner transition font-bold" 
                                        type="number" name="jumlah_kebutuhan" 
                                        :value="old('jumlah_kebutuhan', 0)" 
                                        min="0" required />
                                    <x-input-error :messages="$errors->get('jumlah_kebutuhan')" class="mt-2" />
                                    <p class="text-[9px] text-gray-400 mt-2 italic text-amber-600 font-bold">* Rencana jumlah material yang dibutuhkan untuk menyelesaikan proyek ini.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-4">
                            <a href="{{ route('projects.show', $project) }}" class="text-[10px] font-black text-gray-400 hover:text-gray-900 transition uppercase tracking-widest">Batal</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-green-200 transition transform hover:-translate-y-1">
                                SIMPAN MATERIAL KE PROYEK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
