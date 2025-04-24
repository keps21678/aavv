<x-layouts.app :title="__('Edición de Factura')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.facturas.index')">{{ __('Facturas') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Factura') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.facturas.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nueva Factura</a>
            <a href="{{ route('admin.facturas.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Facturas</a>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Factura</h1>
            <form action="{{ route('admin.facturas.update', $factura->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Selección del proveedor -->
                <div class='mb-4'>
                    <flux:select wire:model="proveedor_id" label="Proveedor" name="proveedor_id" id="proveedor_id"
                        required searchable>
                        <option value="" disabled>Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $factura->proveedor_id == $proveedor->id ? 'selected' :
                            '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Número de factura -->
                <div class='mb-4'>
                    <flux:input wire:model="numero" label="Número de Factura" name="numero" id="numero" type="text"
                        placeholder="Ingrese el número de la factura" :value="old('numero', $factura->numero)"
                        required />
                </div>

                <!-- Fecha de Emision factura -->
                <div class='mb-4'>
                    <flux:input label="Fecha de emisión de la factura" name="fecha_emision" id="fecha_emision" type="date"
                        value="{{ old('fecha_emision', $factura->fecha_emision ? \Carbon\Carbon::parse($factura->fecha_emision)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Fecha de Vencimiento de la factura -->
                <div class='mb-4'>
                    <flux:input label="Fecha vencimiento de la factura" name="fecha_vencimiento" id="fecha_vencimiento" type="date"
                        value="{{ old('fecha_vencimiento', $factura->fecha_vencimiento ? \Carbon\Carbon::parse($factura->fecha_vencimiento)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Monto de factura -->
                <div class='mb-4'>
                    <flux:input wire:model="importe" label="importe" name="importe" id="importe" type="number"
                        step="0.01" placeholder="Ingrese el importe de la factura"
                        :value="old('importe', $factura->importe)" required />
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion"
                        placeholder="Escriba una descripción de la factura" required>
                        {{ old('descripcion', $factura->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select wire:model="estado_id" label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" class="text-gray-700" {{ $factura->estado_id == $estado->id ? 'selected' : '' }}>
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