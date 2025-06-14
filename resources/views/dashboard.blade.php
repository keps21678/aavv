<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-flow-row auto-rows-max gap-4 md:grid-cols-3">
            <div
                class="relative flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">

                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mr-2">Hora: </h1>
                <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 ml-2">
                    <span id="current-time">{{ now()->format('H:i:s') }}</span>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                                setInterval(() => {
                                    const currentTimeElement = document.getElementById('current-time');
                                    const now = new Date();
                                    const formattedTime = now.toLocaleTimeString('es-ES', { hour12: false });
                                    currentTimeElement.textContent = formattedTime;
                                }, 1000);
                            });
                    </script>
                </p>

            </div>
            <div
                class="text-right relative flex items-center justify-end p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <div class="flex items-center mx-auto text-blue-600">
                    <flux:icon.users class="h-6 w-6 mr-2" />
                    <!-- Contenido de la tarjeta -->
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 mr-2">Número de Socios Activos:
                    </h2>
                    <p class="text-2xl font-extrabold  text-gray-900 dark:text-gray-100">
                        {{ \App\Models\Socio::count() }}
                    </p>
                </div>
            </div>
            <div
                class="text-right relative flex items-center justify-start p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">

                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 mr-2">Fecha: </h1>
                <p class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 ml-2">
                    {{ strtoupper(now()->locale('es')->translatedFormat('d/F/Y')) }}
                </p>

            </div>
        </div>

        <div class="grid grid-flow-row auto-rows-max gap-4 md:grid-cols-3">
            <!-- Card con el número de socios -->
            <div
                class="relative flex items-center bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <div class="flex items-center justify-center text-blue-600">
                    <div class="flex flex-col items-center">
                        <!-- Contenido de la tarjeta -->
                        <div class="flex items-center justify-center text-blue-600 mt-4">
                            <flux:icon.users class="h-6 w-6 mr-2" />
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Socios con Domiciliación:
                            </h2>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 ml-2">
                                {{ \App\Models\Socio::where('domiciliacion', true)->count() }}
                            </p>
                        </div>
                        <div class="flex items-center justify-center text-blue-600 mt-4">
                            <flux:icon.users class="h-6 w-6 mr-2" />
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Socios sin Domiciliación:
                            </h2>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 ml-2">
                                {{ \App\Models\Socio::where('domiciliacion', false)->count() }}
                            </p>
                        </div>
                        <a href="{{ route('admin.incidencias.index') }}" class="hover:underline">
                        <div class="flex items-center justify-center text-blue-600 mt-4">                            
                                <flux:icon.question-mark-circle class="h-6 w-6 mr-2" />
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Número de Incidencias
                                    Totales: </h2>
                                <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 ml-2">
                                    {{ \App\Models\Incidencia::count() }}
                                </p>                            
                        </div>
                    </a>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de ejemplo existentes -->
            <div
                class="relative flex items-center justify-center aspect-video overflow-hidden bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <div class=" bg-gray-300 h-full w-full flex items-center justify-center">
                    <img src="{{ asset('images/Logo.AAVV.svg') }}" alt="Logo AAVV"
                        class="object-contain h-full w-full" />
                    <a href="{{ asset('images/Logo.AAVV.svg') }}" download="Logo_AAVV"
                        class="px-4 py-2 me-2 mb-2 mt-auto outline place-items-end text-white rounded-lg hover:bg-blue-700">
                        Descargar Imagen
                    </a>
                </div>
            </div>
            <div
                class="place-items-stretch relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:appointments-calendar />
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border bg-white dark:bg-gray-800 border-neutral-200 dark:border-neutral-700 px-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-4">{{ __('Financial Summary') }}</h2>
            <table id="tabla" class="display table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr >
                        <th >{{ __('Concept') }}</th>
                        <th >{{ __('Total Amount (€)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ __('Total receipts') }}</td>
                        <td>
                            {{ $sumaRecibos = \App\Models\Recibo::whereYear('fecha_vencimiento', now()->year)->sum('cuota_id') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ __('Total income') }}</td>
                        <td>
                            {{ $sumaIngresos = \App\Models\Ingreso::whereYear('fecha_vencimiento', now()->year)->sum('importe') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ __('Total expenses') }}</td>
                        <td>
                            {{ $sumaGastos = \App\Models\Gasto::whereYear('fecha_vencimiento', now()->year)->sum('importe') }}
                        </td>
                    </tr>                    
                </tbody>
                <tfoot>
                    <tr>
                        <td>{{ __('Grand Total') }}</td>
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
    @push('js')
    <script>
        $(document).ready(function () {
            $('#tabla').DataTable({
                info: false,
                ordering: false,
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