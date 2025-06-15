<x-layouts.app :title="__('Lista de Gastos')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Gastos') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.gastos.create') }}" class="btn btn-green">
            {{ __('New Expense') }}
        </flux:button>
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
                    <th scope="col" class="px-2 py-3">{{ __('State') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Amount') }}</th>                    
                    <th scope="col" class="px-2 py-3">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gastos as $gasto)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-2 py-4">{{ $gasto->numero }}</td>
                    <td class="px-2 py-4">{{ $gasto->proveedor->nombre }}</td>                    
                    <td class="px-2 py-4">{{ $gasto->descripcion }}</td>
                    <td class="px-2 py-4">{{ $gasto->fecha_emision->format('d/m/Y') }}</td>
                    <td class="px-2 py-4">{{ $gasto->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td class="px-2 py-4">
                        <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $gasto->estado->color }}">
                            {{ $gasto->estado->nombre }}
                        </span>
                    </td>
                    <td class="px-2 py-4 whitespace-nowrap">{{ number_format($gasto->importe, 2) }} €</td>                    
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.gastos.show', $gasto) }}"
                                class="btn btn-green mr-2">Consultar</flux:button>
                            @hasanyrole('admin|editor')
                            <flux:button variant="primary" href="{{ route('admin.gastos.edit', $gasto) }}"
                                class="btn btn-blue">Editar</flux:button>
                            @endhasanyrole
                            @hasrole('admin')
                            <form class="delete-form" action="{{ route('admin.gastos.destroy', $gasto) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
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