<x-layouts.app :title="__('Lista de Ingresos')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Incomes') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @hasanyrole('admin|editor')
        <flux:button href="{{ route('admin.ingresos.create') }}" class="btn btn-green">
            {{ __('New Income') }}
        </flux:button>
        @endhasanyrole
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">{{ __('Number') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Provider') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Description') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Issue Date') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Due Date') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Status') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Amount') }}</th>
                    @hasanyrole('admin|editor|viewer')                    
                    <th scope="col" class="px-2 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $ingreso)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $ingreso->numero }}</td>
                    <td class="px-2 py-4">{{ $ingreso->proveedor->nombre }}</td>                    
                    <td class="px-2 py-4">{{ $ingreso->descripcion }}</td>
                    <td class="px-2 py-4">{{ $ingreso->fecha_emision->format('d/m/Y') }}</td>
                    <td class="px-2 py-4">{{ $ingreso->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td class="px-2 py-4">
                        <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $ingreso->estado->color }}">
                            {{ $ingreso->estado->nombre }}
                        </span>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">{{ number_format($ingreso->importe, 2) }} €</td>
                    @hasanyrole('admin|editor|viewer')
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.ingresos.show', $ingreso) }}"
                                class="btn btn-green mr-2">{{ __('Consult') }}</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.ingresos.edit', $ingreso) }}"
                                class="btn btn-blue">{{ __('Edit') }}</flux:button>
                            @endhasanyrole
                            @hasrole('admin')   
                            <form class="delete-form" action="{{ route('admin.ingresos.destroy', $ingreso) }}"
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