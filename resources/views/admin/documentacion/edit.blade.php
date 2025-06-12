<x-layouts.app :title="__('Editar documento')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.documentacion.index')">{{ __('Documentación') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar documento') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.documentacion.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nuevo Documento</a>
            <a href="{{ route('admin.documentacion.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Documentos</a>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Editar documento</h1>
            <form action="{{ route('admin.documentacion.update', $documentacion->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Categoría -->
                <div class='mb-4'>
                    <flux:select label="Categoría" name="categoria_id" id="categoria_id" required>
                        <option value="" disabled>Seleccione una categoría</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $documentacion->categoria_id == $categoria->id ?
                            'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción del documento" name="descripcion" id="descripcion"
                        placeholder="Escriba la descripción del documento" required>
                        {{ old('descripcion', $documentacion->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Fecha de firma -->
                <div class='mb-4'>
                    <flux:input label="Fecha de firma" name="fecha_firma" id="fecha_firma" type="date"
                        value="{{ old('fecha_firma', $documentacion->fecha_firma ? \Carbon\Carbon::parse($documentacion->fecha_firma)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>

                <!-- Archivo -->
                <div class='mb-4'>
                    <label class="block mb-1 font-semibold">Archivo actual</label>
                    @if($documentacion->archivo)
                    <a href="{{ route('documentacion.view', basename($documentacion->archivo)) }}" target="_blank"
                        rel="noopener" class="text-blue-600 underline mr-2">
                        {{ $documentacion->nombre_archivo ?? 'Ver archivo' }}
                    </a>
                    <a href="{{ route('documentacion.download', basename($documentacion->archivo)) }}"
                        class="text-green-700 underline" download>
                        Descargar
                    </a>
                    @else
                    <span>-</span>
                    @endif
                    <flux:input label="Nuevo archivo (opcional)" name="archivo" id="archivo" type="file"
                        class="w-full border rounded px-3 py-2 mt-2" />
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" {{ $documentacion->estado_id == $estado->id ? 'selected' : ''
                            }}>
                            {{ $estado->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Observaciones -->
                <div class='mb-4'>
                    <flux:textarea label="Observaciones" name="observaciones" id="observaciones"
                        placeholder="Observaciones adicionales">{{ old('observaciones', $documentacion->observaciones)
                        }}
                    </flux:textarea>
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>