<x-layouts.app :title="__('Receipt details')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.recibos.index')">{{ __('Receipts') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Receipt details') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.recibos.index') }}"
            class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Receipt List') }}
        </flux:button>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg  bg-white dark:bg-gray-800 py-4">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles del recibo: ' . $recibo->numero)"
                :description="__('Información detallada del recibo')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="numero" label="Número de recibo" placeholder="Número del recibo"
                        :value="old('numero', $recibo->recibo_numero)" disabled />
                    <flux:input wire:model="fecha_emision" label="Fecha de Emisión" placeholder="Fecha de emisión"
                        :value="old('fecha_emision', $recibo->fecha_emision ? $recibo->fecha_emision->format('Y-m-d') : 'N/A')"
                        disabled />
                    <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento"
                        placeholder="Fecha de vencimiento"
                        :value="old('fecha_vencimiento', $recibo->fecha_vencimiento ? $recibo->fecha_vencimiento->format('Y-m-d') : 'N/A')"
                        disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="importe" label="Importe" placeholder="Importe del recibo"
                        :value="old('importe', number_format($recibo->cuota->cantidad, 2))" disabled />
                    <span class="px-2 py-1 rounded-full text-sm text-white"
                        style="background-color: {{ $recibo->estado->color }}">
                        {{ $recibo->estado->nombre }}
                    </span>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Descripción del recibo"
                        disabled>{{ old('descripcion', $recibo->descripcion) }}</flux:textarea>

                    <flux:input.group label="{{ __('Member') }}">
                        <flux:input
                            :value="old('socio', ($recibo->socio->nsocio ?? 'N/A') . ' - ' . ($recibo->socio->apellidos ?? '') . ', ' . ($recibo->socio->nombre ?? ''))"
                            disabled />
                        <flux:button href="{{ route('admin.socios.show', $recibo->socio_id) }}"
                            icon:trailing="arrow-up-right" class="btn btn-green">
                            {{ __('Member Details') }}
                        </flux:button>
                    </flux:input.group>
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.recibos.edit', $recibo) }}" class="btn btn-blue">
                    {{ __('Edit') }}
                </flux:button>
                @endhasanyrole
                <flux:button href="{{ route('admin.recibos.index') }}" class="btn btn-green-dark">
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.app>