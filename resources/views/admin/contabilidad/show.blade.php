<x-layouts.app :title="__('Resumen Contable del Año en Curso')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.contabilidad.index')">{{ __('Contabilidad') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Resumen Contable') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <a href="{{ route('admin.contabilidad.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>
    <hr class="solid">
    <x-auth-header :title="__('Resumen Contable del Año en Curso')"
        :description="__('Suma de importes y número de facturas y recibos del año en curso')" />
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

</x-layouts.app>