<x-layouts.app :title="__('Edición de Incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.incidencias.index')">{{ __('Incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.incidencias.index') }}" class="btn btn-green-dark">Listado de Incidencias</a>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Incidencia</h1>
            <form action="{{ route('admin.incidencias.update', $incidencia->id) }}" method="POST">
                @csrf
                @method('PUT')

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

                <div class='mb-4'>
                    <flux:select label="Tipo de Incidencia" name="tincidencia_id" id="tincidencia_id" required>
                        <option value="" disabled>Seleccione un tipo de incidencia</option>
                        @foreach ($tincidencias as $tincidencia)
                        <option value="{{ $tincidencia->id }}" {{ $incidencia->tincidencia_id == $tincidencia->id ?
                            'selected' : '' }}>
                            {{ $tincidencia->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <div class='mb-4'>
                    <flux:textarea label="Descripción de la incidencia" name="descripcion" id="descripcion"
                        placeholder="Escriba la descripción de la incidencia" required>
                        {{ old('descripcion', $incidencia->descripcion) }}
                    </flux:textarea>
                </div>

                <div class='mb-4'>
                    <flux:input label="Fecha de la incidencia" name="fecha_incidencia" id="fecha_incidencia" type="date"
                        value="{{ old('fecha_incidencia', $incidencia->fecha_incidencia ? \Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('Y-m-d') : now()->format('Y-m-d')) }}" required />
                    {{-- type="text" value="{{ old('fecha_incidencia', $incidencia->fecha_incidencia ?
                    \Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('d/m/Y') : now()->format('d/m/Y')) }}"
                    required /> --}}
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>