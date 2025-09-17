@php
    $groups = [
        'Dashboard' => [
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'routes' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
                // 'permission' prefers a route-name based permission; fallback to 'can'
                'permission' => 'dashboard',
                'can' => 'Dashboard',
            ],
        ],
        'Gestor de usuarios' => [
            [
                'name' => 'Permisos',
                'icon' => 'key',
                'routes' => route('admin.permissions.index'),
                'current' => request()->routeIs('admin.permissions.*'),
                'can' => 'Gestor de usuarios',
            ],
            [
                'name' => 'Roles',
                'icon' => 'user',
                'routes' => route('admin.roles.index'),
                'current' => request()->routeIs('admin.roles.*'),
                'can' => 'Gestor de usuarios',
            ],
            [
                'name' => 'Asignación de Rol',
                'icon' => 'users',
                'routes' => route('admin.user-roles.index'),
                'current' => request()->routeIs('admin.user-roles.*'),
                'can' => 'Gestor de usuarios',
            ],
        ],
        'Agente' => [
            [
                'name' => 'Tickets',
                'icon' => 'ticket',
                'routes' => route('agent.tickets.index'),
                'current' => request()->routeIs('agent.tickets.*'),
                'permission' => 'agent.tickets.index',
                'can' => 'Agente',
            ],
        ],
        'Revisor' => [
            [
                'name' => 'Revisiones',
                'icon' => 'check-circle',
                'routes' => route('reviewer.reviews.index'),
                'current' => request()->routeIs('reviewer.reviews.*'),
                'permission' => 'reviewer.reviews.index',
                'can' => 'Revisor',
            ],
        ],
        'Firmante' => [
                [
                    'name' => 'Firmas',
                    'icon' => 'pencil-square',
                    'routes' => route('signer.signatures.index'),
                    'current' => request()->routeIs('signer.signatures.*'),
                    'permission' => 'signer.signatures.index',
                    'can' => 'Firmante',
                ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <a href="{{ route('home') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
        <x-app-logo />
    </a>

    <flux:navbar class="-mb-px max-lg:hidden">            
        @foreach ($groups as $group => $items)
            @php
                $hasPermission = false;
                foreach ($items as $item) {
                    // Check permission by explicit route-name permission first
                    if (! empty($item['permission']) && auth()->user()->can($item['permission'])) {
                        $hasPermission = true;
                        break;
                    }

                    // Fallback to legacy human-readable permission
                    if (! empty($item['can']) && auth()->user()->can($item['can'])) {
                        $hasPermission = true;
                        break;
                    }
                }
            @endphp

            @if ($hasPermission)
                @foreach ($items as $item)
                    {{-- Try permission by route name first, else fallback to legacy permission names --}}
                    @php
                        $permissionCheck = $item['permission'] ?? $item['can'] ?? null;
                        // canany expects an array
                        $permissionArray = is_array($permissionCheck) ? $permissionCheck : [$permissionCheck];
                    @endphp
                    @canany($permissionArray)
                        <flux:navbar.item :icon="$item['icon']" :href="$item['routes']" :current="$item['current']"
                            wire:navigate>
                            {{ $item['name'] }}
                        </flux:navbar.item>
                    @endcanany
                @endforeach
            @endif
        @endforeach
    </flux:navbar>

    <flux:spacer />

    <!-- Desktop User Menu -->
    <flux:dropdown position="top" align="end">
        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <span
                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
    class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
        <x-app-logo />
    </a>

    <flux:navlist variant="outline">
        @foreach ($groups as $group => $items)
            @php
                $hasPermission = false;
                foreach ($items as $item) {
                    // desktop logic: check by route-name permission then fallback to human-readable permission
                    if (! empty($item['permission']) && auth()->user()->can($item['permission'])) {
                        $hasPermission = true;
                        break;
                    }

                    if (! empty($item['can']) && auth()->user()->can($item['can'])) {
                        $hasPermission = true;
                        break;
                    }
                }
            @endphp

            @if ($hasPermission)
                <flux:navlist.group :heading="$group">
                    @foreach ($items as $item)
                        @php
                            $permissionCheck = $item['permission'] ?? $item['can'] ?? null;
                            $permissionArray = is_array($permissionCheck) ? $permissionCheck : [$permissionCheck];
                        @endphp
                        @canany($permissionArray)
                            <flux:navlist.item :icon="$item['icon']" :href="$item['routes']" :current="$item['current']"
                                wire:navigate>
                                {{ $item['name'] }}
                            </flux:navlist.item>
                        @endcanany
                    @endforeach
                </flux:navlist.group>
            @endif
        @endforeach
    </flux:navlist>

    <flux:spacer />
</flux:sidebar>

{{ $slot }}

@fluxScripts    
</body>

</html>
