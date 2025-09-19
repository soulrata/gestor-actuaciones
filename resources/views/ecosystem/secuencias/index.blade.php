<x-layouts.app>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto p-6">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Diseñador de Secuencias</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Header con botón crear -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <flux:heading size="xl" class="text-gray-900 dark:text-white">
                    Diseñador de Secuencias
                </flux:heading>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Crea y gestiona plantillas de flujos de trabajo para tu ecosistema
                </p>
            </div>
            <flux:button 
                href="{{ route('ecosystem.secuencias.create') }}" 
                variant="primary"
                icon="plus">
                Crear Secuencia
            </flux:button>
        </div>

        <!-- Mensajes de estado -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de secuencias -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            @if($secuencias->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Descripción
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Creado
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($secuencias as $secuencia)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $secuencia->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                            {{ $secuencia->descripcion ?? 'Sin descripción' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <flux:badge 
                                            :color="$secuencia->activa ? 'green' : 'gray'"
                                            size="sm">
                                            {{ $secuencia->activa ? 'Activa' : 'Inactiva' }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $secuencia->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <flux:button 
                                            href="{{ route('ecosystem.secuencias.show', $secuencia) }}" 
                                            variant="ghost" 
                                            size="sm"
                                            icon="eye">
                                            Ver
                                        </flux:button>
                                        <flux:button 
                                            href="{{ route('ecosystem.secuencias.edit', $secuencia) }}" 
                                            variant="ghost" 
                                            size="sm"
                                            icon="pencil">
                                            Editar
                                        </flux:button>
                                        <form action="{{ route('ecosystem.secuencias.destroy', $secuencia) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta secuencia?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button 
                                                type="submit" 
                                                variant="ghost" 
                                                size="sm"
                                                icon="trash"
                                                class="text-red-600 hover:text-red-800">
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
                @if($secuencias->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $secuencias->links() }}
                    </div>
                @endif
            @else
                <div class="p-6 text-center">
                    <div class="text-gray-500 dark:text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-2">
                        Sin secuencias
                    </flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        No tienes secuencias creadas aún. Crea tu primera secuencia para comenzar a diseñar flujos de trabajo.
                    </p>
                    <flux:button 
                        href="{{ route('ecosystem.secuencias.create') }}" 
                        variant="primary"
                        icon="plus">
                        Crear Primera Secuencia
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.app>