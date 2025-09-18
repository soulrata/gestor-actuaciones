<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ver</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <flux:heading size="lg">{{ $user->name }}</flux:heading>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Información Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">ID:</span>
                        <span class="ml-2">{{ $user->id }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Nombre:</span>
                        <span class="ml-2">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Email:</span>
                        <span class="ml-2">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Creado:</span>
                        <span class="ml-2">{{ $user->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Roles y Permisos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Roles:</span>
                        <span class="ml-2">{{ $user->roles->pluck('name')->join(', ') ?: 'Sin roles asignados' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600 dark:text-gray-400">Ecosistema:</span>
                        <span class="ml-2">{{ $user->ecosistema?->nombre ?? 'Sin ecosistema asignado' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex gap-2 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
            @can('update', $user)
                <flux:button :href="route('admin.users.edit', $user)" variant="primary" size="sm">
                    Editar
                </flux:button>
            @endcan
            <flux:button :href="route('admin.users.index')" variant="outline" size="sm">
                Volver
            </flux:button>
        </div>
    </div>
</x-layouts.app>

