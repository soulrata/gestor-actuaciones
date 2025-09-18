<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Usuarios
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @can('create', App\Models\User::class)
            <flux:button :href="route('admin.users.create')" variant="primary" size="sm">
                Nuevo
            </flux:button>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Rol</th>
                    <th scope="col" class="px-6 py-3">Ecosistema</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->id }}</th>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->ecosistema?->nombre ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:button :href="route('admin.users.show', $user)" variant="outline" size="sm">
                                    Ver
                                </flux:button>
                                @can('update', $user)
                                    <flux:button :href="route('admin.users.edit', $user)" variant="primary" size="sm">
                                        Editar
                                    </flux:button>
                                @endcan
                                @can('delete', $user)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                          onsubmit="return confirm('¿Confirma eliminar este usuario?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger" size="sm">
                                            Eliminar
                                        </flux:button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</x-layouts.app>
