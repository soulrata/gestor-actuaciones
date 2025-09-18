<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Usuarios del Ecosistema</flux:heading>
            <flux:spacer />
            <flux:button href="{{ route('ecosystem.users.create') }}" icon="plus" variant="primary">
                Nuevo Usuario
            </flux:button>
        </flux:header>

        <div class="p-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Lista de Usuarios</flux:heading>
                    <flux:subheading>Gestiona los usuarios de tu ecosistema</flux:subheading>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Roles</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <flux:badge variant="outline" size="sm">{{ $role->name }}</flux:badge>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <flux:badge variant="{{ $user->email_verified_at ? 'soft' : 'outline' }}">
                                            {{ $user->email_verified_at ? 'Verificado' : 'Pendiente' }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <flux:button href="{{ route('ecosystem.users.show', $user) }}" size="sm" variant="ghost" icon="eye">
                                                Ver
                                            </flux:button>
                                            <flux:button href="{{ route('ecosystem.users.edit', $user) }}" size="sm" variant="ghost" icon="pencil">
                                                Editar
                                            </flux:button>
                                            <form method="POST" action="{{ route('ecosystem.users.destroy', $user) }}" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" size="sm" variant="danger" icon="trash">
                                                    Eliminar
                                                </flux:button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No hay usuarios en tu ecosistema
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="mt-4 px-6 pb-6">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>