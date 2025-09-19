<x-layouts.app>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-3xl mx-auto p-6">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('ecosystem.secuencias.index') }}">Diseñador de Secuencias</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Crear Secuencia</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Header -->
        <div class="mb-6">
            <flux:heading size="xl" class="text-gray-900 dark:text-white">
                Crear Nueva Secuencia
            </flux:heading>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Define una nueva plantilla de flujo de trabajo para tu ecosistema
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
            <form action="{{ route('ecosystem.secuencias.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <flux:label for="nombre">Nombre de la Secuencia *</flux:label>
                        <flux:input 
                            id="nombre"
                            name="nombre" 
                            type="text"
                            value="{{ old('nombre') }}"
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
                            value="{{ old('descripcion') }}"
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
                                {{ old('activa', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <flux:label for="activa" class="cursor-pointer">
                                Secuencia activa
                            </flux:label>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Las secuencias activas pueden ser utilizadas para crear nuevas actuaciones
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
                                    Sobre las Secuencias
                                </h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <p>Las secuencias son plantillas que definen los pasos y flujos de trabajo de tu ecosistema. Una vez creada la secuencia, podrás agregar pasos individuales con roles, estados y configuraciones específicas.</p>
                                </div>
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
                        type="submit" 
                        variant="primary"
                        icon="plus">
                        Crear Secuencia
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>