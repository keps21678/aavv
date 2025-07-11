<x-layouts.app :title="__('Lista de Proveedores')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Providers') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @hasrole('admin')
        <flux:button href="{{ route('admin.proveedores.create') }}" class="btn btn-green">
            {{ __('New Provider') }}
        </flux:button>
        @endhasrole
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">{{ __('VAT') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Name') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Phone') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Email') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Contact Person') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Associated Expenses') }}</th>
                    @hasanyrole('admin|editor|viewer')
                    <th scope="col" class="px-2 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
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
                    <td class="px-2 py-4 text-center">{{ $proveedor->gastos_count }}</td>
                    @hasanyrole('admin|editor|viewer')
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right"
                                href="{{ route('admin.proveedores.show', $proveedor) }}" class="btn btn-green mr-2">{{
                                __('Consult') }}</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.proveedores.edit', $proveedor) }}"
                                class="btn btn-blue">{{ __('Edit') }}</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.proveedores.destroy', $proveedor) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
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
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Traducción al español
                },
            });
        });
        // Confirmación de eliminación con SweetAlert2
            document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: {!! json_encode(__('Are you sure?')) !!},
                        text: {!! json_encode(__('You won\'t be able to revert this!')) !!},
                        icon: 'warning',showCancelButton: true,                        
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: {!! json_encode(__('Yes, delete it!')) !!},
                        cancelButtonText: {!! json_encode(__('Cancel')) !!}
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