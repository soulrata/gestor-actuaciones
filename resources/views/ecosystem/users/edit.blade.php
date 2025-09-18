<x-layouts.app.sidebar>
    <flux:main class="min-h-screen">
        <div class="p-6">
            <div class="mb-8 flex justify-between items-center">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item :href="route('dashboard')">
                        Gestor de mi Equipo
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item :href="route('ecosystem.users.index')">
                        Usuarios del Ecosistema
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>
                        Editar: {{ $user->name }}
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg">Editar Usuario</flux:heading>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Modifica la información del usuario</p>
                </div>

                <form method="POST" action="{{ route('ecosystem.users.update', $user) }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <flux:label>Nombre completo</flux:label>
                            <flux:input name="name" value="{{ old('name', $user->name) }}" class="mt-1" />
                            @error('name')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Email</flux:label>
                            <flux:input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1" />
                            @error('email')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Nueva contraseña (opcional)</flux:label>
                            <flux:input type="password" name="password" class="mt-1" />
                            <p class="text-sm text-gray-500 mt-1">Deja en blanco si no quieres cambiar la contraseña</p>
                            @error('password')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <flux:label>Confirmar nueva contraseña</flux:label>
                            <flux:input type="password" name="password_confirmation" class="mt-1" />
                        </div>

                        <div>
                            <flux:label>Roles</flux:label>
                            <div class="mt-2 space-y-2">
                                @foreach($roles as $role)
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox"
                                            name="roles[]" 
                                            value="{{ $role->name }}" 
                                            @if(in_array($role->name, old('roles', $userRoles))) checked @endif
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <flux:button type="submit" variant="primary">Actualizar Usuario</flux:button>
                            <flux:button :href="route('ecosystem.users.show', $user)" variant="ghost">Ver Usuario</flux:button>
                            <flux:button :href="route('ecosystem.users.index')" variant="ghost">Volver a Lista</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>