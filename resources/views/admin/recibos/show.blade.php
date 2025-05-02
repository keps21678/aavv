<x-layouts.app :title="__('Detalles del Recibo')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.recibos.index')">{{ __('Recibos') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Recibo') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.recibos.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles del recibo: ' . $recibo->recibo_numero)"
                :description="__('Información detallada del recibo')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="recibo_numero" label="Número de Recibo" placeholder="Número del recibo"
                        :value="old('recibo_numero', $recibo->recibo_numero)" disabled />
                    <flux:input wire:model="fecha_emision" label="Fecha de Emisión" placeholder="Fecha de emisión"
                        :value="old('fecha_emision', $recibo->fecha_emision->format('Y-m-d'))" disabled />
                    <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento"
                        placeholder="Fecha de vencimiento"
                        :value="old('fecha_vencimiento', $recibo->fecha_vencimiento ? $recibo->fecha_vencimiento->format('Y-m-d') : 'N/A')"
                        disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="importe" label="Importe" placeholder="Importe del recibo"
                        :value="old('importe', number_format($recibo->cuota->cantidad ?? 0, 2))" disabled />
                    <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $recibo->estado->color ?? '#000' }}">
                        {{ $recibo->estado->nombre ?? 'N/A' }}
                    </span>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Descripción del recibo"
                        disabled>{{ old('descripcion', $recibo->descripcion) }}</flux:textarea>
                    <flux:input wire:model="socio" label="Socio" placeholder="Socio asociado"
                        :value="old('socio', $recibo->socio->nombre . ' ' . $recibo->socio->apellidos ?? 'N/A')" disabled />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>