<x-layouts.app :title="__('Nuevo Usuario')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios/as') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Crear una cuenta de Socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de
                Socios/as</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg p-2 mt-4">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Crear una cuenta de socio/a ')"
                :description="__('Introduce a continuación, los detalles  para crear la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                        :value="old('nombre', $socio->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                        :value="old('apellidos', $socio->apellidos)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="email" label="Email" placeholder="Escriba el email del usuario"
                        :value="old('email', $socio->email)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="password" label="Contraseña" type="password" required
                        placeholder="Escriba la contraseña" />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="password_confirmation" label="Confirmar Contraseña" type="password" required
                        placeholder="Confirme la contraseña" />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Create</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>