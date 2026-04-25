<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Material') }} - {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.materials.update', [$project, $material]) }}" method="POST" class="max-w-xl">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <x-input-label for="nama_material" :value="__('Nama Material')" />
                            <x-text-input id="nama_material" class="block mt-1 w-full {{ auth()->user()->role == 'gudang' ? 'bg-gray-100 cursor-not-allowed' : '' }}" type="text" name="nama_material" :value="old('nama_material', $material->nama_material)" required 
                                {{ auth()->user()->role == 'gudang' ? 'readonly' : '' }} />
                            <x-input-error :messages="$errors->get('nama_material')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <x-input-label for="jumlah_tersedia" :value="__('Jumlah Tersedia (Input Stok)')" />
                                <x-text-input id="jumlah_tersedia" class="block mt-1 w-full" type="number" name="jumlah_tersedia" :value="old('jumlah_tersedia', $material->jumlah_tersedia)" min="0" required autofocus />
                                <x-input-error :messages="$errors->get('jumlah_tersedia')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="jumlah_kebutuhan" :value="__('Jumlah Kebutuhan')" />
                                <x-text-input id="jumlah_kebutuhan" class="block mt-1 w-full {{ auth()->user()->role == 'gudang' ? 'bg-gray-100 cursor-not-allowed' : '' }}" type="number" name="jumlah_kebutuhan" :value="old('jumlah_kebutuhan', $material->jumlah_kebutuhan)" min="0" required 
                                    {{ auth()->user()->role == 'gudang' ? 'readonly' : '' }} />
                                <x-input-error :messages="$errors->get('jumlah_kebutuhan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('projects.show', $project) }}" class="text-gray-600 hover:underline">Batal</a>
                            <x-primary-button class="bg-yellow-600 hover:bg-yellow-700 font-bold">
                                {{ __('Update Material') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
