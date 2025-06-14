<!DOCTYPE html>
<html
    lang="{{ auth()->check() ? (auth()->user()->language ?? app()->getLocale()) : str_replace('_', '-', app()->getLocale()) }}"
    class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 text-lg">
    @if(!auth()->check())
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>{{ __('Session expired') }}</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <script>
            Swal.fire({
                    icon: 'warning',
                    title: '{{ __('Session expired') }}',
                    text: '{{ __('Your session has expired or you are not authenticated. Please log in again.') }}',
                    confirmButtonText: '{{ __('Go to home') }}'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
        </script>
    </body>

    </html>
    @php exit; @endphp
    @endif

    @php
    $groups = [
    [
    'heading' => __('Plataforma'),
    'items' => [
    [
    'name' => __('Dashboard'),
    'icon' => 'home',
    'url' => route('dashboard'),
    'current' => request()->routeIs('dashboard'),
    'label' => __('Dashboard'),
    'role' => ['admin', 'editor'],
    ],

    [
    'name' => __('Documentación'),
    'icon' => 'building-library',
    'url' => route('admin.documentacion.index'),
    'current' => request()->routeIs('lopd.*'),
    'label' => __('Documentación'),
    'role' => ['admin', 'editor'],
    ],
    ],
    ],
    [
    'heading' => __('Configuration'),
    'items' => [
    [
    'name' => __('Categories'),
    'icon' => 'shield-check',
    'url' => route('admin.categorias.index'),
    'current' => request()->routeIs('categorias.*'),
    'label' => __('Categories'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Users'),
    'icon' => 'user-group',
    'url' => route('admin.users.index'),
    'current' => request()->routeIs('users.*'),
    'label' => __('Users'),
    'role' => ['admin', 'editor', 'user'],
    ],
    [
    'name' => __('Incident Types'),
    'icon' => 'tag',
    'url' => route('admin.tincidencias.index'),
    'current' => request()->routeIs('tipos_incidencia.*'),
    'label' => __('Incident Types'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('States'),
    'icon' => 'check-circle',
    'url' => route('admin.estados.index'),
    'current' => request()->routeIs('estados.*'),
    'label' => __('States'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Types of Members'),
    'icon' => 'user-circle',
    'url' => route('admin.tsocios.index'),
    'current' => request()->routeIs('tsocios.*'),
    'label' => __('Types of Members'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Cuotas'),
    'icon' => 'currency-euro',
    'url' => route('admin.cuotas.index'),
    'current' => request()->routeIs('cuotas.*'),
    'label' => __('Fees'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Providers'),
    'icon' => 'building-storefront',
    'url' => route('admin.proveedores.index'),
    'current' => request()->routeIs('proveedores.*'),
    'label' => __('Providers'),
    'role' => ['admin', 'editor'],
    ],
    ],
    ],
    [
    'heading' => __('Members Management'),
    'items' => [
    [
    'name' => __('Members'),
    'icon' => 'users',
    'url' => route('admin.socios.index'),
    'current' => request()->routeIs('socios.*'),
    'label' => __('Members'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Incidences'),
    'icon' => 'question-mark-circle',
    'url' => route('admin.incidencias.index'),
    'current' => request()->routeIs('incidencias.*'),
    'label' => __('Incidences'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('LOPD'),
    'icon' => 'book-open-text',
    'url' => route('admin.lopd.index'),
    'current' => request()->routeIs('lopd.*'),
    'label' => __('LOPD'),
    'role' => ['admin', 'editor'],
    ],
    ],
    ],
    [
    'heading' => __('Financial Management'),
    'items' => [
    [
    'name' => __('Accounting'),
    'icon' => 'book-open',
    'url' => route('admin.contabilidad.index'),
    'current' => request()->routeIs('contabilidad.*'),
    'label' => __('Accounting'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Expenses'),
    'icon' => 'archive-box-x-mark',
    'url' => route('admin.gastos.index'),
    'current' => request()->routeIs('gastos.*'),
    'label' => __('Expenses'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Incomes'),
    'icon' => 'currency-euro',
    'url' => route('admin.ingresos.index'),
    'current' => request()->routeIs('ingresos.*'),
    'label' => __('Income'),
    'role' => ['admin', 'editor'],
    ],
    [
    'name' => __('Receipts'),
    'icon' => 'banknotes',
    'url' => route('admin.recibos.index'),
    'current' => request()->routeIs('recibos.*'),
    'label' => __('Receipts'),
    'role' => ['admin', 'editor'],
    ],
    ],
    ],
    ];
    @endphp

    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            @foreach ($groups as $group)
            <flux:navlist.group :heading="$group['heading']" class="grid">
                @foreach ($group['items'] as $item)
                <flux:navlist.item :icon="$item['icon']" :href="$item['url']" :current="$item['current']" wire:navigate>
                    {{ $item['label'] }}
                </flux:navlist.item>
                @endforeach
            </flux:navlist.group>
            @endforeach
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            {{-- <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item> --}}

            <flux:navlist.item icon="building-library" :href="route('admin.documentacion.index')" target="_self">
                {{ __('Documentación') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name='auth()->user()->name' :initials='auth()->user()->initials()'
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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
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
            <flux:profile :initials='auth()->user()->initials()' icon-trailing="chevron-down" />

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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
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