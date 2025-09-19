<x-layouts.app>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-3xl mx-auto p-6">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.secuencias.index') }}">Diseñador de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Secuencia</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Header -->
        <div class="mb-6">
            <flux:heading size="xl" class="text-gray-900 dark:text-white">
                Editar Secuencia: {{ $secuencia->nombre }}
            </flux:heading>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Modifica los detalles de esta secuencia
            </p>
        </div>

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('ecosystem.secuencias.update', $secuencia) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <flux:label for="nombre">Nombre de la Secuencia *</flux:label>
                        <flux:input 
                            id="nombre"
                            name="nombre" 
                            type="text"
                            value="{{ old('nombre', $secuencia->nombre) }}"
                            placeholder="Ej: Proceso de aprobación de documentos"
                            required
                            class="mt-1" />
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Nombre único para identificar esta secuencia en tu ecosistema
                        </p>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <flux:label for="descripcion">Descripción</flux:label>
                        <flux:textarea 
                            id="descripcion"
                            name="descripcion" 
                            value="{{ old('descripcion', $secuencia->descripcion) }}"
                            placeholder="Describe el propósito y alcance de esta secuencia..."
                            rows="4"
                            class="mt-1" />
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Descripción opcional para explicar el uso y propósito de esta secuencia
                        </p>
                    </div>

                    <!-- Estado Activa -->
                    <div>
                        <div class="flex items-center space-x-3">
                            <input 
                                type="checkbox" 
                                id="activa" 
                                name="activa" 
                                value="1"
                                {{ old('activa', $secuencia->activa) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <flux:label for="activa" class="cursor-pointer">
                                Secuencia activa
                            </flux:label>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Las secuencias activas pueden ser utilizadas para crear nuevas actuaciones
                        </p>
                    </div>

                    <!-- Estado actual -->
                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                            Información Actual
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Creado:</span>
                                <span class="text-gray-900 dark:text-white">{{ $secuencia->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($secuencia->updated_at != $secuencia->created_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Última modificación:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $secuencia->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Estado actual:</span>
                                <flux:badge 
                                    :color="$secuencia->activa ? 'green' : 'gray'"
                                    size="sm">
                                    {{ $secuencia->activa ? 'Activa' : 'Inactiva' }}
                                </flux:badge>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button 
                        href="{{ route('ecosystem.secuencias.index') }}" 
                        variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button 
                        href="{{ route('ecosystem.secuencias.show', $secuencia) }}" 
                        variant="ghost"
                        icon="eye">
                        Ver Secuencia
                    </flux:button>
                    <flux:button 
                        type="submit" 
                        variant="primary"
                        icon="check">
                        Actualizar Secuencia
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>