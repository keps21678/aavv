<x-layouts.app :title="__('Editar tipos de incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Incident Types') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edit Incident Type') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.tincidencias.create') }}" class="btn btn-green">
                {{ __('New Incident Type') }}
            </flux:button>
            <flux:button href="{{ route('admin.tincidencias.index') }}"
                class="btn btn-green-dark ">
                {{ __('Incident Types List') }}
            </flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('Edit Incident Type') }}</h1>
            <form action="{{ route('admin.tincidencias.update', $tincidencia) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="{{ __('Incident Type Name') }}"
                        placeholder="{{ __('Enter incident type name') }}"
                        :value="old('name', $tincidencia->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="{{ __('Incident Type Description') }}"
                        placeholder="{{ __('Enter incident type description') }}"
                        :value="old('description', $tincidencia->descripcion)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
