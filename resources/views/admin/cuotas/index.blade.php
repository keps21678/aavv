<x-layouts.app :title="__('Cuotas')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Cuotas') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <a href="{{ route('admin.cuotas.create') }}"
            class="btn btn-green">Nueva cuota</a>
    </div>
    <br />
    <div class="relative overflow-x-auto">

        <hr class="solid">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tipo Cuota/Socio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Año
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cantidad (€)
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
                @foreach ($cuotas as $cuota)
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cuota->tsocio->nombre ?? 'Sin asignar' }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $cuota->anyo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cuota->cantidad }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cuota->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $cuota->updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-2">
                                {{-- <bootstrap:button variant="primary"
                                href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit
                            </bootstrap:button> --}}
                                {{-- <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-blue justify-end">Editar</a> --}}
                                <flux:button variant="primary" href="{{ route('admin.cuotas.edit', $cuota) }}"
                                    class="btn btn-blue">Editar</flux:button>

                                <form class="delete-form" action="{{ route('admin.cuotas.destroy', $cuota) }}"
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
