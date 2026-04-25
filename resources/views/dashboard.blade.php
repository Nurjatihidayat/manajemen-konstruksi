<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Konstruksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-600 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold opacity-80 uppercase tracking-wider">Total Proyek</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ $totalProjects }}</p>
                </div>
                <div class="bg-indigo-600 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold opacity-80 uppercase tracking-wider">Total Material</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ $totalMaterials }}</p>
                </div>
                <div class="bg-red-500 p-6 rounded-2xl shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <h3 class="text-lg font-semibold opacity-80 uppercase tracking-wider">Material Kurang</h3>
                    <p class="text-5xl font-extrabold mt-2">{{ $totalShortages }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Project Progress List -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Status Proyek & Progres</h3>
                            <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua →</a>
                        </div>
                        <div class="space-y-8">
                            @forelse($recentProjects as $project)
                            <div class="group">
                                <div class="flex justify-between items-center mb-2">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $project->nama_proyek }}</span>
                                        <!-- Status Badge -->
                                        @if($project->status_proyek == 'selesai')
                                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">Selesai</span>
                                        @else
                                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-700 rounded-full border border-amber-200">Berjalan</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-500 italic">Manajer: {{ $project->manager->name ?? 'N/A' }}</span>
                                </div>
                                
                                <!-- Alert for completed project -->
                                @if($project->progres == 100)
                                <div class="mb-3 px-4 py-2 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-semibold rounded-r-lg">
                                    Proyek selesai secara keseluruhan.
                                </div>
                                @endif

                                <!-- Progress Bar Wrapper -->
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $project->progres == 100 ? 'text-emerald-600 bg-emerald-200' : 'text-indigo-600 bg-indigo-200' }}">
                                                {{ $project->progres }}% Selesai
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-3 mb-4 text-xs flex rounded-full bg-gray-100 shadow-inner">
                                        <div style="width:{{ $project->progres }}%" 
                                             class="flex flex-col text-center whitespace-nowrap text-white justify-center shadow-none transition-all duration-1000 {{ $project->progres == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-4 text-center">Belum ada proyek yang terdaftar.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-4">Aktivitas Terkini</h3>
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @forelse($recentActivities as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-800 font-bold">{{ $activity->user->name ?? 'User' }} <span class="font-normal text-gray-500">({{ $activity->user->role ?? 'N/A' }})</span></p>
                                                    <p class="text-sm text-gray-600 mt-1 italic">"{{ $activity->description ?? $activity->type ?? '' }}"</p>
                                                </div>
                                                <div class="text-right text-xs whitespace-nowrap text-gray-400">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <p class="text-gray-500 italic text-center py-4">Belum ada aktivitas.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
