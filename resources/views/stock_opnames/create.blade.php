<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">📊 Buat Stock Opname</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('stock-opnames.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Opname <span class="text-red-500">*</span></label>
                                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Catatan</label>
                                <input type="text" name="notes" value="{{ old('notes') }}" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition" placeholder="Keterangan...">
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-1">Input Stok Fisik</h4>
                            <p class="text-xs text-gray-400 mb-4">Masukkan stok aktual yang dihitung secara fisik di gudang. Kolom "Sistem" adalah data di database saat ini.</p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-sans">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</th>
                                            <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Sistem</th>
                                            <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stok Fisik</th>
                                            <th class="px-4 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Catatan Item</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($materials as $i => $mat)
                                        <tr class="hover:bg-indigo-50/20 transition-colors">
                                            <td class="px-4 py-3 font-bold text-gray-900">
                                                {{ $mat->nama_material }}
                                                <input type="hidden" name="items[{{ $i }}][material_id]" value="{{ $mat->id }}">
                                            </td>
                                            <td class="px-4 py-3 text-center text-indigo-600 font-black text-lg">{{ $mat->jumlah_tersedia }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="number" name="items[{{ $i }}][physical_stock]" required min="0" value="{{ $mat->jumlah_tersedia }}"
                                                    class="w-24 bg-gray-50 border-transparent rounded-xl focus:ring-indigo-500 focus:bg-white shadow-inner text-center font-bold text-sm transition">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="items[{{ $i }}][notes]" class="w-full bg-gray-50 border-transparent rounded-xl focus:ring-indigo-500 focus:bg-white shadow-inner text-sm transition" placeholder="...">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-8">
                            <a href="{{ route('stock-opnames.index') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase text-gray-500 hover:bg-gray-50 transition tracking-widest">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">SIMPAN DRAFT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
