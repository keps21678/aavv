<x-layouts.app :title="__('Edición de Ingreso')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ingresos.index')">{{ __('Ingresos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Ingreso') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.ingresos.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nuevo Ingreso</a>
            <a href="{{ route('admin.ingresos.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Ingresos</a>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Ingreso</h1>
            <form action="{{ route('admin.ingresos.update', $ingreso->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Selección del proveedor -->
                <div class='mb-4'>
                    <flux:select wire:model="proveedor_id" label="Proveedor" name="proveedor_id" id="proveedor_id"
                        required searchable>
                        <option value="" disabled>Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $ingreso->proveedor_id) ==
                            $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Número de ingreso -->
                <div class='mb-4'>
                    <flux:input wire:model="numero" label="Número de ingreso" name="numero" id="numero" type="text"
                        placeholder="Ingrese el número del ingreso" :value="old('numero', $ingreso->numero)" required />
                </div>

                <!-- Fecha de Emision ingreso -->
                <div class='mb-4'>
                    <flux:input label="Fecha de emisión del ingreso" name="fecha_emision" id="fecha_emision" type="date"
                        value="{{ old('fecha_emision', $ingreso->fecha_emision ? \Carbon\Carbon::parse($ingreso->fecha_emision)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Fecha de Vencimiento del ingreso -->
                <div class='mb-4'>
                    <flux:input label="Fecha vencimiento del ingreso" name="fecha_vencimiento" id="fecha_vencimiento"
                        type="date"
                        value="{{ old('fecha_vencimiento', $ingreso->fecha_vencimiento ? \Carbon\Carbon::parse($ingreso->fecha_vencimiento)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Monto de ingreso -->
                <div class='mb-4'>
                    <flux:input wire:model="importe" label="Importe" name="importe" id="importe" type="number"
                        step="0.01" placeholder="Ingrese el importe del ingreso"
                        :value="old('importe', $ingreso->importe)" required />
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion"
                        placeholder="Escriba una descripción del ingreso" required>
                        {{ old('descripcion', $ingreso->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select wire:model="estado_id" label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" class="text-gray-700" {{ $ingreso->estado_id == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar Cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>