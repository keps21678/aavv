<x-layouts.app :title="__('Lista de Facturas')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Facturas') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.facturas.create') }}" class="btn btn-green">
            Nueva Factura
        </flux:button>
    </div>
    <br />
    <div class="relative overflow-x-auto">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">Número</th>
                    <th scope="col" class="px-2 py-3">Proveedor</th>
                    <th scope="col" class="px-2 py-3">Descripción</th>                    
                    <th scope="col" class="px-2 py-3">Fecha Emisión</th>
                    <th scope="col" class="px-2 py-3">Fecha Vencimiento</th>
                    <th scope="col" class="px-2 py-3">Importe</th>
                    <th scope="col" class="px-2 py-3">Estado</th>
                    <th scope="col" class="px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $factura->numero }}</td>
                    <td class="px-2 py-4">{{ $factura->proveedor->nombre }}</td>                    
                    <td class="px-2 py-4">{{ $factura->descripcion }}</td>
                    <td class="px-2 py-4">{{ $factura->fecha_emision }}</td>
                    <td class="px-2 py-4">{{ $factura->fecha_vencimiento }}</td>
                    <td class="px-2 py-4 whitespace-nowrap">{{ number_format($factura->importe, 2) }} €</td>
                    <td class="px-2 py-4">
                        <span class="px-2 py-1 rounded-full text-sm text-white bg-{{ $factura->estado === 'pagada' ? 'green' : ($factura->estado === 'pendiente' ? 'yellow' : 'red') }}-500">
                            {{ ucfirst($factura->estado) }}
                        </span>
                    </td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.facturas.show', $factura) }}"
                                class="btn btn-green mr-2">Consultar</flux:button>
                            <flux:button variant="primary" href="{{ route('admin.facturas.edit', $factura) }}"
                                class="btn btn-blue">Editar</flux:button>
                            <form class="delete-form" action="{{ route('admin.facturas.destroy', $factura) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
                                    Eliminar
                                </flux:button>
                            </form>
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