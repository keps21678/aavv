<x-layouts.app :title="__('Incidencias')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Incidencias') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            @hasanyrole('admin|editor')
            <flux:button href="{{ route('admin.incidencias.create', ['socio_id' => request('socio_id')]) }}"
                class="btn btn-green">{{ __('New Incident') }}</flux:button>
            @endhasanyrole            
            <flux:button href="{{ route('admin.socios.index') }}" class="btn btn-green-dark">{{ __('Member List') }}</flux:button>
        </div>
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">{{ __('Member No.') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Name') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Last Name') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Incident Type') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Description') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Incident Date') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('State') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Created At') }}</th>
                    @hasanyrole('admin|editor|viewer')
                    <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
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
                        <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $incidencia->estado->color }}">
                            {{ $incidencia->estado->nombre }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $incidencia->created_at->format('d/m/Y') }}
                    </td>
                    @hasanyrole('admin|editor|viewer')
                    <td class="px-6 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.incidencias.show', $incidencia) }}"
                                class="btn btn-green">{{ __('Consult') }}</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.incidencias.edit', $incidencia) }}"
                                class="btn btn-blue">
                                {{ __('Edit') }}</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.incidencias.destroy', $incidencia) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">{{ __('Delete') }}
                                </flux:button>
                            </form>
                            @endhasrole 
                        </div>
                    </td>
                    @endhasanyrole
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