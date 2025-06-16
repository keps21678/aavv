<x-layouts.app :title="__('Nuevo tipo de incidencia')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Tipos de incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo tipo de incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.tincidencias.index') }}"
            class="btn btn-green-dark ">{{ __('Incident Types List') }}</flux:button>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('New Incident Type') }}</h1>
            <form action="{{ route('admin.tincidencias.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="{{ __('Incident Type Name') }}"
                        placeholder="{{ __('Enter category name') }}" :value="old('nombre')" required />
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="{{ __('Incident Type Description') }}"
                        placeholder="{{ __('Enter incident type description') }}" :value="old('descripcion')" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
