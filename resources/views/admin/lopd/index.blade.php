<x-layouts.app :title="__('Documentación LOPD')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Documentos LOPD') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @hasanyrole('admin|editor')
        <flux:button href="{{ route('admin.lopd.create') }}" class="btn btn-green">
            {{ __('New Document') }}
        </flux:button>
        @endhasanyrole
    </div>
    <div class="relative overflow-x-auto px-2">
        <hr class="solid">
        <table id="tabla" class="display text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-2 py-3">Nº Socio</th>
                    <th class="px-2 py-3">{{ __('Member') }}</th>
                    <th class="px-2 py-3">{{ __('Category') }}</th>
                    <th class="px-2 py-3">{{ __('Description') }}</th>
                    <th class="px-2 py-3">{{ __('Emision date') }}</th>
                    <th class="px-2 py-3">{{ __('File') }}</th>
                    <th class="px-2 py-3">{{ __('Status') }}</th>
                    <th class="px-2 py-3">{{ __('Observations') }}</th>
                    @hasanyrole('admin|editor|viewer')
                    <th class="px-2 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
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
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-sm text-white"
                            style="background-color: {{ $lopd->estado->color }}">
                            {{ $lopd->estado->nombre }}
                        </span>
                    </td>
                    <td class="px-2 py-4">{{ $lopd->observaciones }}</td>
                    @hasanyrole('admin|editor|viewer')
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.lopd.show', $lopd) }}"
                                class="btn btn-green">{{ __('Consult') }}</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.lopd.edit', $lopd) }}"
                                class="btn btn-blue">{{ __('Edit') }}</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                                <form class="delete-form" action="{{ route('admin.lopd.destroy', $lopd) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">
                                    {{ __('Delete') }}
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