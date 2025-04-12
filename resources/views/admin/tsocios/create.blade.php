<x-layouts.app :title="__('Nuevo tipo de socio/a')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Tipos de socios/as') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo tipo de socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <a href="{{ route('admin.tsocios.index') }}"
            class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de
            tipos de socios/as</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Nuevo Tipo de socio/a</h1>
            <form action="{{ route('admin.tsocios.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre del tipo de socio/a"
                        placeholder="Escriba el nombre tipo de socio/a" :value="old('nombre')" required />
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción del tipo de socio/a"
                        placeholder="Escriba la descripción del tipo de socio/a" :value="old('descripcion')" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Create</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
