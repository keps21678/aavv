<x-layouts.app :title="__('Lista de Socios')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Socios/as') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <flux:button href="{{ route('admin.socios.create') }}" class="btn btn-green">
            Nuevo Socio
        </flux:button>
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">Socio</th>
                    <th scope="col" class="px-2 py-3">Nombre</th>
                    <th scope="col" class="px-2 py-3">Apellidos</th>
                    <th scope="col" class="px-2 py-3">Tipo Socio</th>
                    <th scope="col" class="px-2 py-3">Email</th>
                    <th scope="col" class="px-2 py-3">Movil</th>
                    <th scope="col" class="px-2 py-3">Persona Contacto</th>
                    <th scope="col" class="px-2 py-3">Domiciliación</th> <!-- Nueva columna -->
                    <th scope="col" class="px-2 py-3">Incidencias</th>
                    <th scope="col" class="px-2 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($socios as $socio)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $socio->nsocio }}
                    </th>
                    <td class="px-2 py-4">{{ $socio->nombre }}</td>
                    <td class="px-2 py-4">{{ $socio->apellidos }}</td>
                    <td class="px-2 py-4">{{ $socio->tsocio->nombre ?? 'Sin asignar' }}</td>
                    <td class="px-2 py-4">{{ $socio->email }}</td>
                    <td class="px-2 py-4">{{ $socio->movil }}</td>
                    <td class="px-2 py-4">{{ $socio->persona_contacto }}</td>
                    <td class="px-2 py-4 text-center">
                        <!-- Checkbox para domiciliación -->
                        <input type="checkbox" disabled {{ $socio->domiciliacion ? 'checked' : '' }}
                        class="form-checkbox h-5 w-5 text-green-600">
                    </td>
                    <td class="px-2 py-4">
                        @if ($socio->incidencias_count > 0)
                        <flux:button variant="outline"
                            href="{{ route('admin.incidencias.index', ['socio_id' => $socio->id]) }}"
                            class="btn btn-green-dark text-white font-bold py-1 px-3 rounded">
                            {{ $socio->incidencias_count }}&nbsp;&nbsp;Incidencia/s
                        </flux:button>
                        @else
                        <flux:button variant="filled"
                            href="{{ route('admin.incidencias.create', ['socio_id' => $socio->id]) }}"
                            class="btn btn-yellow text-white font-bold py-1 px-3 rounded">
                            Abrir Incidencia
                        </flux:button>
                        @endif
                    </td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end space-x-2">
                            <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.socios.show', $socio) }}"
                                class="btn btn-green mr-2">Consultar</flux:button>
                            <flux:button variant="primary" href="{{ route('admin.socios.edit', $socio) }}"
                                class="btn btn-blue">Editar</flux:button>
                            <form class="delete-form" action="{{ route('admin.socios.destroy', $socio) }}"
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
        {{-- <div class="mt-2">
            {{ $socios->links() }}
        </div> --}}
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