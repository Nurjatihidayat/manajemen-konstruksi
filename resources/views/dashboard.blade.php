<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-indigo-900 leading-tight tracking-tighter uppercase">
                {{ __('Dashboard Overview') }}
            </h2>
            <div class="text-xs font-bold text-gray-400 tracking-widest uppercase">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-violet-700 rounded-3xl p-8 shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-indigo-100 font-medium opacity-90">Anda login sebagai <span class="bg-white/20 px-2 py-0.5 rounded-lg font-bold uppercase text-[10px]">{{ Auth::user()->role }}</span></p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-y-4">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Projects -->
                <div class="bg-white p-6 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-50 group hover:border-indigo-500 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 rounded-2xl group-hover:bg-blue-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek</span>
                    </div>
                    <p class="text-4xl font-black text-gray-900">{{ $totalProjects }}</p>
                    <p class="text-xs font-bold text-gray-400 mt-1 italic">Aktif & Berjalan</p>
                </div>

                <!-- Total Materials -->
                <div class="bg-white p-6 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-50 group hover:border-indigo-500 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 rounded-2xl group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Material</span>
                    </div>
                    <p class="text-4xl font-black text-gray-900">{{ $totalMaterials }}</p>
                    <p class="text-xs font-bold text-gray-400 mt-1 italic">Master Global</p>
                </div>

                <!-- Critical Stock -->
                <div class="bg-white p-6 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-50 group hover:border-red-500 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 rounded-2xl group-hover:bg-red-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-red-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stok Kritis</span>
                    </div>
                    <p class="text-4xl font-black {{ $criticalMaterials > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $criticalMaterials }}</p>
                    <p class="text-xs font-bold text-gray-400 mt-1 italic">Perlu Reorder</p>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white p-6 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-50 group hover:border-amber-500 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 rounded-2xl group-hover:bg-amber-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-amber-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pending Req</span>
                    </div>
                    <p class="text-4xl font-black {{ $pendingRequests > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ $pendingRequests }}</p>
                    <p class="text-xs font-bold text-gray-400 mt-1 italic">Butuh Tindakan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Project Progress List -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl shadow-gray-200/50 rounded-3xl border border-gray-50">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter italic">🏁 Status & Progres Proyek</h3>
                            <a href="{{ route('projects.index') }}" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 tracking-widest uppercase">Lihat Semua →</a>
                        </div>
                        <div class="space-y-10">
                            @forelse($recentProjects as $project)
                            <div class="group">
                                <div class="flex justify-between items-end mb-3">
                                    <div class="flex flex-col">
                                        <div class="flex items-center space-x-3 mb-1">
                                            <span class="text-lg font-black text-gray-800 group-hover:text-indigo-600 transition">{{ $project->nama_proyek }}</span>
                                            @if($project->status_proyek == 'selesai')
                                            <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 rounded-lg">SELESAI</span>
                                            @else
                                            <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest bg-blue-100 text-blue-700 rounded-lg">BERJALAN</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Manajer: {{ $project->manager->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-black text-gray-900">{{ $project->progres }}<span class="text-xs text-gray-400">%</span></span>
                                    </div>
                                </div>
                                
                                <div class="overflow-hidden h-2.5 mb-2 text-xs flex rounded-full bg-slate-100 shadow-inner">
                                    <div style="width:{{ $project->progres }}%" 
                                         class="flex flex-col text-center whitespace-nowrap text-white justify-center shadow-none transition-all duration-1000 ease-out {{ $project->progres == 100 ? 'bg-emerald-500' : 'bg-indigo-600 shadow-[0_0_15px_rgba(79,70,229,0.4)]' }}">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="py-12 text-center">
                                <p class="text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada proyek terdaftar --</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Activities Feed -->
                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 rounded-3xl border border-gray-50 flex flex-col">
                    <div class="p-8 flex-1">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter italic mb-8 pb-4 border-b border-gray-50">⚡ Aktivitas Terkini</h3>
                        <div class="flow-root h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                            <ul role="list" class="-mb-8">
                                @forelse($recentActivities as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-9 w-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center ring-4 ring-white">
                                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-xs text-gray-800 font-black uppercase tracking-tighter">{{ $activity->user->name ?? 'User' }} <span class="text-[8px] text-gray-400 lowercase italic">({{ $activity->user->role ?? 'N/A' }})</span></p>
                                                    <p class="text-xs text-gray-600 mt-1 font-medium leading-relaxed italic">"{{ $activity->description ?? $activity->type ?? '' }}"</p>
                                                    <p class="text-[9px] text-gray-300 mt-1 uppercase font-black">{{ $activity->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <div class="py-12 text-center">
                                    <p class="text-gray-400 font-bold italic uppercase tracking-widest">-- Belum ada aktivitas --</p>
                                </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</x-app-layout>

