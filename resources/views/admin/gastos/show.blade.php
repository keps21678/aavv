<x-layouts.app :title="__('Detalles del Gasto')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.gastos.index')">{{ __('Expenses') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Expense Details') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.gastos.index') }}" class="btn btn-green-dark">
            {{ __('Back to List') }}
        </flux:button>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg  bg-white dark:bg-gray-800 py-4">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles del gasto: ' . $gasto->numero)"
                :description="__('Información detallada del gasto')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="numero" label="Número de gasto" placeholder="Número de la gasto"
                        :value="old('numero', $gasto->numero)" disabled />
                    <flux:input wire:model="fecha_emision" label="Fecha de Emisión" placeholder="Fecha de emisión"
                        :value="old('fecha_emision', $gasto->fecha_emision->format('Y-m-d'))" disabled />
                    <flux:input wire:model="fecha_vencimiento" label="Fecha de Vencimiento"
                        placeholder="Fecha de vencimiento"
                        :value="old('fecha_vencimiento', $gasto->fecha_vencimiento ? $gasto->fecha_vencimiento->format('Y-m-d') : 'N/A')"
                        disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="importe" label="Importe" placeholder="Importe de la gasto"
                        :value="old('importe', number_format($gasto->importe, 2))" disabled />
                    <span class="px-2 py-1 rounded-full text-sm text-white"
                        style="background-color: {{ $gasto->estado->color }}">
                        {{ $gasto->estado->nombre }}
                    </span>
                    <flux:textarea wire:model="descripcion" label="Descripción" placeholder="Descripción de la gasto"
                        disabled>{{ old('descripcion', $gasto->descripcion) }}</flux:textarea>
                            
                    <flux:input.group label="Proveedor">
                        <flux:input
                            :value="($gasto->proveedor->nif ?? '') . ' - ' . ($gasto->proveedor->nombre ?? '')"
                            disabled />
                        <flux:button href="{{ route('admin.proveedores.show', $gasto->proveedor_id) }}"
                            icon:trailing="arrow-up-right" class="btn btn-green">
                            {{ __('Provider Details') }}
                        </flux:button>
                    </flux:input.group>
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.gastos.edit', $gasto) }}" class="btn btn-blue">
                    {{ __('Edit') }}
                </flux:button>
                @endhasanyrole
                <flux:button href="{{ route('admin.gastos.index') }}" class="btn btn-green-dark">
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.app>