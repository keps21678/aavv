<x-layouts.app :title="__('Receipt List')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Receipts') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.recibos.create') }}" class="btn btn-green">
                {{ __('New Receipt') }}
            </flux:button>
            <flux:button id="generar-remesa" class="btn btn-blue-dark mr-2">
                {{ __('Generate Remittance') }}
            </flux:button>
        </div>                
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">{{ __('Receipt Number') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Member') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Fee') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Amount') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Issue Date') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Status') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Due Date') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recibos as $recibo)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $recibo->recibo_numero }}</td>
                    <td class="px-2 py-4">{{ $recibo->socio->nombre . ' ' . $recibo->socio->apellidos ?? 'N/A' }}</td>
                    <td class="px-2 py-4">{{ $recibo->tsocio->nombre ?? 'N/A' }}</td>
                    <td class="px-2 py-4">{{ number_format($recibo->cuota->cantidad, 2) }} €</td>
                    <td class="px-2 py-4">{{ $recibo->fecha_emision ? $recibo->fecha_emision->format('Y-m-d') : 'N/A' }}
                    </td>
                    <td class="px-2 py-4">
                        <span class="px-2 py-1 rounded-full text-sm text-white"
                            style="background-color: {{ $recibo->estado->color }}">
                            {{ $recibo->estado->nombre }}
                        </span>
                    </td>
                    <td class="px-2 py-4">{{ $recibo->fecha_vencimiento ? $recibo->fecha_vencimiento->format('Y-m-d') :
                        'N/A' }}</td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right"
                                href="{{ route('admin.recibos.show', $recibo) }}" class="btn btn-green mr-2">{{ __('Consult') }}
                            </flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.recibos.edit', $recibo) }}"
                                class="btn btn-blue">{{ __('Edit') }}</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.recibos.destroy', $recibo) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
                                    {{ __('Delete') }}
                                </flux:button>
                            </form>
                            @endhasrole
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('js')
    <script>
        $(document).ready(function () {
            $('#tabla').DataTable({
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                layout: {
                    topStart: 'buttons',
                    topEnd: 'search',
                    bottom: null,
                    bottomStart: null,
                    bottomEnd: 'info',
                },
                responsive: true,
                paging: false,
                scrollCollapse: true,
                scrollY: '60vh',
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
    <script>
        document.getElementById('generar-remesa').addEventListener('click', function () {
            // Mostrar un mensaje de carga mientras se genera el archivo
            Swal.fire({
                title: 'Generando remesa...',
                text: 'Por favor, espera mientras se genera el archivo.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar la solicitud para generar el archivo
            fetch('{{ route('admin.recibos.generarRemesa') }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.blob(); // Descargar el archivo como blob
                } else {
                    throw new Error('Error al generar la remesa. ' + response.statusText);
                }
            })
            .then(blob => {
                // Crear un enlace para descargar el archivo
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'remesa_recibos.xlsx'; // Nombre del archivo
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

                // Cerrar el mensaje de carga
                Swal.close();

                // Recargar la página
                location.reload();
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error',
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>