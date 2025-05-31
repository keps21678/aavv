<x-layouts.app :title="__('Nueva categoría')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categorias.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nueva categoría') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.categorias.index') }}"
            class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
            Listado de categorías</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Nueva categoría</h1>
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre de la categoría"
                        placeholder="Escriba el nombre de la categoría" :value="old('nombre')" required />
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción de la categoría"
                        placeholder="Escriba la descripción de la categoría" :value="old('descripcion')" required />
                </div>
                <div class='mb-4'>
                    <flux:input label="Color de la categoría" name="color" id="color" type="color"
                        value="{{ old('color') }}" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Crear</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>