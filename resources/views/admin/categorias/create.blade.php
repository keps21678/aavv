<x-layouts.app :title="__('Nueva categoría')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categorias.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nueva categoría') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.categorias.index') }}" class="btn btn-green">
            {{ __('Category List') }}
        </flux:button>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('New Category') }}</h1>
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="{{ __('Category Name') }}"
                        placeholder="{{ __('Enter category name') }}" :value="old('nombre')" required />
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="{{ __('Category Description') }}"
                        placeholder="{{ __('Enter category description') }}" :value="old('descripcion')" required />
                </div>
                <div class='mb-4'>
                    <flux:input label="{{ __('Category Color') }}" name="color" id="color" type="color"
                        value="{{ old('color') }}" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save Category') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>