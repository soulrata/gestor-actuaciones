<x-layouts.app>
    <div class="min-h-screen">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item>Diseño de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Gestor de Estados</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="max-w-7xl mx-auto p-6">
            <!-- Header con botón crear -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <flux:heading size="xl" class="text-gray-900 dark:text-white">
                        Gestor de Estados
                    </flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Gestiona los estados para tus secuencias de trabajo
                    </p>
                </div>
                <flux:button href="{{ route('ecosystem.estados.create') }}" variant="primary" icon="plus">
                    Crear Estado
                </flux:button>
            </div>

            <!-- Mensajes de estado -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabla de estados -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                @if ($estados->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Creado
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($estados as $estado)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $estado->nombre }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <flux:badge
                                                :color="$estado->tipo === 'Inicio' ? 'green' : ($estado->tipo === 'Fin' ? 'red' : 'yellow')"
                                                size="sm">
                                                {{ $estado->tipo }}
                                            </flux:badge>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $estado->created_at->format('d/m/Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <flux:button href="{{ route('ecosystem.estados.show', $estado) }}"
                                                variant="ghost" size="sm" icon="eye">
                                                Ver
                                            </flux:button>
                                            <flux:button href="{{ route('ecosystem.estados.edit', $estado) }}"
                                                variant="ghost" size="sm" icon="pencil">
                                                Editar
                                            </flux:button>
                                            <form action="{{ route('ecosystem.estados.destroy', $estado) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este estado?')">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" variant="ghost" size="sm"
                                                    icon="trash" class="text-red-600 hover:text-red-800">
                                                    Eliminar
                                                </flux:button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if ($estados->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $estados->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-6 text-center">
                        <div class="text-gray-500 dark:text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <flux:heading size="lg" class="text-gray-900 dark:text-white mb-2">
                            Sin estados
                        </flux:heading>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            No tienes estados creados aún. Crea tu primer estado para comenzar.
                        </p>
                        <flux:button href="{{ route('ecosystem.estados.create') }}" variant="primary" icon="plus">
                            Crear Primer Estado
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
