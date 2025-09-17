@php
    $selectedRoles = old('roles', (isset($user) && $user->roles) ? $user->roles->pluck('name')->toArray() : []);
@endphp

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
        <input type="text" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" class="mt-1 block w-full rounded-md border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-black dark:text-white" />
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-black dark:text-white" />
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-black dark:text-white" />
        <p class="text-xs text-gray-500 dark:text-gray-400">Dejar vacío para no cambiar la contraseña.</p>
        @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
        <div class="flex gap-2 flex-wrap mt-1">
            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                <label class="inline-flex items-center gap-2 bg-gray-50 dark:bg-zinc-700 px-2 py-1 rounded">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" @if(in_array($role->name, $selectedRoles)) checked @endif />
                    <span class="text-sm text-black dark:text-white">{{ $role->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ecosistema</label>
        <select name="ecosistema_id" class="mt-1 block w-full rounded-md border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-black dark:text-white">
            <option value="">-- Ninguno --</option>
            @foreach(\App\Models\Ecosistema::all() as $e)
                <option value="{{ $e->id }}" @if(old('ecosistema_id', $user->ecosistema_id ?? '') == $e->id) selected @endif>{{ $e->nombre }}</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 dark:text-gray-400">Los usuarios (no SuperAdmin) deben pertenecer a un ecosistema.</p>
        @error('ecosistema_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
</div>
