@php
    $selectedRoles = old('roles', (isset($user) && $user->roles) ? $user->roles->pluck('name')->toArray() : []);
@endphp

<div class="grid grid-cols-1 gap-4">
    <flux:field>
        <flux:label>Nombre</flux:label>
        <flux:input name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" />
        <flux:error name="name" />
    </flux:field>

    <flux:field>
        <flux:label>Email</flux:label>
        <flux:input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" />
        <flux:error name="email" />
    </flux:field>

    <flux:field>
        <flux:label>Password</flux:label>
        <flux:input type="password" name="password" />
        <flux:description>Dejar vacío para no cambiar la contraseña.</flux:description>
        <flux:error name="password" />
    </flux:field>

    <flux:field>
        <flux:label>Roles</flux:label>
        <div class="flex gap-4 flex-wrap mt-2">
            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                <label class="flex items-center gap-2">
                    <flux:checkbox name="roles[]" value="{{ $role->name }}" :checked="in_array($role->name, $selectedRoles)" />
                    <span class="text-sm">{{ $role->name }}</span>
                </label>
            @endforeach
        </div>
    </flux:field>

    <flux:field>
        <flux:label>Ecosistema</flux:label>
        <flux:select name="ecosistema_id">
            <option value="">-- Ninguno --</option>
            @foreach(\App\Models\Ecosistema::all() as $e)
                <option value="{{ $e->id }}" @if(old('ecosistema_id', $user->ecosistema_id ?? '') == $e->id) selected @endif>{{ $e->nombre }}</option>
            @endforeach
        </flux:select>
        <flux:description>Los usuarios (no SuperAdmin) deben pertenecer a un ecosistema.</flux:description>
        <flux:error name="ecosistema_id" />
    </flux:field>
</div>
