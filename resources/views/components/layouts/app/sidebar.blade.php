@php
    $groups = [
        // 📊 Dashboard
        'Dashboard' => [
            [
                'name' => 'Métricas',
                'icon' => 'home',
                'routes' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
                'can' => 'Dashboard',
            ],
        ],

        // 👑 Gestión Global del Sistema (SOLO SUPER ADMIN)
        'Gestor SuperAdmin' => [
            [
                'name' => 'Gestor de Usuarios',
                'icon' => 'users',
                'routes' => route('admin.users.index'),
                'current' => request()->routeIs('admin.users.*'),
                'can' => 'Gestor SuperAdmin',
            ],
            [
                'name' => 'Gestor de Ecosistema',
                'icon' => 'building-library',
                'routes' => route('admin.ecosistema.index'),
                'current' => request()->routeIs('admin.ecosistema.*'),
                'can' => 'Gestor SuperAdmin',
            ],
            [
                'name' => 'Gestor de Roles y Permisos',
                'icon' => 'key',
                'routes' => route('admin.roles.index'),
                'current' => request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*'),
                'can' => 'Gestor SuperAdmin',
            ],
        ],

        // 🏢 Mi Ecosistema (PARA ADMIN DE ECOSISTEMA y USUARIOS)
        'Panel ' .( auth()->user()?->ecosistema?->nombre ?? 'de trabajo') => [
            // 📥 Bandeja de Entrada
            [
                'name' => 'Bandeja de Entrada', //Actuaciones asignadas a mí
                'icon' => 'inbox',
                'routes' => '#',
                'current' => false,
                'can' => 'Bandeja de Entrada',
            ],
            [
                'name' => 'Actuaciones equipo',
                'icon' => 'users',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.inbox.team',
            ],
            [
                'name' => 'Actuaciones vencidas / próximas',
                'icon' => 'exclamation-triangle',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.inbox.due',
            ],

            // 📂 Seguimiento de Actuaciones
            [
                'name' => 'Buscador de Actuaciones',
                'icon' => 'magnifying-glass',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.tracking.search',
            ],
            [
                'name' => 'Historial completo',
                'icon' => 'clock',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.tracking.history',
            ],
            [
                'name' => 'Reportes / Exportar',
                'icon' => 'document-text',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.tracking.reports',
            ],
        ],
        // 🛠️ Diseño de Secuencias
        'Diseño de Secuencias' => [
            [
                'name' => 'Tipos de Actuación',
                'icon' => 'table-cells',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.flows.types',
            ],
            [
                'name' => 'Diseñador de Secuencias',
                'icon' => 'puzzle-piece',
                'routes' => '#',
                'current' => false,
                'can' => 'Diseñador de Secuencias',
            ],
            [
                'name' => 'Gestor de Estados',
                'icon' => 'rectangle-stack',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.flows.states',
            ],
            [
                'name' => 'Gestor de Transiciones',
                'icon' => 'arrow-path',
                'routes' => '#',
                'current' => false,
                'can' => 'ecosystem.flows.transitions',
            ],
        ],
        // 👥 Gestión de Mi Equipo
        'Gestión de Mi Equipo' => [
            [
                'name' => 'Usuarios',
                'icon' => 'users',
                'routes' => route('ecosystem.users.index'),
                'current' => request()->routeIs('ecosystem.users.*'),
                'can' => 'Usuarios del Ecosistema', //Listar usuarios de propio ecosistema
            ],
            [
                'name' => 'Roles y Permisos',
                'icon' => 'user-plus',
                'routes' => route('ecosystem.roles.index'),
                'current' => request()->routeIs('ecosystem.roles.*'),
                'can' => 'Roles y Permisos del Ecosistema', //Gestor roles de propio ecosistema
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
    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            @foreach ($groups as $group => $items)
                @php
                    $hasPermission = false;
                    foreach ($items as $item) {
                        if (
                            auth()
                                ->user()
                                ->can($item['can'] ?? null)
                        ) {
                            $hasPermission = true;
                            break;
                        }
                    }
                @endphp

                @if ($hasPermission)
                    <flux:navlist.group :heading="$group" class="grid">
                        @foreach ($items as $item)
                            @canany($item['can'] ?? [null])
                                <flux:navlist.item :icon="$item['icon']" :href="$item['routes']"
                                    :current="$item['current']" wire:navigate>
                                    {{ $item['name'] }}
                                </flux:navlist.item>
                            @endcanany
                        @endforeach
                    </flux:navlist.group>
                @endif
            @endforeach
        </flux:navlist>

        <flux:spacer />

        {{-- <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist> --}}

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
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
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

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

    {{ $slot }}

    @fluxScripts
</body>

</html>
