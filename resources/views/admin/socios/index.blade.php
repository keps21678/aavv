<x-layouts.app :title="__('Lista de Socios')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Socios/as') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.socios.create') }}" class="btn btn-green">
            {{ __('New Member') }}
        </flux:button>
    </div>
    <div class="relative overflow-x-auto px-2">
        <hr class="solid">
        <table id="tabla" class="display text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-2 py-3">{{ __('Member Number') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Name') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Last Name') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Member Type') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Email') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Mobile') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Contact Person') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Incidents') }}</th>
                    <th scope="col" class="px-2 py-3">{{ __('Actions') }}</th>
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
                        <x-layouts.socio.actions :socio="$socio" />
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