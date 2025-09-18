<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Rol: {{ $role->name }}</flux:heading>
            <flux:spacer />
            <div class="flex flex-wrap gap-2">
                <flux:button href="{{ route('ecosystem.roles.edit', $role) }}" icon="pencil" variant="primary">
                    Editar Rol
                </flux:button>
                <flux:button href="{{ route('ecosystem.roles.index') }}" variant="ghost">
                    Volver a Lista
                </flux:button>
            </div>
        </flux:header>

        <div class="p-6 space-y-6">
            <!-- Información del Rol -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Información del Rol</flux:heading>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Rol</label>
                            <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $role->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usuarios Asignados</label>
                            <div class="mt-1">
                                <flux:badge variant="soft" size="lg">{{ $role->users->count() }} usuarios</flux:badge>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permisos Asignados -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Permisos Asignados</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Lista de todos los permisos que tiene este rol</p>
                </div>
                
                <div class="p-6">
                    @if($role->permissions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($role->permissions as $permission)
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <flux:badge variant="outline" class="mr-2">✓</flux:badge>
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $permission->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <p class="text-lg font-medium">Sin permisos asignados</p>
                                <p class="text-sm mt-1">Este rol no tiene permisos configurados</p>
                            </div>
                            <div class="mt-4">
                                <flux:button href="{{ route('ecosystem.roles.edit', $role) }}" variant="primary" size="sm">
                                    Asignar Permisos
                                </flux:button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Usuarios con este Rol -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Usuarios con este Rol</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Lista de usuarios que tienen asignado este rol</p>
                </div>
                
                <div class="p-6">
                    @if($role->users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Usuario</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                {{ $user->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <flux:badge variant="{{ $user->email_verified_at ? 'soft' : 'outline' }}">
                                                    {{ $user->email_verified_at ? 'Verificado' : 'Pendiente' }}
                                                </flux:badge>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <p class="text-lg font-medium">Sin usuarios asignados</p>
                                <p class="text-sm mt-1">Ningún usuario tiene este rol asignado actualmente</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones de Gestión -->
            @if($role->users->count() == 0)
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <flux:heading size="lg">Gestión del Rol</flux:heading>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Acciones disponibles para este rol</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-wrap gap-4">
                            <flux:button href="{{ route('ecosystem.roles.edit', $role) }}" icon="pencil" variant="primary">
                                Editar Rol
                            </flux:button>
                            
                            <form method="POST" action="{{ route('ecosystem.roles.destroy', $role) }}" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este rol? Esta acción no se puede deshacer.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <flux:button type="submit" variant="danger" icon="trash">
                                    Eliminar Rol
                                </flux:button>
                            </form>
                        </div>
                        
                        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <strong>Nota:</strong> Solo puedes eliminar roles que no tengan usuarios asignados.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </flux:main>
</x-layouts.app.sidebar>