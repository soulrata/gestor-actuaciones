<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.user-roles.index')">
                Usuarios
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Asignar Roles
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <h1 class="text-2xl font-semibold mb-6">Asignar Roles a {{ $user->name }}</h1>
    
    <div class="card-body">
        <form action="{{ route('admin.user-roles.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-4">Roles disponibles:</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($roles as $role)
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    class="form-checkbox" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <span class="text-gray-700">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <flux:button :href="route('admin.user-roles.index')">Cancelar</flux:button>
                <flux:button type="submit" variant="primary">Actualizar Roles</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>