<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.roles.index')">
                Roles
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Nuevo
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <h1 class="text-2xl font-semibold mb-6">Crear Nuevo Rol</h1>
        
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <flux:input name="name" label="Nombre del Rol" placeholder="Escriba el nombre del rol" />
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-4">Permisos:</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($permissions as $permission)
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                   class="form-checkbox" {{ old('permissions') && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                            <span class="text-gray-700">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" size="sm">Crear Rol</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>