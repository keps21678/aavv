<x-layouts.app :title="__('Lista de Proveedores')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Proveedores') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.proveedores.create') }}" class="btn btn-green">
            Nuevo Proveedor
        </flux:button>
    </div>
    <br />
    <div class="relative overflow-x-auto">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">NIF</th>
                    <th scope="col" class="px-2 py-3">Nombre</th>
                    <th scope="col" class="px-2 py-3">Teléfono</th>
                    <th scope="col" class="px-2 py-3">Email</th>
                    <th scope="col" class="px-2 py-3">Persona Contacto</th>
                    <th scope="col" class="px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $proveedor->nif }}</td>
                    <td class="px-2 py-4">{{ $proveedor->nombre }}</td>
                    <td class="px-2 py-4">{{ $proveedor->telefono }}</td>
                    <td class="px-2 py-4">{{ $proveedor->email }}</td>
                    <td class="px-2 py-4">{{ $proveedor->persona_contacto }}</td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.proveedores.show', $proveedor) }}"
                                class="btn btn-green mr-2">Consultar</flux:button>
                            <flux:button variant="primary" href="{{ route('admin.proveedores.edit', $proveedor) }}"
                                class="btn btn-blue">Editar</flux:button>
                            <form class="delete-form" action="{{ route('admin.proveedores.destroy', $proveedor) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
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