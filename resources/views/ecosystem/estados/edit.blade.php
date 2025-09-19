<x-layouts.app>
    <div class="min-h-screen">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item>Diseño de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.estados.index') }}">Gestor de Estados
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Estado</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="max-w-3xl mx-auto p-6">
            <!-- Header -->
            <div class="mb-6">
                <flux:heading size="xl" class="text-gray-900 dark:text-white">
                    Editar Estado: {{ $estado->nombre }}
                </flux:heading>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Modifica los detalles de este estado
                </p>
            </div>

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('ecosystem.estados.update', $estado) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <flux:label for="nombre">Nombre del Estado *</flux:label>
                            <flux:input id="nombre" name="nombre" type="text"
                                value="{{ old('nombre', $estado->nombre) }}"
                                placeholder="Ej: Revisión pendiente, Aprobado, etc." required class="mt-1" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Nombre único para identificar este estado en tu ecosistema
                            </p>
                        </div>

                        <!-- Tipo -->
                        <div>
                            <flux:label for="tipo">Tipo de Estado *</flux:label>
                            <select id="tipo" name="tipo" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                                <option value="">Selecciona un tipo...</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ old('tipo', $estado->tipo) == $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <strong>Inicio:</strong> Estados iniciales del proceso •
                                <strong>En Proceso:</strong> Estados intermedios •
                                <strong>Fin:</strong> Estados finales
                            </p>
                        </div>

                        <!-- Estado actual -->
                        <div
                            class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                Estado Actual
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Creado:</span>
                                    <span
                                        class="text-gray-900 dark:text-white">{{ $estado->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if ($estado->updated_at != $estado->created_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Última modificación:</span>
                                        <span
                                            class="text-gray-900 dark:text-white">{{ $estado->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <flux:button href="{{ route('ecosystem.estados.index') }}" variant="ghost">
                            Cancelar
                        </flux:button>
                        <flux:button href="{{ route('ecosystem.estados.show', $estado) }}" variant="ghost"
                            icon="eye">
                            Ver Estado
                        </flux:button>
                        <flux:button type="submit" variant="primary" icon="check">
                            Actualizar Estado
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
