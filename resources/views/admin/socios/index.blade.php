<x-layouts.app :title="__('Lista de Socios')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Socios/as') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <a href="{{ route('admin.socios.create') }}"
            class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
            Nuevo Socio
        </a>
    </div>
    <br />
    <div class="relative overflow-x-auto">

        <hr class="solid">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Socio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Apellidos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Movil
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Persona Contacto
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
                @foreach ($socios as $socio)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $socio->nsocio }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $socio->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $socio->apellidos }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $socio->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $socio->movil }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $socio->persona_contacto }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $socio->updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-2">
                                {{-- <bootstrap:button variant="primary"
                                href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit
                            </bootstrap:button> --}}
                                {{-- <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-blue justify-end">Editar</a>  --}}
                                <flux:button variant="primary" href="{{ route('admin.socios.edit', $socio) }}"
                                    class="btn btn-blue">Editar</flux:button>

                                <form class="delete-form" action="{{ route('admin.socios.destroy', $socio) }}"
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
        <div class="mt-2">
            {{ $socios->links() }}
        </div>
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
