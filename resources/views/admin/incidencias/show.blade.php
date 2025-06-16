<x-layouts.app :title="__('Detalles de la Incidencia')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.incidencias.index')">{{ __('Incidencias') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles de la Incidencia') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.incidencias.index', ['socio_id' => $incidencia->socio_id ?? null]) }}"
            class="btn btn-green-dark">{{ __('Incident List') }}</flux:button>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg bg-white dark:bg-gray-800 py-4">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles de la incidencia: ' . $incidencia->id)"
                :description="__('Información detallada de la incidencia')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input label="ID" :value="$incidencia->id" disabled />
                    <flux:input label="Fecha de incidencia"
                        :value="optional($incidencia->fecha_incidencia)->format('Y-m-d')" disabled />
                    <flux:input label="Añadido/Modificado el"
                        :value="optional($incidencia->updated_at)->format('Y-m-d H:i')" disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:textarea label="Descripción" disabled>{{ $incidencia->descripcion }}</flux:textarea>
                    <flux:input label="Socio/Proveedor relacionado"
                        :value="$incidencia->socio->nombre ?? $incidencia->proveedor->nombre ?? 'N/A'" disabled />
                    @if($incidencia->observaciones)
                    <flux:textarea label="Observaciones" disabled>{{ $incidencia->observaciones }}</flux:textarea>
                    @endif
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.incidencias.edit', $incidencia) }}" class="btn btn-blue">
                    {{ __('Edit') }}
                </flux:button>
                @endhasanyrole
                <flux:button href="{{ route('admin.incidencias.index') }}" class="btn btn-green-dark">
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.app>