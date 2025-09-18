<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <div class="p-6">
            <div class="mb-8 flex justify-between items-center">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item :href="route('dashboard')">
                        Gestor de mi Equipo
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item :href="route('ecosystem.users.index')">
                        Usuarios del Ecosistema
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>
                        Ver: {{ $user->name }}
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>

                <div class="flex flex-wrap gap-2">
                    <flux:button :href="route('ecosystem.users.edit', $user)" variant="primary" size="sm">
                        Editar Usuario
                    </flux:button>
                    <flux:button :href="route('ecosystem.users.index')" variant="ghost" size="sm">
                        Volver a Lista
                    </flux:button>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Información del Usuario -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <flux:heading size="lg">Información del Usuario</flux:heading>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                                <div class="mt-1">
                                    <flux:badge variant="{{ $user->email_verified_at ? 'soft' : 'outline' }}">
                                        {{ $user->email_verified_at ? 'Email Verificado' : 'Email Pendiente' }}
                                    </flux:badge>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ecosistema</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-white">
                                    {{ $user->ecosistema->nombre ?? 'Sin asignar' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Registro</label>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Última Actualización</label>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles Asignados -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <flux:heading size="lg">Roles Asignados</flux:heading>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Lista de roles que tiene este usuario</p>
                    </div>
                    
                    <div class="p-6">
                        @if($user->roles->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($user->roles as $role)
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <flux:badge variant="outline" class="mr-2">✓</flux:badge>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <p class="text-lg font-medium">Sin roles asignados</p>
                                    <p class="text-sm mt-1">Este usuario no tiene roles configurados</p>
                                </div>
                                <div class="mt-4">
                                    <flux:button :href="route('ecosystem.users.edit', $user)" variant="primary" size="sm">
                                        Asignar Roles
                                    </flux:button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Permisos Efectivos -->
                @if($user->roles->count() > 0)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                            <flux:heading size="lg">Permisos Efectivos</flux:heading>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Permisos que tiene a través de sus roles</p>
                        </div>
                        
                        <div class="p-6">
                            @php
                                $permissions = $user->getAllPermissions();
                            @endphp
                            
                            @if($permissions->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded">
                                            <span class="text-xs text-blue-700 dark:text-blue-300">{{ $permission->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Sin permisos efectivos</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Acciones de Gestión -->
                @if(!$user->hasRole('SuperAdmin'))
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                            <flux:heading size="lg">Gestión del Usuario</flux:heading>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Acciones disponibles para este usuario</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex flex-wrap gap-4">
                                <flux:button :href="route('ecosystem.users.edit', $user)" variant="primary">
                                    Editar Usuario
                                </flux:button>
                                
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('ecosystem.users.destroy', $user) }}" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger">
                                            Eliminar Usuario
                                        </flux:button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    <strong>Nota:</strong> 
                                    @if($user->id === auth()->id())
                                        No puedes eliminarte a ti mismo.
                                    @elseif($user->hasRole('SuperAdmin'))
                                        Los usuarios SuperAdmin no pueden ser eliminados.
                                    @else
                                        Ten cuidado al eliminar usuarios, esta acción no se puede deshacer.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>