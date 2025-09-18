<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Roles y Permisos del Ecosistema</flux:heading>
            <flux:spacer />
            <flux:button href="{{ route('ecosystem.roles.create') }}" icon="plus" variant="primary">
                Nuevo Rol
            </flux:button>
        </flux:header>

        <div class="p-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Lista de Roles</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Gestiona los roles y permisos de tu ecosistema</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre del Rol</th>
                                <th scope="col" class="px-6 py-3">Permisos</th>
                                <th scope="col" class="px-6 py-3">Usuarios Asignados</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($role->permissions->take(3) as $permission)
                                                <flux:badge variant="outline" size="sm">{{ $permission->name }}</flux:badge>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <flux:badge variant="soft" size="sm">+{{ $role->permissions->count() - 3 }} más</flux:badge>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <flux:badge variant="soft">{{ $role->users_count ?? 0 }} usuarios</flux:badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <flux:button href="{{ route('ecosystem.roles.show', $role) }}" size="sm" variant="ghost" icon="eye">
                                                Ver
                                            </flux:button>
                                            <flux:button href="{{ route('ecosystem.roles.edit', $role) }}" size="sm" variant="ghost" icon="pencil">
                                                Editar
                                            </flux:button>
                                            @if(($role->users_count ?? 0) == 0)
                                                <form method="POST" action="{{ route('ecosystem.roles.destroy', $role) }}" 
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este rol?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <flux:button type="submit" size="sm" variant="danger" icon="trash">
                                                        Eliminar
                                                    </flux:button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No hay roles configurados en tu ecosistema
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($roles->hasPages())
                    <div class="mt-4 px-6 pb-6">
                        {{ $roles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>