<x-layouts.app :title="__('Editar tipos de socios/as')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tsocios.index')">{{ __('Member Types') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edit Member Type') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.tsocios.create') }}"
                class="btn btn-green">
                {{ __('New Member Type') }}</flux:button>
            <flux:button href="{{ route('admin.tsocios.index') }}"
                class="btn btn-green-dark ">
                {{ __('Member Types List') }}</flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('Edit Member Type') }}</h1>
            <form action="{{ route('admin.tsocios.update', $tsocio) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="nombre" label="{{ __('Member Type Name') }}"
                        placeholder="{{ __('Enter member type name') }}" :value="old('name', $tsocio->nombre)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="descripcion" label="{{ __('Member Type Description') }}"
                        placeholder="{{ __('Enter member type description') }}"
                        :value="old('description', $tsocio->descripcion)" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
