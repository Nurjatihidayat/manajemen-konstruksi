<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            {{ __('🚚 Manajemen Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-8 border-emerald-500 p-4 rounded-xl shadow-md flex items-center justify-between mb-6">
                <div>
                    <h4 class="text-emerald-800 font-black uppercase text-sm tracking-widest mb-1">Berhasil!</h4>
                    <p class="text-emerald-700 text-xs font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter">Daftar Supplier / Vendor</h3>
                        <a href="{{ route('suppliers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                            + TAMBAH SUPPLIER
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Perusahaan / Supplier</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak (CP)</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Telepon</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($suppliers as $item)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 font-black text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-500">{{ $item->contact_person ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $item->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-500">{{ Str::limit($item->address, 50) ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('suppliers.edit', $item) }}" class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-600 hover:text-white rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('suppliers.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data supplier ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada data supplier --</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
