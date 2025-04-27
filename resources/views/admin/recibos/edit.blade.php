<x-layouts.app :title="__('Edición de Recibo')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.recibos.index')">{{ __('Recibos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edición de Recibo') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.recibos.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nuevo Recibo</a>
            <a href="{{ route('admin.recibos.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Recibos</a>
        </div>
    </div>

    <div class="max-w-2xl rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Recibo</h1>
            <form action="{{ route('admin.recibos.update', $recibo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Selección del socio -->
                <div class='mb-4'>
                    <flux:select wire:model="socio_id" label="Socio" name="socio_id" id="socio_id" required searchable>
                        <option value="" disabled>Seleccione un socio</option>
                        @foreach ($socios as $socio)
                        <option value="{{ $socio->id }}" {{ $recibo->socio_id == $socio->id ? 'selected' : '' }}>
                            {{ $socio->nombre }} {{ $socio->apellidos }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    <!-- Selección del tipo de socio -->
                    <div class='mb-2'>
                        <flux:select wire:model="tsocio_id" label="Tipo de Socio" name="tsocio_id" id="tsocio_id"
                            required searchable>
                            <option value="" disabled>Seleccione un tipo de socio</option>
                            @foreach ($tsocios as $tsocio)
                            <option value="{{ $tsocio->id }}" {{ $recibo->tsocio_id == $tsocio->id ? 'selected' : '' }}>
                                {{ $tsocio->nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                    </div>

                    <!-- Selección de la cuota -->
                    <div class='mb-2'>
                        <flux:select wire:model="cuota_id" label="Cuota" name="cuota_id" id="cuota_id" required
                            searchable>
                            <option value="" disabled>Seleccione una cuota</option>
                            @foreach ($cuotas as $cuota)
                            <option value="{{ $cuota->id }}" {{ $recibo->cuota_id == $cuota->id ? 'selected' : '' }}>
                                {{ $cuota->cantidad }} €
                            </option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <!-- Número de recibo -->
                <div class='mb-4'>
                    <flux:input wire:model="recibo_numero" label="Número de Recibo" name="recibo_numero"
                        id="recibo_numero" type="text" placeholder="Ingrese el número del recibo"
                        :value="old('recibo_numero', $recibo->recibo_numero)" required />
                </div>

                <!-- Fecha de Emisión -->
                <div class='mb-4'>
                    <flux:input label="Fecha de emisión del recibo" name="fecha_emision" id="fecha_emision" type="date"
                        value="{{ old('fecha_emision', $recibo->fecha_emision ? $recibo->fecha_emision->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>

                <!-- Descripción -->
                <div class='mb-4'>
                    <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion"
                        placeholder="Escriba una descripción del recibo" required>
                        {{ old('descripcion', $recibo->descripcion) }}
                    </flux:textarea>
                </div>

                <!-- Estado -->
                <div class='mb-4'>
                    <flux:select wire:model="estado_id" label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" class="text-gray-700" {{ $recibo->estado_id == $estado->id ?
                            'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Fecha de Vencimiento -->
                <div class='mb-4'>
                    <flux:input label="Fecha de vencimiento del recibo" name="fecha_vencimiento" id="fecha_vencimiento"
                        type="date"
                        value="{{ old('fecha_vencimiento', $recibo->fecha_vencimiento ? $recibo->fecha_vencimiento->format('Y-m-d') : now()->format('Y-m-d')) }}"
                        required />
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar Cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>