<x-layouts.app :title="__('Incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Incidencias') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.incidencias.create', ['socio_id' => request('socio_id')]) }}"
                class="btn btn-green">Nueva
                incidencia</a>
            <a href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark">Listado de Socios/as</a>
        </div>
    </div>
    <br />
    <div class="relative overflow-x-auto">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nº Socio</th>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Apellidos</th>
                <th scope="col" class="px-6 py-3">Tipo de Incidencia</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Fecha de Incidencia</th>
                <th scope="col" class="px-6 py-3">Creado</th>
                <th scope="col" class="px-6 py-3">Editar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($incidencias as $incidencia)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4">
                    {{ $incidencia->socio->nsocio ?? 'Sin asignar' }}
                </th>
                <td class="px-6 py-4">
                    {{ $incidencia->socio->nombre ?? 'Sin asignar' }}
                </td>
                <td class="px-6 py-4">
                    {{ $incidencia->socio->apellidos ?? 'Sin asignar' }}
                </td>
                <td class="px-6 py-4">
                    {{ $incidencia->tincidencia->nombre ?? 'Sin asignar' }}
                </td>
                <td class="px-6 py-4">
                    {{ $incidencia->descripcion }}
                </td>
                <td class="px-6 py-4">
                    {{ $incidencia->fecha_incidencia->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4">
                    {{ $incidencia->created_at }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-end space-x-2">
                    <flux:button variant="primary"
                        href="{{ route('admin.incidencias.edit', $incidencia) }}" class="btn btn-blue">
                        Editar</flux:button>

                    <form class="delete-form"
                        action="{{ route('admin.incidencias.destroy', $incidencia) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit" class="btn btn-danger">Eliminar
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
                        cancelButtonText: 'Cancelar',
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
