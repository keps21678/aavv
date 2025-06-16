<x-layouts.app :title="__('Detalles del Documento LOPD')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.lopd.index')">{{ __('Documentos LOPD') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Documento') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.lopd.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Listado de Documentos') }}</flux:button>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header
                :title="__('Documento LOPD de: ' . ($lopd->socio->apellidos ?? '') . ', ' . ($lopd->socio->nombre ?? ''))"
                :description="__('Datos del documento')" />
            <x-auth-session-status class="text-center" :status="session('status')" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Datos principales -->
                <div class="flex flex-col gap-6">
                    <flux:input.group label="Socio">
                        <flux:input 
                        :value="($lopd->socio->apellidos ?? '') . ', ' . ($lopd->socio->nombre ?? '') . ' - ' . ($lopd->socio->nsocio ?? '')"
                        disabled />
                        <flux:button href="{{ route('admin.socios.show', $lopd->socio_id) }}" 
                        icon:trailing="arrow-up-right" class="btn btn-green">                            
                        {{ __('Member Details') }}
                    </flux:button>
                    </flux:input.group>
                    <flux:input label="Categoría" :value="$lopd->categoria->nombre ?? '-'" disabled />
                    <flux:input label="Estado" :value="$lopd->estado->nombre ?? '-'" disabled />
                    <flux:input label="Fecha de firma"
                        :value="$lopd->fecha_firma ? $lopd->fecha_firma->format('d/m/Y') : '-'" disabled />
                </div>
                <!-- Datos adicionales -->
                <div class="flex flex-col gap-6">
                    <flux:input label="Descripción" :value="$lopd->descripcion" disabled />
                    <flux:input label="Observaciones" :value="$lopd->observaciones" disabled />
                    <div>
                        <label class="block mb-1 font-semibold">Archivo</label>
                        @if($lopd->archivo)
                        {{ $lopd->nombre_archivo }}
                        <flux:button href="{{ route('lopd.view', basename($lopd->archivo)) }}" target="_blank"
                            rel="noopener" class="btn btn-blue ml-2">
                            {{ __('View file') }}
                        </flux:button>
                        <flux:button href="{{ route('lopd.download', basename($lopd->archivo)) }}" target="_blank"
                            rel="noopener" class="btn btn-green">
                            {{ __('Download') }}
                        </flux:button>
                        @else
                        <span>-</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.lopd.edit', $lopd) }}" class="btn btn-blue">{{
                    __('Edit') }}</flux:button>
                @endhasanyrole
                <flux:button href="{{ route('admin.lopd.index') }}" class="btn btn-green-dark">{{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.app>