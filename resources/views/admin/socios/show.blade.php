<x-layouts.app :title="__('Detalles del Socio')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Socio') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.socios.index') }}"
            class="btn btn-green-dark ">Volver al Listado</a>
    </div>

    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Detalles del Socio</h1>

            <div class="mb-4">
                <flux:heading>Nombre:</flux:heading>
                <flux:text>{{ $socio->nombre }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Apellidos:</flux:heading>
                <flux:text>{{ $socio->apellidos }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Correo Electrónico:</flux:heading>
                <flux:text>{{ $socio->email }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Teléfono:</flux:heading>
                <flux:text>{{ $socio->telefono }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Dirección:</flux:heading>
                <flux:text>{{ $socio->direccion }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Ciudad:</flux:heading>
                <flux:text>{{ $socio->ciudad }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Estado:</flux:heading>
                <flux:text>{{ $socio->estado }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Código Postal:</flux:heading>
                <flux:text>{{ $socio->codigo_postal }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Fecha de Registro:</flux:heading>
                <flux:text>{{ $socio->created_at->format('d/m/Y') }}</flux:text>
            </div>

            <div class="mb-4">
                <flux:heading>Última Actualización:</flux:heading>
                <flux:text>{{ $socio->updated_at->format('d/m/Y') }}</flux:text>
            </div>
            <div class="flex justify-end font-bold text-xl mb-4">
                <flux:button variant="primary" href="{{ route('admin.socios.edit', $socio) }}"
                class="btn btn-blue">Editar</flux:button>
            </div>
            
        </div>
    </div>
</x-layouts.app>
