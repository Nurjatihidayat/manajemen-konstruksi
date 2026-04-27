<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="text-xl font-semibold text-gray-800">Edit Material Proyek</h2>
            <span class="text-sm text-gray-500">{{ $project->nama_proyek }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Update -->
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('projects.materials.update', [$project, $material]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        <!-- Nama Material -->
                        <div>
                            <x-input-label for="nama_material" :value="__('Nama Material')" />
                            <div class="relative mt-1">
                                <x-text-input
                                    id="nama_material"
                                    class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm {{ auth()->user()->role !== 'admin' ? 'bg-gray-100 cursor-not-allowed pr-24' : 'focus:border-indigo-500 focus:ring-indigo-500' }}"
                                    type="text"
                                    name="nama_material"
                                    :value="old('nama_material', $material->nama_material)"
                                    required
                                />
                                @if(auth()->user()->role !== 'admin')
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-700">
                                            Read-only
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <x-input-error :messages="$errors->get('nama_material')" class="mt-2" />
                            @if(auth()->user()->role !== 'admin')
                                <p class="mt-1 text-xs text-gray-500">* Hanya Admin yang dapat mengubah nama master material.</p>
                            @endif
                        </div>

                        <!-- Stok Global -->
                        <div>
                            <x-input-label for="jumlah_tersedia" :value="__('Stok Global (Gudang)')" />
                            <div class="relative mt-1">
                                <x-text-input
                                    id="jumlah_tersedia"
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 pr-24 shadow-sm sm:text-sm cursor-not-allowed"
                                    type="number"
                                    name="jumlah_tersedia"
                                    :value="old('jumlah_tersedia', $material->jumlah_tersedia)"
                                    readonly
                                    title="Stok global hanya dapat diubah melalui modul Master Material atau Stock Opname"
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-700">
                                        Read-only
                                    </span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('jumlah_tersedia')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">
                                * Stok global hanya dapat diubah melalui modul <strong>Master Material</strong> atau <strong>Stock Opname</strong>.
                            </p>
                        </div>

                        <!-- Target Kebutuhan Proyek -->
                        <div>
                            <x-input-label for="jumlah_kebutuhan" :value="__('Target Kebutuhan Proyek')" />
                            <x-text-input
                                id="jumlah_kebutuhan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                type="number"
                                name="jumlah_kebutuhan"
                                :value="old('jumlah_kebutuhan', $material->jumlah_kebutuhan)"
                                min="0"
                                required
                            />
                            <x-input-error :messages="$errors->get('jumlah_kebutuhan')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                            <textarea
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >{{ old('keterangan', $material->keterangan ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 gap-3">
                        <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Hapus (Dipisah agar HTML valid) -->
            <div class="mt-4 bg-white shadow rounded-lg p-4">
                <form action="{{ route('projects.materials.destroy', [$project, $material]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Yakin ingin menghapus material ini dari proyek? Tindakan ini hanya melepaskan pengaitan material, stok global tidak akan berkurang.')"
                            class="flex items-center gap-2 text-sm text-red-600 hover:text-red-800 font-medium transition w-full sm:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Material dari Proyek
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>