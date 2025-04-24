<x-layouts.app :title="__('Detalles de la Factura')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.facturas.index')">{{ __('Facturas') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles de la Factura') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.facturas.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles de la factura: ' . $factura->numero)"
                :description="__('Información detallada de la factura')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="numero" label="Número de Factura" placeholder="Número de la factura"
                        :value="old('numero', $factura->numero)" disabled />
                    <flux:input wire:model="fecha_emision" label="Fecha de Emisión" placeholder="Fecha de emisión"
                        :value="old('fecha_emision', $factura->fecha_emision->format('Y-m-d'))" disabled />
                    <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento"
                        placeholder="Fecha de vencimiento"
                        :value="old('fecha_vencimiento', $factura->fecha_vencimiento ? $factura->fecha_vencimiento->format('Y-m-d') : 'N/A')"
                        disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="importe" label="Importe" placeholder="Importe de la factura"
                        :value="old('importe', number_format($factura->importe, 2))" disabled />
                        <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $factura->estado->color }}">
                            {{ $factura->estado->nombre }}
                        </span>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Descripción de la factura"
                        disabled>{{ old('descripcion', $factura->descripcion) }}</flux:textarea>
                    <flux:input wire:model="proveedor" label="Proveedor" placeholder="Proveedor asociado"
                        :value="old('proveedor', $factura->proveedor->nombre ?? 'N/A')" disabled />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>