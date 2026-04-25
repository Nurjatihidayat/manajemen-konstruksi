<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('users.update', $user) }}" method="POST" class="max-w-xl">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password (Kosongkan jika tidak ingin diubah)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" onchange="toggleProjectSelect(this.value)">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manajer" {{ old('role', $user->role) == 'manajer' ? 'selected' : '' }}>Manajer Proyek</option>
                                <option value="gudang" {{ old('role', $user->role) == 'gudang' ? 'selected' : '' }}>Gudang</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Project Assignment (Only for Gudang) -->
                        <div id="project_assignment_div" class="mb-4 {{ old('role', $user->role) == 'gudang' ? '' : 'hidden' }}">
                            <x-input-label for="assigned_project_id" :value="__('Tugaskan ke Proyek')" />
                            <select id="assigned_project_id" name="assigned_project_id" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Proyek --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('assigned_project_id', $user->assigned_project_id) == $project->id ? 'selected' : '' }}>{{ $project->nama_proyek }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_project_id')" class="mt-2" />
                        </div>

                        <script>
                            function toggleProjectSelect(role) {
                                const div = document.getElementById('project_assignment_div');
                                if (role === 'gudang') {
                                    div.classList.remove('hidden');
                                } else {
                                    div.classList.add('hidden');
                                }
                            }
                        </script>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Update User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
