<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('➕ Tambah Master Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('master-materials.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kode Material</label>
                                <input type="text" name="kode_material" value="{{ old('kode_material') }}" placeholder="Contoh: MAT-001" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                @error('kode_material') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Material <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_material" value="{{ old('nama_material') }}" required class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                @error('nama_material') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Satuan <span class="text-red-500">*</span></label>
                                <input type="text" name="satuan" value="{{ old('satuan', 'pcs') }}" required class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Stok Awal Tersedia <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_tersedia" value="{{ old('jumlah_tersedia', 0) }}" required min="0" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6 mt-6">
                            <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-4">Kebijakan Stok</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Min Stock</label>
                                    <input type="number" name="min_stock" value="{{ old('min_stock', 0) }}" required min="0" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Max Stock</label>
                                    <input type="number" name="max_stock" value="{{ old('max_stock', 0) }}" required min="0" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Reorder Point</label>
                                    <input type="number" name="reorder_point" value="{{ old('reorder_point', 0) }}" required min="0" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('master-materials.index') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase text-gray-500 hover:bg-gray-50 transition tracking-widest">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                SIMPAN DATA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
