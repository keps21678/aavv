<x-layouts.app :title="__('Resumen Contable del Año en Curso')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.contabilidad.index')">{{ __('Contabilidad') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Resumen Contable') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.contabilidad.index') }}" class="btn btn-green">
            {{ __('Back to List') }}
        </flux:button>        
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Resumen Contable del Año en Curso')"
                :description="__('Suma de importes y número de gastos, recibos e ingresos del año en curso')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Tabla de Resumen -->
            <div class="overflow-x-auto">
                <table id="tabla" class="display table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th>{{ __('Concept') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Total Amount (€)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Receipts') }}</td>
                            <td>{{ $numeroRecibos }}</td>
                            <td>{{ number_format($sumaRecibos, 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Expenses') }}</td>
                            <td>{{ $numeroGastos }}</td>
                            <td>{{ number_format($sumaGastos, 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Incomes') }}</td>
                            <td>{{ $numeroIngresos }}</td>
                            <td>{{ number_format($sumaIngresos, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>{{ __('Total General') }}</td>
                            <td></td>
                            <td>
                                @php
                                    $totalGeneral = $sumaRecibos + $sumaIngresos - $sumaGastos;
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