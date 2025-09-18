<x-layouts.app>

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item>Gestor SuperAdmin</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ecosistemas</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:button :href="route('admin.ecosistema.create')" variant="primary" size="sm">
            Nuevo Ecosistema
        </flux:button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ecosistemas as $e)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $e->id }}</td>
                        <td class="px-6 py-4">{{ $e->nombre }}</td>
                        <td class="px-6 py-4">{{ Str::limit($e->descripcion, 80) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:button :href="route('admin.ecosistema.show', $e)" variant="outline" size="sm">
                                    Ver
                                </flux:button>
                                <flux:button :href="route('admin.ecosistema.edit', $e)" variant="primary" size="sm">
                                    Editar
                                </flux:button>
                                <form action="{{ route('admin.ecosistema.destroy', $e) }}" method="POST" 
                                      onsubmit="return confirm('¿Confirma eliminar este ecosistema?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="danger" size="sm">
                                        Eliminar
                                    </flux:button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $ecosistemas->links() }}</div>
</x-layouts.app>
