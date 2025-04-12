<x-layouts.app :title="__('Editar tipos de socios/as')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tsocios.index')">{{ __('Tipos de incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Tipo de socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.tsocios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">
                Listado de tipos de socios/as</a>
            <a href="{{ route('admin.tsocios.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
                Nuevo tipo de socio/a</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de tipos de socios/as</h1>
            <form action="{{ route('admin.tsocios.update', $tsocio) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre del tipo de socio/a"
                        placeholder="Escriba el nombre del tipo de socio/a" :value="old('name', $tsocio->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="Descripción del tipo de socio/a"
                        placeholder="Escriba la descripción del tipo de socio/a"
                        :value="old('description', $tsocio->descripcion)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
