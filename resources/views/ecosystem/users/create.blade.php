<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <flux:header class="bg-white dark:bg-zinc-900 shadow-sm">
            <flux:heading size="xl">Crear Nuevo Usuario</flux:heading>
        </flux:header>

        <div class="p-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Datos del Usuario</flux:heading>
                    <flux:subheading>Ingresa la información del nuevo usuario</flux:subheading>
                </div>

                <form method="POST" action="{{ route('ecosystem.users.store') }}" class="p-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <flux:label>Nombre completo</flux:label>
                            <flux:input name="name" value="{{ old('name') }}" class="mt-1" />
                            @error('name')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Email</flux:label>
                            <flux:input type="email" name="email" value="{{ old('email') }}" class="mt-1" />
                            @error('email')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Contraseña</flux:label>
                            <flux:input type="password" name="password" class="mt-1" />
                            @error('password')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Confirmar contraseña</flux:label>
                            <flux:input type="password" name="password_confirmation" class="mt-1" />
                        </div>

                        <div>
                            <flux:label>Roles</flux:label>
                            <div class="mt-2 space-y-2">
                                @foreach($roles as $role)
                                    <div class="flex items-center">
                                        <flux:checkbox name="roles[]" value="{{ $role->id }}" :checked="in_array($role->id, old('roles', []))" />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="ecosistema_id" value="{{ auth()->user()->ecosistema_id }}">

                        <div class="flex gap-4 pt-4">
                            <flux:button type="submit" variant="primary">Crear Usuario</flux:button>
                            <flux:button href="{{ route('ecosystem.users.index') }}" variant="ghost">Cancelar</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>