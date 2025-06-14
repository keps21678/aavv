<x-layouts.app :title="__('Detalles del Ingreso')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.ingresos.index')">{{ __('Ingresos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Ingreso') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.ingresos.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles del Ingreso: ' . $ingreso->numero)"
                :description="__('Información detallada del ingreso')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="numero" label="Número de Ingreso" placeholder="Número del ingreso"
                        :value="old('numero', $ingreso->numero)" disabled />
                    <flux:input wire:model="fecha_emision" label="Fecha de Emisión" placeholder="Fecha de emisión"
                        :value="old('fecha_emision', $ingreso->fecha_emision ? \Carbon\Carbon::parse($ingreso->fecha_emision)->format('Y-m-d') : 'N/A')"
                        disabled />
                    <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento"
                        placeholder="Fecha de vencimiento"
                        :value="old('fecha_vencimiento', $ingreso->fecha_vencimiento ? \Carbon\Carbon::parse($ingreso->fecha_vencimiento)->format('Y-m-d') : 'N/A')"
                        disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="importe" label="Importe" placeholder="Importe del ingreso"
                        :value="old('importe', number_format($ingreso->importe, 2))" disabled />
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                        @if($ingreso->estado)
                        <span class="px-2 py-1 rounded-full text-sm text-white"
                            style="background-color: {{ $ingreso->estado->color ?? '#808080' }};">
                            {{ $ingreso->estado->nombre ?? 'No definido' }}
                        </span>
                        @else
                        <span class="px-2 py-1 rounded-full text-sm text-gray-500">
                            N/A
                        </span>
                        @endif
                    </div>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Descripción del ingreso"
                        disabled>{{ old('descripcion', $ingreso->descripcion) }}</flux:textarea>
                    <flux:input wire:model="proveedor" label="Proveedor" placeholder="Proveedor asociado"
                        :value="old('proveedor', $ingreso->proveedor->nombre ?? 'N/A')" disabled />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>