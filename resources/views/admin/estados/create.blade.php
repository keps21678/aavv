<x-layouts.app :title="__('Nuevo Estado')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.estados.index')">{{ __('Estados') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo Estado') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.estados.index') }}" class="btn btn-green-dark">Listado de Estados</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Nuevo Estado</h1>
            <form action="{{ route('admin.estados.store') }}" method="POST">
                @csrf

                <!-- Nombre del Estado -->
                <div class='mb-4'>
                    <flux:input label="Nombre del Estado" name="nombre" id="nombre" type="text"
                        placeholder="Escriba el nombre del estado" value="{{ old('nombre') }}" required />
                </div>

                <!-- Descripción del Estado -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción del Estado" name="descripcion" id="descripcion"
                        placeholder="Escriba una descripción del estado" required>
                        {{ old('descripcion') }}
                    </flux:textarea>
                </div>

                <!-- Color del Estado -->
                <div class='mb-4'>
                    <flux:input label="Color del Estado" name="color" id="color" type="color"
                        value="{{ old('color') }}" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Crear Estado</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>