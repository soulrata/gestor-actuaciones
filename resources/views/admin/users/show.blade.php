<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ver</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white dark:bg-zinc-800 p-6 rounded shadow-sm border border-gray-100 dark:border-zinc-700">
        <dl class="grid grid-cols-1 gap-4">
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Nombre</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Email</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Roles</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $user->roles->pluck('name')->join(', ') }}</dd>
            </div>
        </dl>

        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</x-layouts.app>

