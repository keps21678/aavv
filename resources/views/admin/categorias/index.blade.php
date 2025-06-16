<x-layouts.app :title="__('Lista de categorías')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Categorías') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @hasrole('admin')
        <flux:button href="{{ route('admin.categorias.create') }}" class="btn btn-green">
            {{ __('New Category') }}
        </flux:button>  
        @endhasrole      
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">{{ __('ID') }}</th>
                    <th class="px-6 py-3">{{ __('Name') }}</th>
                    <th class="px-6 py-3">{{ __('Description') }}</th>
                    <th class="px-6 py-3">{{ __('Color') }}</th>
                    <th class="px-6 py-3">{{ __('Created At') }}</th>
                    <th class="px-6 py-3">{{ __('Updated At') }}</th>
                    @hasanyrole('admin|editor')
                    <th class="px-6 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $categoria->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $categoria->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $categoria->descripcion }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block w-6 h-6 rounded-full" style="background-color: {{ $categoria->color }};"></span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $categoria->created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $categoria->updated_at }}
                    </td>
                    @hasanyrole('admin|editor')
                    <td class="px-6 py-4">
                        <div class="flex justify-end space-x-2">                            
                            <flux:button variant="primary" href="{{ route('admin.categorias.edit', $categoria) }}"
                                class="btn btn-blue">Editar</flux:button>                           
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.categorias.destroy', $categoria) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="danger" type="submit" class="btn btn-danger">Eliminar
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