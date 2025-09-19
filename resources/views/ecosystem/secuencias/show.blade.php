<x-layouts.app>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto p-6">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.secuencias.index') }}">Diseñador de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $secuencia->nombre }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Header con acciones -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <flux:heading size="xl" class="text-gray-900 dark:text-white">
                    {{ $secuencia->nombre }}
                </flux:heading>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Detalles de la secuencia
                </p>
            </div>
            <div class="flex space-x-3">
                <flux:button 
                    href="{{ route('ecosystem.secuencias.edit', $secuencia) }}" 
                    variant="primary"
                    icon="pencil">
                    Editar
                </flux:button>
                <form action="{{ route('ecosystem.secuencias.destroy', $secuencia) }}" 
                      method="POST" 
                      class="inline-block"
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta secuencia? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <flux:button 
                        type="submit" 
                        variant="danger"
                        icon="trash">
                        Eliminar
                    </flux:button>
                </form>
            </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información principal -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Información de la Secuencia
                    </flux:heading>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $secuencia->nombre }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $secuencia->descripcion ?? 'Sin descripción' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                            <dd class="mt-1">
                                <flux:badge 
                                    :color="$secuencia->activa ? 'green' : 'gray'"
                                    size="lg">
                                    {{ $secuencia->activa ? 'Activa' : 'Inactiva' }}
                                </flux:badge>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ecosistema</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $secuencia->ecosistema->nombre ?? 'N/A' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Uso</dt>
                            <dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                @if($secuencia->activa)
                                    Esta secuencia está activa y puede ser utilizada para crear nuevas actuaciones.
                                @else
                                    Esta secuencia está inactiva y no puede ser utilizada para crear nuevas actuaciones.
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Pasos de la secuencia (futuro) -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Pasos de la Secuencia
                    </flux:heading>
                    
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p>Aquí aparecerán los pasos configurados para esta secuencia.</p>
                        <p class="mt-2">Próximamente podrás agregar, editar y organizar los pasos del flujo de trabajo.</p>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Metadatos -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Metadatos
                    </flux:heading>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">ID</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $secuencia->id }}</dd>
                        </div>

                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Creado</dt>
                            <dd class="text-gray-900 dark:text-white">
                                {{ $secuencia->created_at->format('d/m/Y H:i') }}
                            </dd>
                            <dd class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $secuencia->created_at->diffForHumans() }}
                            </dd>
                        </div>

                        @if($secuencia->updated_at != $secuencia->created_at)
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                                <dd class="text-gray-900 dark:text-white">
                                    {{ $secuencia->updated_at->format('d/m/Y H:i') }}
                                </dd>
                                <dd class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $secuencia->updated_at->diffForHumans() }}
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas (futuro) -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Estadísticas
                    </flux:heading>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Pasos configurados:</span>
                            <span class="text-gray-900 dark:text-white">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Actuaciones creadas:</span>
                            <span class="text-gray-900 dark:text-white">0</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Próximamente: estadísticas de uso
                        </p>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Acciones Rápidas
                    </flux:heading>
                    
                    <div class="space-y-3">
                        <flux:button 
                            href="{{ route('ecosystem.secuencias.edit', $secuencia) }}" 
                            variant="outline"
                            size="sm"
                            icon="pencil"
                            class="w-full justify-start">
                            Editar Secuencia
                        </flux:button>
                        
                        {{-- Futuro: Gestión de pasos --}}
                        <flux:button 
                            disabled
                            variant="outline"
                            size="sm"
                            icon="plus"
                            class="w-full justify-start">
                            Agregar Pasos (Próximamente)
                        </flux:button>
                        
                        <flux:button 
                            href="{{ route('ecosystem.secuencias.create') }}" 
                            variant="outline"
                            size="sm"
                            icon="plus"
                            class="w-full justify-start">
                            Crear Nueva Secuencia
                        </flux:button>
                        
                        <flux:button 
                            href="{{ route('ecosystem.secuencias.index') }}" 
                            variant="outline"
                            size="sm"
                            icon="arrow-left"
                            class="w-full justify-start">
                            Volver a Lista
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>