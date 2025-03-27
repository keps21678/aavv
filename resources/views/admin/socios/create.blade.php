<x-layouts.app :title="__('Nuevo Usuario')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Usuarios/as') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Crear una cuenta de Socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.socios.index') }}"
                class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-xs">Listado de
                usuarios</a>
            <a href="{{ route('admin.socios.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">Nuevo/a
                Usuario/a</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg p-2 mt-4">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Crear una cuenta de usuario/a ')"
                :description="__('Introduce a continuación, los detalles  para crear la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="name" label="Nombre y Apellidos" placeholder="Esciba el Nombre y Apellidos"
                        :value="old('name')" required />
                </div>
                <div c>
                    <flux:input wire:model="email" label="Email" placeholder="Escriba el email del usuario"
                        :value="old('description')" required />
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
