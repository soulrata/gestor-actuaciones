<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.permissions.index')">
                Permisos
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Editar
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <h1 class="text-2xl font-semibold mb-6">Editar Permiso</h1>
    
    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <flux:input name="name" label="Nombre del Permiso" value="{{ old('name', $permission->name) }}" placeholder="Escriba el nombre del permiso" />
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Actualizar Permiso</flux:button>
        </div>
    </form>
    </div>
</x-layouts.app>