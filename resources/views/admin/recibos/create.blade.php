<x-layouts.app :title="__('Nuevo Recibo')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.recibos.index')">{{ __('Recibos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Crear un nuevo recibo') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.recibos.index') }}" class="btn btn-green-dark">Listado de Recibos</a>
        </div>
    </div>
    <div class="max-w-xl mx-auto rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Crear un nuevo recibo')" :description="__('Introduce los detalles del recibo')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.recibos.store') }}" method="POST">
                @csrf
                <!-- Contenedor de dos columnas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-2">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <!-- Socio -->
                        <flux:select wire:model="socio_id" label="Socio" name="socio_id" id="socio_id" required>
                            <option value="" disabled selected>Seleccionar socio</option>
                            @foreach ($socios as $socio)
                            <option value="{{ $socio->id }}" data-tsocio="{{ $socio->tsocio_id }}">
                                {{ $socio->nombre }} {{ $socio->apellidos }}
                            </option>
                            @endforeach
                        </flux:select>

                        <!-- Tipo de Socio -->
                        <flux:select wire:model="tsocio_id" label="Tipo de Socio" name="tsocio_id" id="tsocio_id" required>
                            <option value="" disabled selected>Seleccionar tipo de socio</option>
                            @foreach ($tsocios as $tsocio)
                            <option value="{{ $tsocio->id }}">{{ $tsocio->nombre }}</option>
                            @endforeach
                        </flux:select> 
                        <!-- Cuota -->
                        <flux:select wire:model="cuota_id" label="Cuota" name="cuota_id" id="cuota_id" required>
                            <option value="" disabled selected>Seleccionar cuota</option>
                            @foreach ($cuotas as $cuota)
                                <option value="{{ $cuota->id }}" data-tsocio="{{ $cuota->tsocio_id }}">
                                    {{ $cuota->cantidad }} € - {{ $cuota->tsocio->nombre }}
                                </option>
                            @endforeach
                        </flux:select>                       
                    </div>

                    <!-- Segunda columna -->
                    <div class="flex flex-col gap-6">                       
                        <!-- Fecha de Emisión -->
                        <flux:input wire:model="fecha_emision" label="Fecha de Emisión" name="fecha_emision"
                            id="fecha_emision" type="date" :value="old('fecha_emision')" required />

                        <!-- Fecha de Vencimiento -->
                        <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento" name="fecha_vencimiento"
                            id="fecha_vencimiento" type="date" :value="old('fecha_vencimiento')" />
                    </div>
                </div>

                <!-- Estado -->
                <div class="mt-6">
                    <flux:select wire:model="estado" label="Estado" name="estado_id" id="estado_id" required>
                        <option value="" disabled selected>Seleccionar estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Descripción -->
                <div class="mt-6">
                    <flux:textarea wire:model="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        placeholder="Escriba una descripción">{{ old('descripcion') }}</flux:textarea>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar Recibo</flux:button>
                </div>
            </form>
        </div>
    </div>
    @push('js')
    <script>
        document.getElementById('socio_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const tsocioId = selectedOption.getAttribute('data-tsocio');
            document.getElementById('tsocio_id').value = tsocioId;

            // Actualizar la cuota automáticamente
            const cuotaSelect = document.getElementById('cuota_id');
            const cuotas = cuotaSelect.options;
            for (let i = 0; i < cuotas.length; i++) {
                if (cuotas[i].getAttribute('data-tsocio') === tsocioId) {
                    cuotaSelect.value = cuotas[i].value;
                    break;
                }
            }
        });

        document.getElementById('tsocio_id').addEventListener('change', function () {
            const tsocioId = this.value;

            // Actualizar la cuota automáticamente
            const cuotaSelect = document.getElementById('cuota_id');
            const cuotas = cuotaSelect.options;
            for (let i = 0; i < cuotas.length; i++) {
                if (cuotas[i].getAttribute('data-tsocio') === tsocioId) {
                    cuotaSelect.value = cuotas[i].value;
                    break;
                }
            }
        });
    </script>
    @endpush
</x-layouts.app>