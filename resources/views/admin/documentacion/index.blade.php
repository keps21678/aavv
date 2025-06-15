<x-layouts.app :title="__('Documentación')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Documentación') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.documentacion.create') }}" class="btn btn-green">
            {{ __('New Document') }}
        </flux:button>
    </div>
    <div class="relative overflow-x-auto px-2">
        <hr class="solid">
        <table id="tabla" class="display text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-2 py-3">{{ __('Category') }}</th>
                    <th class="px-2 py-3">{{ __('State') }}</th>
                    <th class="px-2 py-3">{{ __('File') }}</th>
                    <th class="px-2 py-3">{{ __('Description') }}</th>
                    <th class="px-2 py-3">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos as $documento)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $documento->categoria->nombre ?? '-' }}</td>
                    <td class="px-2 py-4">
                        @if($documento->estado)
                        <span class="px-2 py-1 rounded-full text-white"
                            style="background-color: {{ $documento->estado->color ?? '#808080' }};">
                            {{ $documento->estado->nombre ?? 'Sin estado' }}
                        </span>
                        @else
                        <span class="px-2 py-1 rounded-full text-gray-500 bg-gray-200">
                            Sin estado
                        </span>
                        @endif
                    </td>
                    <td class="px-2 py-4">
                        <flux:button icon:trailing="arrow-up-right"
                            href="{{ route('documentacion.view', basename($documento->archivo)) }}" target="_blank"
                            class="text-blue-600 underline mr-2">
                            {{ $documento->nombre_archivo ?? 'Ver archivo' }}
                        </flux:button>
                    </td>
                    <td class="px-2 py-4">{{ $documento->descripcion }}</td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right"
                                href="{{ route('admin.documentacion.show', $documento) }}" class="btn btn-green">
                                Consultar</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.documentacion.edit', $documento) }}"
                                class="btn btn-blue">Editar</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.documentacion.destroy', $documento) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">
                                    Eliminar
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