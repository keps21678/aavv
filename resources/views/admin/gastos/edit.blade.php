<x-layouts.app :title="__('Edición de Gastos')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.gastos.index')">{{ __('gastos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Gasto') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.gastos.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">{{ __('New Expense') }}</flux:button>
            <flux:button href="{{ route('admin.gastos.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Expense List') }}</flux:button>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('Edit Expense') }}</h1>
            <form action="{{ route('admin.gastos.update', $gasto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Selección del proveedor -->
                <div class='mb-4'>
                    <flux:select wire:model="proveedor_id" label="{{ __('Provider') }}" name="proveedor_id" id="proveedor_id"
                        required searchable>
                        <option value="" disabled>{{ __('Select a provider') }}</option>
                        @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $gasto->proveedor_id == $proveedor->id ? 'selected' :
                            '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Número de gasto -->
                <div class='mb-4'>
                    <flux:input wire:model="numero" label="Número de gasto" name="numero" id="numero" type="text"
                        placeholder="Ingrese el número de la gasto" :value="old('numero', $gasto->numero)"
                        required />
                </div>

                <!-- Fecha de Emision gasto -->
                <div class='mb-4'>
                    <flux:input label="Fecha de emisión de la gasto" name="fecha_emision" id="fecha_emision" type="date"
                        value="{{ old('fecha_emision', $gasto->fecha_emision ? \Carbon\Carbon::parse($gasto->fecha_emision)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Fecha de Vencimiento de la gasto -->
                <div class='mb-4'>
                    <flux:input label="Fecha vencimiento de la gasto" name="fecha_vencimiento" id="fecha_vencimiento" type="date"
                        value="{{ old('fecha_vencimiento', $gasto->fecha_vencimiento ? \Carbon\Carbon::parse($gasto->fecha_vencimiento)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>
                <!-- Monto de gasto -->
                <div class='mb-4'>
                    <flux:input wire:model="importe" label="importe" name="importe" id="importe" type="number"
                        step="0.01" placeholder="Ingrese el importe de la gasto"
                        :value="old('importe', $gasto->importe)" required />
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion"
                        placeholder="Escriba una descripción de la gasto" required>
                        {{ old('descripcion', $gasto->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select wire:model="estado_id" label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" class="text-gray-700" {{ $gasto->estado_id == $estado->id ? 'selected' : '' }}>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>