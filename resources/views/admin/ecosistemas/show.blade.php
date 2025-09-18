<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item>Gestor SuperAdmin</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ecosistema.index')">Ecosistemas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ver</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <flux:heading size="lg">{{ $ecosistema->nombre }}</flux:heading>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Descripción</h3>
                <flux:text>{{ $ecosistema->descripcion ?: 'Sin descripción' }}</flux:text>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Información</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">ID:</span>
                        <span class="ml-2">{{ $ecosistema->id }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Creado:</span>
                        <span class="ml-2">{{ $ecosistema->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Actualizado:</span>
                        <span class="ml-2">{{ $ecosistema->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex gap-2 justify-end border-gray-200 dark:border-gray-700">
            <flux:button :href="route('admin.ecosistema.edit', $ecosistema)" variant="primary" size="sm">
                Editar
            </flux:button>
            <flux:button :href="route('admin.ecosistema.index')" variant="outline" size="sm">
                Volver
            </flux:button>
        </div>
    </div>
</x-layouts.app>
