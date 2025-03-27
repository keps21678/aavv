<x-layouts.app :title="__('Editar socio/a')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios/as') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Socios/as') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.socios.index') }}"
                class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-xs">Listado de
                Socios</a>
            <a href="{{ route('admin.socios.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">Nuevo/a
                Socio/a</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Socio/a</h1>
            <form action="{{ route('admin.socios.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                        :value="old('name', $socio->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                        :value="old('apellidos', $socio->apellidos)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="email" label="Email" placeholder="Escriba el email del socio"
                        :value="old('email', $socio->email)" required />
                </div>
                <div class='mb-4 gap-2'>
                    @foreach ($roles as $role)
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ?
                    'checked' : '' }}>
                    {{ $role->name }}
                    @endforeach
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>