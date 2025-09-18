<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white dark:bg-zinc-800 p-6 rounded shadow-sm border border-gray-100 dark:border-zinc-700">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.users._form')

            <div class="mt-4 flex gap-2 justify-end">
                <flux:button type="submit" variant="primary" size="sm">Actualizar</flux:button>
                <flux:button :href="route('admin.users.index')" size="sm">Cancelar</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>

