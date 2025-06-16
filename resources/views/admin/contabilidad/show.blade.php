<x-layouts.app :title="__('Resumen Contable del Año en Curso')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.contabilidad.index')">{{ __('Accounting') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Accounting Summary') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <a href="{{ route('admin.contabilidad.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>
    <hr class="solid">
    <x-auth-header :title="__('Accounting Summary for Current Year')"
        :description="__('Sum of amounts and number of invoices and receipts for the current year')" />
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

</x-layouts.app>