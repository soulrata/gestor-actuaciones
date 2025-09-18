<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ecosistema.index')">Ecosistemas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <flux:heading size="lg" class="mb-6">Crear Nuevo Ecosistema</flux:heading>
        
        <form action="{{ route('admin.ecosistema.store') }}" method="POST" class="space-y-6">
            @csrf

            <flux:field>
                <flux:label>Nombre</flux:label>
                <flux:input 
                    name="nombre" 
                    value="{{ old('nombre') }}" 
                    required 
                />
                <flux:error name="nombre" />
            </flux:field>

            <flux:field>
                <flux:label>Descripción</flux:label>
                <flux:textarea 
                    name="descripcion" 
                    rows="4"
                >{{ old('descripcion') }}</flux:textarea>
                <flux:error name="descripcion" />
            </flux:field>

            <div class="flex gap-2 justify-end border-gray-200 dark:border-gray-700">
                <flux:button :href="route('admin.ecosistema.index')" variant="outline" size="sm">
                    Cancelar
                </flux:button>
                <flux:button type="submit" variant="primary" size="sm">
                    Crear Ecosistema
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
