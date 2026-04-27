<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">🛒 Buat Purchase Order</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('purchase-orders.store') }}" method="POST" id="poForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Supplier <span class="text-red-500">*</span></label>
                                <select name="supplier_id" required class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Estimasi Tiba</label>
                                <input type="date" name="expected_date" value="{{ old('expected_date') }}" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Catatan</label>
                            <textarea name="notes" rows="2" class="w-full bg-gray-50 border-transparent rounded-2xl focus:ring-indigo-500 focus:bg-white shadow-inner transition" placeholder="...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest">Item PO</h4>
                                <button type="button" id="addItem" class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">+ Tambah Item</button>
                            </div>
                            <div id="itemsContainer" class="space-y-4">
                                <div class="item-row grid grid-cols-12 gap-3 items-end p-4 bg-gray-50 rounded-2xl">
                                    <div class="col-span-5">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Material</label>
                                        <select name="items[0][material_id]" required class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm">
                                            <option value="">-- Pilih --</option>
                                            @foreach($materials as $mat)
                                            <option value="{{ $mat->id }}">{{ $mat->nama_material }} (Stok: {{ $mat->jumlah_tersedia }} {{ $mat->satuan }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah</label>
                                        <input type="number" name="items[0][quantity]" required min="1" class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm" placeholder="0">
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Harga (Rp)</label>
                                        <input type="number" name="items[0][price]" min="0" step="0.01" class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm" placeholder="0">
                                    </div>
                                    <div class="col-span-2 flex justify-end">
                                        <button type="button" class="remove-item p-2 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition hidden">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-8">
                            <a href="{{ route('purchase-orders.index') }}" class="px-6 py-3 rounded-2xl text-xs font-black uppercase text-gray-500 hover:bg-gray-50 transition tracking-widest">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">SIMPAN PO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    const mats = @json($materials);
    let n = 1;
    function opts(sel='') { return '<option value="">-- Pilih --</option>' + mats.map(m=>`<option value="${m.id}" ${m.id==sel?'selected':''}>${m.nama_material} (Stok: ${m.jumlah_tersedia} ${m.satuan})</option>`).join(''); }
    document.getElementById('addItem').onclick = function(){
        const c = document.getElementById('itemsContainer');
        const d = document.createElement('div');
        d.className='item-row grid grid-cols-12 gap-3 items-end p-4 bg-gray-50 rounded-2xl';
        d.innerHTML=`<div class="col-span-5"><label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Material</label><select name="items[${n}][material_id]" required class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm">${opts()}</select></div><div class="col-span-2"><label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jumlah</label><input type="number" name="items[${n}][quantity]" required min="1" class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm" placeholder="0"></div><div class="col-span-3"><label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Harga (Rp)</label><input type="number" name="items[${n}][price]" min="0" step="0.01" class="w-full bg-white border-transparent rounded-xl focus:ring-indigo-500 shadow-sm text-sm" placeholder="0"></div><div class="col-span-2 flex justify-end"><button type="button" class="remove-item p-2 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></div>`;
        c.appendChild(d); n++;
        document.querySelectorAll('.remove-item').forEach(b=>b.onclick=function(){this.closest('.item-row').remove();});
    };
    </script>
</x-app-layout>
