<x-layouts.app>
@php
    use Illuminate\Support\Str;
@endphp
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ecosistemas</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('admin.ecosistema.create') }}" class="btn btn-blue text-xs">Nuevo Ecosistema</a>
    </div>

    <div class="relative overflow-x-auto mt-4 bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-700 rounded-lg p-2">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ecosistemas as $e)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $e->id }}</td>
                        <td class="px-6 py-4">{{ $e->nombre }}</td>
                        <td class="px-6 py-4">{{ Str::limit($e->descripcion, 80) }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.ecosistema.show', $e) }}" class="btn btn-gray text-xs dark:bg-zinc-700 dark:text-white">Ver</a>
                            <a href="{{ route('admin.ecosistema.edit', $e) }}" class="btn btn-blue text-xs dark:bg-blue-600 dark:text-white">Editar</a>
                            <form action="{{ route('admin.ecosistema.destroy', $e) }}" method="POST" onsubmit="return confirm('¿Confirma eliminar este ecosistema?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red text-xs dark:bg-red-600 dark:text-white">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $ecosistemas->links() }}</div>
</x-layouts.app>
