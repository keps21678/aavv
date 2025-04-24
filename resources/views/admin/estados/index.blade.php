<x-layouts.app :title="__('Estados')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Estados') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.estados.create') }}" class="btn btn-green">Nuevo Estado</a>
        </div>
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Descripción</th>
                    <th scope="col" class="px-6 py-3">Creado</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estados as $estado)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        {{ $estado->id }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $estado->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $estado->descripcion }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $estado->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button variant="primary" href="{{ route('admin.estados.edit', $estado) }}"
                                class="btn btn-blue">
                                Editar
                            </flux:button>

                            <form class="delete-form" action="{{ route('admin.estados.destroy', $estado) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">Eliminar</flux:button>
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