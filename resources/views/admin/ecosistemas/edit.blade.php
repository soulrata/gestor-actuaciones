<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ecosistema.index')">Ecosistemas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <form action="{{ route('admin.ecosistema.update', $ecosistema) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid gap-4">
            <div>
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $ecosistema->nombre) }}" class="input" required />
                @error('nombre')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Descripción</label>
                <textarea name="descripcion" class="input h-24">{{ old('descripcion', $ecosistema->descripcion) }}</textarea>
                @error('descripcion')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>

            <div>
                <button class="btn btn-blue">Actualizar Ecosistema</button>
            </div>
        </div>
    </form>
</x-layouts.app>
