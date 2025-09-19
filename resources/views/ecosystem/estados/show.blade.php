<x-layouts.app>
    <div class="min-h-screen">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item>Diseño de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.estados.index') }}">Gestor de Estados
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $estado->nombre }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="max-w-4xl mx-auto p-6">
            <!-- Header con acciones -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <flux:heading size="xl" class="text-gray-900 dark:text-white">
                        {{ $estado->nombre }}
                    </flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Detalles del estado
                    </p>
                </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información principal -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                            Información del Estado
                        </flux:heading>

                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $estado->nombre }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                                <dd class="mt-1">
                                    <flux:badge
                                        :color="$estado->tipo === 'Inicio' ? 'green' : ($estado->tipo === 'Fin' ? 'red' : 'yellow')"
                                        size="lg">
                                        {{ $estado->tipo }}
                                    </flux:badge>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ecosistema</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $estado->ecosistema->nombre ?? 'N/A' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción del Tipo
                                </dt>
                                <dd class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    @if ($estado->tipo === 'Inicio')
                                        Estados iniciales que marcan el comienzo de un proceso o secuencia.
                                    @elseif($estado->tipo === 'En Proceso')
                                        Estados intermedios que representan fases activas del proceso.
                                    @elseif($estado->tipo === 'Fin')
                                        Estados finales que indican la conclusión o cierre del proceso.
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </div>

                    <!-- Información de uso (futuro) -->
                    {{-- 
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
                    <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                        Uso en Secuencias
                    </flux:heading>
                    
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p>Esta sección mostrará en qué secuencias se está utilizando este estado.</p>
                        <p class="mt-2">Próximamente...</p>
                    </div>
                </div>
                --}}
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
                                <dd class="text-gray-900 dark:text-white">{{ $estado->id }}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Creado</dt>
                                <dd class="text-gray-900 dark:text-white">
                                    {{ $estado->created_at->format('d/m/Y H:i') }}
                                </dd>
                                <dd class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $estado->created_at->diffForHumans() }}
                                </dd>
                            </div>

                            @if ($estado->updated_at != $estado->created_at)
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                                    <dd class="text-gray-900 dark:text-white">
                                        {{ $estado->updated_at->format('d/m/Y H:i') }}
                                    </dd>
                                    <dd class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $estado->updated_at->diffForHumans() }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <flux:heading size="lg" class="text-gray-900 dark:text-white mb-4">
                            Acciones Rápidas
                        </flux:heading>

                        <div class="space-y-3">
                            <flux:button href="{{ route('ecosystem.estados.edit', $estado) }}" variant="outline"
                                size="sm" icon="pencil" class="w-full justify-start">
                                Editar Estado
                            </flux:button>

                            <flux:button href="{{ route('ecosystem.estados.create') }}" variant="outline"
                                size="sm" icon="plus" class="w-full justify-start">
                                Crear Nuevo Estado
                            </flux:button>

                            <flux:button href="{{ route('ecosystem.estados.index') }}" variant="outline" size="sm"
                                icon="arrow-left" class="w-full justify-start">
                                Volver a Lista
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
