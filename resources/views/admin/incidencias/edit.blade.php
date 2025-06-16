<x-layouts.app :title="__('Edición de Incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.incidencias.index')">{{ __('Incidencias') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.incidencias.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nueva Incidencia</a>
            <a href="{{ route('admin.incidencias.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Incidencias</a>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Incidencia</h1>
            <form action="{{ route('admin.incidencias.update', $incidencia->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Socio -->
                <div class='mb-4'>
                    <flux:select label="Socio" name="socio_id" id="socio_id" required searchable>
                        <option value="" disabled>Seleccione un socio</option>
                        @foreach ($socios as $socio)
                        <option value="{{ $socio->id }}" {{ $incidencia->socio_id == $socio->id ? 'selected' : '' }}>
                            {{ $socio->nombre }} {{ $socio->apellidos }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Tipo de Incidencia -->
                <div class='mb-4'>
                    <flux:select label="Tipo de Incidencia" name="tincidencia_id" id="tincidencia_id" required>
                        <option value="" disabled>Seleccione un tipo de incidencia</option>
                        @foreach ($tincidencias as $tincidencia)
                        <option value="{{ $tincidencia->id }}" {{ $incidencia->tincidencia_id == $tincidencia->id ? 'selected' : '' }}>
                            {{ $tincidencia->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción de la incidencia" name="descripcion" id="descripcion"
                        placeholder="Escriba la descripción de la incidencia" required>
                        {{ old('descripcion', $incidencia->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Fecha de la Incidencia -->
                <div class='mb-4'>
                    <flux:input label="Fecha de la incidencia" name="fecha_incidencia" id="fecha_incidencia" type="date"
                        value="{{ old('fecha_incidencia', $incidencia->fecha_incidencia ? \Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('Y-m-d') : now()->format('Y-m-d')) }}" required />
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" {{ $incidencia->estado_id == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save Changes') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>