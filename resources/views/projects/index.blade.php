<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight italic uppercase tracking-widest">
                {{ __('Daftar Proyek Konstruksi') }}
            </h2>
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 px-6 rounded-full text-sm shadow-lg transform hover:scale-105 transition duration-200">
                🚀 TAMBAH PROYEK
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-8 border-emerald-500 text-emerald-800 px-6 py-4 rounded-xl shadow-md font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($projects as $project)
                <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100 hover:border-indigo-300 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 group-hover:text-indigo-600 mb-1">{{ $project->nama_proyek }}</h3>
                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest">Manajer: {{ $project->manager->name ?? 'N/A' }}</p>
                            </div>
                            <!-- Status Badge -->
                            @if($project->status_proyek == 'selesai')
                            <span class="px-2 py-1 text-[10px] font-black uppercase tracking-tighter bg-emerald-600 text-white rounded-md shadow-sm">Selesai</span>
                            @else
                            <span class="px-2 py-1 text-[10px] font-black uppercase tracking-tighter bg-amber-500 text-white rounded-md shadow-sm">Berjalan</span>
                            @endif
                        </div>

                        <div class="text-gray-600 space-y-2 mb-8 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $project->lokasi }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $project->tanggal_mulai }} <span class="mx-2 text-gray-300">|</span> {{ $project->tanggal_selesai }}
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-black text-gray-500 uppercase">Progress Lapangan</span>
                                <span class="text-xs font-black text-indigo-600">{{ $project->progres }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 shadow-inner overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700 {{ $project->progres == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}" style="width: {{ $project->progres }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 font-black rounded-xl text-xs hover:bg-indigo-100 transition">
                                VIEW DETAILS
                            </a>
                            
                            <div class="flex items-center space-x-4">
                                @if(Auth::user()->role == 'admin' || (Auth::user()->role == 'manajer' && $project->manager_id == auth()->id()))
                                <a href="{{ route('projects.edit', $project) }}" class="text-[10px] font-black text-gray-400 hover:text-amber-600 uppercase transition tracking-wider">Edit</a>
                                @endif

                                @if(Auth::user()->role == 'admin')
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-black text-gray-400 hover:text-red-600 uppercase transition tracking-wider">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-indigo-50 p-12 rounded-3xl text-indigo-900 text-center font-black italic tracking-widest shadow-inner">
                    --- BELUM ADA PROYEK YANG TERDAFTAR ---
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
