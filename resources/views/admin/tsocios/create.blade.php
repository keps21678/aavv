<x-layouts.app :title="__('Nuevo tipo de socio/a')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Tipos de socios/as') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo tipo de socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.tsocios.index') }}"
            class="btn btn-green-dark ">Listado de
            tipos de socios/as</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('New Member Type') }}</h1>
            <form action="{{ route('admin.tsocios.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="{{ __('Member Type Name') }}"
                        placeholder="{{ __('Enter member type name') }}" :value="old('nombre')" required />
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="{{ __('Member Type Description') }}"
                        placeholder="{{ __('Enter member type description') }}" :value="old('descripcion')" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
