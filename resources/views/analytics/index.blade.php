<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            📊 Analitik & Akurasi
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Accuracy Card -->
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-indigo-100/50 border border-indigo-50 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Akurasi Stok</p>
                        <p class="text-4xl font-black text-indigo-600 mb-1">{{ $accuracyData->total_diff ?? 0 }} <span class="text-xs text-gray-400">Unit Selisih</span></p>
                        <p class="text-[9px] font-bold text-gray-400 italic">Akumulasi selisih dari {{ $accuracyData->total_items ?? 0 }} item opname.</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-5 transform group-hover:scale-110 transition duration-500 text-indigo-900">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </div>
                </div>

                <!-- Critical Count -->
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-red-100/50 border border-red-50 group">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Item Perlu Reorder</p>
                    <p class="text-4xl font-black text-red-600 mb-1">{{ $criticalCount }} <span class="text-xs text-gray-400">Material</span></p>
                    <p class="text-[9px] font-bold text-gray-400 italic">Segera lakukan pembelian untuk item di bawah limit.</p>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white p-8 rounded-3xl shadow-xl shadow-emerald-100/50 border border-emerald-50 group">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Efisiensi Rantai Pasok</p>
                    <p class="text-4xl font-black text-emerald-600 mb-1">98.2<span class="text-xs text-gray-400">%</span></p>
                    <p class="text-[9px] font-bold text-gray-400 italic">Tingkat ketersediaan material di gudang pusat.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Top Moving Materials -->
                <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-50">
                    <h3 class="text-lg font-black text-indigo-900 uppercase tracking-tighter mb-6 border-b border-gray-50 pb-4">🚀 Top Moving Materials</h3>
                    <div class="space-y-6">
                        @foreach($topMoving as $item)
                        <div>
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-2">
                                <span class="text-gray-700">{{ $item->material->nama_material }}</span>
                                <span class="text-indigo-600">{{ $item->total_qty }} {{ $item->material->satuan }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden shadow-inner">
                                <div class="bg-indigo-600 h-full shadow-[0_0_10px_rgba(79,70,229,0.3)] transition-all duration-1000" style="width: {{ min(100, ($item->total_qty / ($topMoving->max('total_qty') ?: 1)) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Project Progress Radar (List) -->
                <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-50">
                    <h3 class="text-lg font-black text-indigo-900 uppercase tracking-tighter mb-6 border-b border-gray-50 pb-4">🏁 Monitoring Progres Proyek</h3>
                    <div class="space-y-6">
                        @foreach($projects as $project)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $project->nama_proyek }}</span>
                                <span class="text-lg font-black text-gray-900">{{ $project->progres }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden shadow-inner">
                                <div class="h-full {{ $project->progres == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }} transition-all duration-1000" style="width: {{ $project->progres }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
