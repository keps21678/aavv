<x-layouts.app :title="__('Editar categoría')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categorias.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar categoría') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.categorias.create') }}" class="btn btn-green">
                {{ __('New Category') }}
            </flux:button>
            <flux:button href="{{ route('admin.categorias.index') }}" class="btn btn-green">
                {{ __('Category List') }}
            </flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de categoría</h1>
            <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="Nombre de la categoría"
                        placeholder="Escriba el nombre de la categoría" :value="old('nombre', $categoria->nombre)"
                        required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="Descripción de la categoría"
                        placeholder="Escriba la descripción de la categoría"
                        :value="old('descripcion', $categoria->descripcion)" required />
                </div>
                <div class='mb-4'>
                    <flux:input label="Color de la categoría" name="color" id="color" type="color"
                        value="{{ old('color', $categoria->color) }}" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>