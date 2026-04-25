<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('✏️ Edit Proyek') }}: {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-10">
                    <form action="{{ route('projects.update', $project) }}" method="POST" class="max-w-3xl">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Nama Proyek -->
                            <div class="col-span-2">
                                <x-input-label for="nama_proyek" :value="__('Nama Proyek')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <x-text-input id="nama_proyek" class="block w-full rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm transition" type="text" name="nama_proyek" :value="old('nama_proyek', $project->nama_proyek)" required />
                                <x-input-error :messages="$errors->get('nama_proyek')" class="mt-2" />
                            </div>

                            <!-- Lokasi -->
                            <div class="col-span-2">
                                <x-input-label for="lokasi" :value="__('Lokasi')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <x-text-input id="lokasi" class="block w-full rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm transition" type="text" name="lokasi" :value="old('lokasi', $project->lokasi)" required />
                                <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                            </div>

                            <!-- Manajer Assignment -->
                            <div class="col-span-1">
                                <x-input-label for="manager_id" :value="__('Penanggung Jawab (Manajer)')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <select name="manager_id" id="manager_id" class="block w-full rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm transition">
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}" {{ old('manager_id', $project->manager_id) == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
                            </div>

                            <!-- Progress (%) -->
                            <div class="col-span-1">
                                <x-input-label for="progres" :value="__('Update Progres Lapangan (%)')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <div class="flex items-center gap-4">
                                    <x-text-input id="progres" class="block w-24 rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm" type="number" name="progres" :value="old('progres', $project->progres)" min="0" max="100" />
                                    <div class="flex-1 bg-gray-100 rounded-full h-2">
                                        <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ $project->progres }}%"></div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('progres')" class="mt-2" />
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="col-span-1">
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <x-text-input id="tanggal_mulai" class="block w-full rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm" type="date" name="tanggal_mulai" :value="old('tanggal_mulai', $project->tanggal_mulai)" required />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="col-span-1">
                                <x-input-label for="tanggal_selesai" :value="__('Target Selesai')" class="font-bold text-gray-700 uppercase text-xs tracking-widest mb-2" />
                                <x-text-input id="tanggal_selesai" class="block w-full rounded-2xl border-gray-200 focus:ring-amber-500 focus:border-amber-500 shadow-sm" type="date" name="tanggal_selesai" :value="old('tanggal_selesai', $project->tanggal_selesai)" required />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 gap-6 pt-6 border-t border-gray-50">
                            <a href="{{ route('projects.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-900 transition uppercase tracking-widest">Batal</a>
                            <x-primary-button class="bg-amber-600 hover:bg-amber-700 rounded-2xl py-3 px-8 shadow-amber-200 shadow-lg hover:shadow-amber-300 transition-all duration-300">
                                {{ __('SIMPAN PERUBAHAN 💾') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
