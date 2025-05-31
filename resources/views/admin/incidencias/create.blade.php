<x-layouts.app :title="__('Nueva Incidencia')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.incidencias.index')">{{ __('Incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nueva Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.incidencias.index') }}" class="btn btn-green-dark">Listado de Incidencias</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Nueva Incidencia</h1>
            <form action="{{ route('admin.incidencias.store') }}" method="POST">
                @csrf

                <!-- Socio -->
                <div class='mb-4'>
                    <flux:select label="Socio" name="socio_id" id="socio_id" required searchable>
                        <option value="" disabled {{ request('socio_id') ? '' : 'selected' }}>Seleccione un socio
                        </option>
                        @foreach ($socios as $socio)
                        <option value="{{ $socio->id }}" {{ (old('socio_id', request('socio_id'))==$socio->id) ?
                            'selected' : '' }}>
                            {{ $socio->apellidos }}, {{ $socio->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Tipo de Incidencia -->
                <div class='mb-4'>
                    <flux:select label="Tipo de Incidencia" name="tincidencia_id" id="tincidencia_id" required>
                        <option value="" disabled selected>Seleccione un tipo de incidencia</option>
                        @foreach ($tincidencias as $tincidencia)
                        <option value="{{ $tincidencia->id }}" {{ old('tincidencia_id')==$tincidencia->id ? 'selected' :
                            '' }}>
                            {{ $tincidencia->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción de la incidencia" name="descripcion" id="descripcion"
                        placeholder="Escriba la descripción de la incidencia" required>
                        {{ old('descripcion') }}
                    </flux:textarea>
                </div>

                <!-- Fecha de la Incidencia -->
                <div class='mb-4'>
                    <flux:input label="Fecha de la incidencia" name="fecha_incidencia" id="fecha_incidencia" type="date"
                        value="{{ old('fecha_incidencia', now()->format('Y-m-d')) }}" required />
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled selected>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" {{ old('estado_id')==$estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Crear Incidencia</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>