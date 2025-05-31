<x-layouts.app :title="__('Documentación LOPD')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Documentos LOPD') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.lopd.create') }}" class="btn btn-green">
            Nuevo Documento
        </flux:button>
    </div>
    <div class="relative overflow-x-auto px-2">
        <hr class="solid">
        <table id="tabla" class="display text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-2 py-3">Nº Socio</th>
                    <th class="px-2 py-3">Socio</th>
                    <th class="px-2 py-3">Categoría</th>
                    <th class="px-2 py-3">Descripción</th>
                    <th class="px-2 py-3">Fecha Firma</th>
                    <th class="px-2 py-3">Archivo</th>
                    <th class="px-2 py-3">Estado</th>
                    <th class="px-2 py-3">Observaciones</th>
                    <th class="px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lopds as $lopd)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">
                        {{ $lopd->socio->nsocio ?? '-' }}
                    </td>
                    <td class="px-2 py-4">
                        {{ ($lopd->socio->apellidos ?? '') . ', ' . ($lopd->socio->nombre ?? '-') }}
                    </td>
                    <td class="px-2 py-4">{{ $lopd->categoria->nombre ?? '-' }}</td>
                    <td class="px-2 py-4">{{ $lopd->descripcion }}</td>
                    <td class="px-2 py-4">{{ $lopd->fecha_firma ? $lopd->fecha_firma->format('d/m/Y') : '-' }}</td>
                    <td class="px-2 py-4">
                        {{ $lopd->nombre_archivo }}                        
                    </td>
                    <td class="px-2 py-4">{{ $lopd->estado->nombre ?? '-' }}</td>
                    <td class="px-2 py-4">{{ $lopd->observaciones }}</td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.lopd.show', $lopd) }}"
                                class="btn btn-green">Consultar</flux:button>
                            <flux:button variant="primary" href="{{ route('admin.lopd.edit', $lopd) }}"
                                class="btn btn-blue">Editar</flux:button>
                            <form class="delete-form" action="{{ route('admin.lopd.destroy', $lopd) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">
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
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
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