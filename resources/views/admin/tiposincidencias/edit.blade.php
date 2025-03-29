<x-layouts.app :title="__('Editar categoría')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tiposincidencias.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar los tipos de incidencias') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.tiposincidencias.index') }}"
                class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-xs">Listado de
                categorías</a>
            <a href="{{ route('admin.tiposincidencias.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">Nueva
                Categoría</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de categoría</h1>
            <form action="{{ route('admin.tiposincidencias.update', $tipoIncidencia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre de la categoría"
                        placeholder="Escriba el nombre categoría" :value="old('name', $tipoIncidencia->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="Descripción de la categoría"
                        placeholder="Escriba la descripción de la categoría"
                        :value="old('description', $tipoIncidencia->descripcion)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
