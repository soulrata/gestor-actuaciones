<x-layouts.app>
<div class="min-h-screen">
    <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item>Diseño de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.estados.index') }}">Gestor de Estados</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Crear Estado</flux:breadcrumbs.item>
        </flux:breadcrumbs>

    <div class="max-w-3xl mx-auto p-6">

        <!-- Header -->
        <div class="mb-6">
            <flux:heading size="xl" class="text-gray-900 dark:text-white">
                Crear Nuevo Estado
            </flux:heading>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Define un nuevo estado para tus secuencias de trabajo
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
            <form action="{{ route('ecosystem.estados.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <flux:label for="nombre">Nombre del Estado *</flux:label>
                        <flux:input 
                            id="nombre"
                            name="nombre" 
                            type="text"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Revisión pendiente, Aprobado, etc."
                            required
                            class="mt-1" />
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Nombre único para identificar este estado en tu ecosistema
                        </p>
                    </div>

                    <!-- Tipo -->
                    <div>
                        <flux:label for="tipo">Tipo de Estado *</flux:label>
                        <select 
                            id="tipo"
                            name="tipo" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                            <option value="">Selecciona un tipo...</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
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

                    <!-- Información adicional -->
                    <div class="bg-blue-50 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    Sobre los Estados
                                </h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <p>Los estados definen las etapas por las que puede pasar un elemento en tus secuencias de trabajo. Cada estado tiene un tipo que indica su posición en el flujo del proceso.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button 
                        href="{{ route('ecosystem.estados.index') }}" 
                        variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button 
                        type="submit" 
                        variant="primary"
                        icon="plus">
                        Crear Estado
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>