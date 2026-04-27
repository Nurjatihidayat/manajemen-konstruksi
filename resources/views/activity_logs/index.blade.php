<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tighter uppercase">
            📜 Global Audit Log
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-50">
                        <h3 class="text-xl font-black text-indigo-900 uppercase tracking-tighter italic">Log Aktivitas Sistem</h3>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Menampilkan {{ $logs->count() }} aktivitas terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-sans">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">User</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Deskripsi Aktivitas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-xs">
                                @foreach($logs as $log)
                                <tr class="hover:bg-indigo-50/30 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-500 whitespace-nowrap">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                        <span class="block text-[8px] font-black uppercase text-gray-300 italic">{{ $log->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-black text-indigo-900">
                                        {{ $log->user->name ?? 'SYSTEM' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase {{ $log->user && $log->user->role == 'admin' ? 'bg-red-100 text-red-700' : ($log->user && $log->user->role == 'manajer' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700') }}">
                                            {{ $log->user->role ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 font-medium leading-relaxed italic">
                                        "{{ $log->description ?? $log->type }}"
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
