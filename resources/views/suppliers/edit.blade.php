<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('✏️ Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Perusahaan / Supplier <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                @error('name') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Contact Person (CP)</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">{{ old('address', $supplier->address) }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-6 mt-6 border-t border-gray-100">
                            <a href="{{ route('suppliers.index') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase text-gray-500 hover:bg-gray-50 transition tracking-widest">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                UPDATE DATA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
