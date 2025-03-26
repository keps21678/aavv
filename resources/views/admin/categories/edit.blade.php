<x-layouts.app :title="__('Editar categoría')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categories.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar categoría') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-xs">Listado de
                categorías</a>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">Nueva
                Categoría</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de categoría</h1>
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="name" label="Nombre de la categoría"
                        placeholder="Escriba el nombre categoría" :value="old('name', $category->name)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="description" label="Descripción de la categoría"
                        placeholder="Escriba la descripción de la categoría"
                        :value="old('description', $category->description)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
