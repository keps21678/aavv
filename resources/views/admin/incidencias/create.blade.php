<x-layouts.app :title="__('Nueva Incidencia')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.incidencias.index')">{{ __('Incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nueva Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.incidencias.index') }}"
            class="btn btn-green-dark">Listado de Incidencias</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Nueva Incidencia</h1>
            <form action="{{ route('admin.incidencias.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:select wire:model="socio_id" label="Socio" name="socio_id" id="socio_id" required searchable>
                        <option value="" disabled {{ !$socioId ? 'selected' : '' }}>Seleccione un socio</option>
                        @foreach ($socios as $socio)
                            <option value="{{ $socio->id }}" {{ $socioId == $socio->id ? 'selected' : '' }}>
                                {{ $socio->nombre }} {{ $socio->apellidos }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>
                <div class='mb-4'>
                    <flux:select wire:model="tincidencia_id" label="Tipo de Incidencia" name="tincidencia_id"
                        id="tincidencia_id" required>
                        <flux:select.option value="" disabled selected>Seleccione un tipo de incidencia</flux:select.option>
                        @foreach ($tincidencias as $tincidencia)
                            <flux:select.option value="{{ $tincidencia->id }}">{{ $tincidencia->nombre }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción de la incidencia" name="descripcion"
                        placeholder="Escriba la descripción de la incidencia" required>
                        {{ old('descripcion') }}
                    </flux:textarea>
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="fecha_incidencia" label="Fecha de la incidencia" name="fecha_incidencia"
                        type="date" :value="old('fecha_incidencia')" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Crear Incidencia</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
