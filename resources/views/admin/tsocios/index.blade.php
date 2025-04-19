<x-layouts.app :title="__('Lista de tiposde socios/as')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Tipos de socios/as') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <flux:button href="{{ route('admin.tsocios.create') }}"
            class="btn btn-green">Nuevo tipo de socios/as</flux:button>
    </div>
    <br />
    <div class="relative overflow-x-auto">

        <hr class="solid">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Updated At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Editar
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tsocios as $tsocio)
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $tsocio->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $tsocio->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $tsocio->descripcion }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $tsocio->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $tsocio->updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-2">
                                {{-- <bootstrap:button variant="primary"
                                href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit
                            </bootstrap:button> --}}
                                {{-- <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-blue justify-end">Editar</a> --}}
                                <flux:button variant="primary" href="{{ route('admin.tsocios.edit', $tsocio) }}"
                                    class="btn btn-blue">Editar</flux:button>

                                <form class="delete-form" action="{{ route('admin.tsocios.destroy', $tsocio) }}"
                                    method="POST">
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
