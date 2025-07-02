<x-layouts.app :title="__('Nuevo documento')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.documentacion.index')">{{ __('Documentación') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo documento') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.documentacion.index') }}" class="btn btn-green">
            {{ __('Documentation List') }}
        </flux:button>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('Nuevo documento') }}</h1>
            <form action="{{ route('admin.documentacion.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Categoría -->
                <div class='mb-4'>
                    <flux:select label="Categoría" name="categoria_id" id="categoria_id" required>
                        <option value="" disabled selected>{{ __('Select a Category') }}</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id')==$categoria->id ? 'selected' : ''
                            }}>
                            {{ $categoria->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea label="Descripción del documento" name="descripcion" id="descripcion"
                        placeholder="Escriba la descripción del documento" required>
                        {{ old('descripcion') }}
                    </flux:textarea>
                </div>

                <!-- Fecha de firma -->
                <div class='mb-4'>
                    <flux:input label="Fecha de firma" name="fecha_firma" id="fecha_firma" type="date"
                        value="{{ old('fecha_firma', now()->format('Y-m-d')) }}" />
                </div>

                <!-- Archivo -->
                <div class='mb-4'>
                    <flux:input label="Documento" name="archivo" id="archivo" type="file"
                        class="w-full border rounded px-3 py-2" clearable="true" required />
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled selected>{{ __('Select a state') }}</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" {{ old('estado_id')==$estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Observaciones -->
                <div class='mb-4'>
                    <flux:textarea label="Observaciones" name="observaciones" id="observaciones"
                        placeholder="Observaciones adicionales">{{ old('observaciones') }}</flux:textarea>
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>