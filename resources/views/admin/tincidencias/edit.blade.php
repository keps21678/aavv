<x-layouts.app :title="__('Editar tipos de incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Tipos de incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Tipo de Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <flux:button href="{{ route('admin.tincidencias.create') }}" class="btn btn-green">
                Nueva Categoría</flux:button>
            <flux:button href="{{ route('admin.tincidencias.index') }}"
                class="btn btn-green-dark ">
                Listado de categorías</flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de tipos de incidencia</h1>
            <form action="{{ route('admin.tincidencias.update', $tincidencia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre de la categoría"
                        placeholder="Escriba el nombre del tipo de incidencia"
                        :value="old('name', $tincidencia->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="Descripción de la categoría"
                        placeholder="Escriba la descripción del tipo de incidencia"
                        :value="old('description', $tincidencia->descripcion)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
