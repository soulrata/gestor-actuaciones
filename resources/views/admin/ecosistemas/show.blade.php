<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ecosistema.index')">Ecosistemas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Ver</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white rounded-md p-4">
        <h3 class="font-semibold text-lg">{{ $ecosistema->nombre }}</h3>
        <p class="text-sm mt-2">{{ $ecosistema->descripcion }}</p>
    </div>
</x-layouts.app>
