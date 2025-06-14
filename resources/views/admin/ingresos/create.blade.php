<x-layouts.app :title="__('Nuevo Ingreso')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ingresos.index')">{{ __('Ingresos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Nuevo Ingreso') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.ingresos.index') }}" class="btn btn-green-dark">Listado de Ingresos</a>
        </div>
    </div>
    <div class="rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Nuevo Ingreso')"
                :description="__('Introduce los detalles para crear el ingreso')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.ingresos.store') }}" method="POST">
                @csrf
                <!-- Contenedor de dos columnas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-2">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <!-- Selección del proveedor -->
                        <flux:select wire:model="proveedor_id" label="Proveedor" name="proveedor_id" id="proveedor_id"
                            required searchable>
                            <option value="" disabled {{ old('proveedor_id') ? '' : 'selected' }}>Seleccione un
                                proveedor</option>
                            @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id')==$proveedor->id ? 'selected' :
                                '' }}>
                                {{ $proveedor->nombre }}
                            </option>
                            @endforeach
                        </flux:select>

                        <!-- Número de ingreso -->
                        <flux:input wire:model="numero" label="Número de ingreso" name="numero" id="numero" type="text"
                            placeholder="Ingrese el número del ingreso" :value="old('numero')" required />

                        <!-- Fecha de emisión -->
                        <flux:input wire:model="fecha_emision" label="Fecha de Emisión" name="fecha_emision"
                            id="fecha_emision" type="date" :value="old('fecha_emision', now()->format('Y-m-d'))"
                            required />

                        <!-- Fecha de vencimiento -->
                        <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento" name="fecha_vencimiento"
                            id="fecha_vencimiento" type="date"
                            :value="old('fecha_vencimiento', now()->addDays(30)->format('Y-m-d'))" required />
                    </div>

                    <!-- Segunda columna -->
                    <div class="flex flex-col gap-6">
                        <!-- Importe -->
                        <flux:input wire:model="importe" label="Importe" name="importe" id="importe" type="number"
                            step="0.01" placeholder="Ingrese el importe del ingreso" :value="old('importe')" required />

                        <!-- Descripción -->
                        <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion"
                            placeholder="Escriba una descripción del ingreso" required>
                            {{ old('descripcion') }}
                        </flux:textarea>

                        <!-- Estado -->
                        <flux:select wire:model="estado_id" label="Estado" name="estado_id" id="estado_id" required>
                            <option value="" disabled {{ old('estado_id') ? '' : 'selected' }}>Seleccione un estado
                            </option>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" class="text-gray-700" {{ old('estado_id')==$estado->id ?
                                'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" variant="primary" class="btn btn-blue mb-4">Guardar Ingreso</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>