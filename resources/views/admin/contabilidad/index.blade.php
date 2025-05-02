<x-layouts.app :title="__('Resumen Contable del Año en Curso')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.contabilidad.index')">{{ __('Contabilidad') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Resumen Contable') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.contabilidad.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Resumen Contable del Año en Curso')"
                :description="__('Suma de importes y número de facturas y recibos del año en curso')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Tabla de Resumen -->
            <div class="overflow-x-auto">
                <table id="tabla" class="display table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th>{{ __('Concepto') }}</th>
                            <th>{{ __('Cantidad') }}</th>
                            <th>{{ __('Importe Total (€)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Recibos') }}</td>
                            <td>{{ $numeroRecibos }}</td>
                            <td>{{ number_format($sumaRecibos, 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Facturas') }}</td>
                            <td>{{ $numeroFacturas }}</td>
                            <td>{{ number_format($sumaFacturas, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>{{ __('Total General') }}</td>
                            <td></td>
                            <td>
                                @php
                                    $totalGeneral = $sumaRecibos - $sumaFacturas;
                                @endphp
                                <span class="{{ $totalGeneral < 0 ? 'text-red-500 font-bold' : '' }}">
                                    {{ $totalGeneral < 0 ? '-' : '' }}{{ number_format(abs($totalGeneral), 2) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function () {
            $('#tabla').DataTable({
                paging: false,
                searching: false,
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Traducción al español
                },
            });
        });
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esto',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>