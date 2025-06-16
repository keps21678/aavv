<x-layouts.app :title="__('Detalle documento')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.documentacion.index')">{{ __('Documentación') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalle documento') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="">
            @hasanyrole('admin|editor')
            <flux:button href="{{ route('admin.documentacion.create') }}" class="btn btn-green">
                {{ __('Nuevo Documento') }}
            </flux:button>
            @endhasanyrole
            <flux:button href="{{ route('admin.documentacion.index') }}" class="btn btn-green-dark">
                {{ __('Listado de Documentos') }}
            </flux:button>
        </div>
    </div>
    <div class="max-w-2xl rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800">
        <div class="px-6 py-4">
            <h1 class="font-bold text-xl mb-4">{{ __('Detalle documento') }}</h1>
            <div class="mb-4">
                <strong>{{ __('Categoría:') }}</strong>
                <span>{{ $documentacion->categoria->nombre ?? '-' }}</span>
            </div>
            <div class="mb-4">
                <strong>{{ __('Descripción:') }}</strong>
                <span>{{ $documentacion->descripcion }}</span>
            </div>
            <div class="mb-4">
                <strong>{{ __('Fecha de firma:') }}</strong>
                <span>{{ $documentacion->fecha_firma ?
                    \Carbon\Carbon::parse($documentacion->fecha_firma)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="mb-4">
                <strong>{{ __('Archivo:') }}</strong>
                @if($documentacion->archivo)
                <a href="{{ route('documentacion.view', basename($documentacion->archivo)) }}" target="_blank"
                    class="text-blue-600 underline mr-2">
                    {{ $documentacion->nombre_archivo ?? __('Ver archivo') }}
                </a>
                <a href="{{ route('documentacion.download', basename($documentacion->archivo)) }}"
                    class="text-green-700 underline" download>
                    {{ __('Download') }}
                </a>
                @else
                <span>-</span>
                @endif
            </div>
            <div class="mb-4">
                <strong>{{ __('Document State') }}:</strong>
                <span>{{ $documentacion->estado->nombre ?? '-' }}</span>
            </div>
            <div class="mb-4">
                <strong>{{ __('Observaciones') }}:</strong>
                <span>{{ $documentacion->observaciones }}</span>
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.documentacion.edit', $documentacion) }}" class="btn btn-blue">{{
                    __('Edit') }}</flux:button>
                @endhasanyrole
                <flux:button href="{{ route('admin.documentacion.index') }}" class="btn btn-green-dark">{{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.app>