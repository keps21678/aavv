<x-layouts.app :title="__('Edición de Estado')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.estados.index')">{{ __('Estados') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Estado') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.estados.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nuevo Estado</a>
            <a href="{{ route('admin.estados.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Estados</a>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Estado</h1>
            <form action="{{ route('admin.estados.update', $estado->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre del Estado -->
                <div class='mb-4'>
                    <flux:input label="Nombre del Estado" name="nombre" id="nombre" type="text"
                        placeholder="Escriba el nombre del estado" value="{{ old('nombre', $estado->nombre) }}"
                        required />
                </div>

                <!-- Descripción del Estado -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción del Estado" name="descripcion" id="descripcion"
                        placeholder="Escriba una descripción del estado" required>
                        {{ old('descripcion', $estado->descripcion) }}
                    </flux:textarea>
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>