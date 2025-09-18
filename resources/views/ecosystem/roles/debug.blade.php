<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Debug - Verificación de Roles y Permisos</flux:heading>
        </flux:header>

        <div class="p-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Estado Actual de Roles y Permisos</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Información detallada para debugging</p>
                </div>

                <div class="p-6 space-y-6">
                    @foreach(\Spatie\Permission\Models\Role::where('name', '!=', 'SuperAdmin')->with('permissions', 'users')->get() as $role)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <flux:heading size="md">{{ $role->name }}</flux:heading>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        ID: {{ $role->id }} | Usuarios: {{ $role->users->count() }}
                                    </p>
                                </div>
                                <flux:badge variant="soft">{{ $role->permissions->count() }} permisos</flux:badge>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Permisos Asignados ({{ $role->permissions->count() }})
                                    </label>
                                    @if($role->permissions->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($role->permissions as $permission)
                                                <div class="flex items-center">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                    <span class="text-sm">ID:{{ $permission->id }} - {{ $permission->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">Sin permisos asignados</p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        IDs de Permisos (para debugging)
                                    </label>
                                    <p class="text-sm font-mono bg-gray-100 dark:bg-gray-800 p-2 rounded">
                                        [{{ $role->permissions->pluck('id')->join(', ') }}]
                                    </p>
                                    
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3 mb-2">
                                        Acciones de Prueba
                                    </label>
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('ecosystem.roles.edit', $role) }}" size="sm" variant="ghost">
                                            Editar
                                        </flux:button>
                                        <flux:button href="{{ route('ecosystem.roles.show', $role) }}" size="sm" variant="ghost">
                                            Ver
                                        </flux:button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <flux:heading size="sm">Información de Debug</flux:heading>
                        <div class="mt-2 text-sm space-y-1">
                            <p><strong>Total de permisos disponibles:</strong> {{ \Spatie\Permission\Models\Permission::count() }}</p>
                            <p><strong>Permisos no-SuperAdmin:</strong> {{ \Spatie\Permission\Models\Permission::where('name', 'not like', '%SuperAdmin%')->count() }}</p>
                            <p><strong>Total de roles:</strong> {{ \Spatie\Permission\Models\Role::count() }}</p>
                            <p><strong>Roles no-SuperAdmin:</strong> {{ \Spatie\Permission\Models\Role::where('name', '!=', 'SuperAdmin')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>