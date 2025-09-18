<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Crear Nuevo Rol</flux:heading>
        </flux:header>

        <div class="p-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Datos del Rol</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Define el nombre y permisos del nuevo rol</p>
                </div>

                <form method="POST" action="{{ route('ecosystem.roles.store') }}" class="p-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <flux:label>Nombre del rol</flux:label>
                            <flux:input name="name" value="{{ old('name') }}" class="mt-1" />
                            @error('name')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Permisos</flux:label>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Selecciona los permisos que tendrá este rol</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox"
                                            name="permissions[]" 
                                            value="{{ $permission->id }}" 
                                            @if(in_array($permission->id, old('permissions', []))) checked @endif
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <flux:button type="submit" variant="primary">Crear Rol</flux:button>
                            <flux:button href="{{ route('ecosystem.roles.index') }}" variant="ghost">Cancelar</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>