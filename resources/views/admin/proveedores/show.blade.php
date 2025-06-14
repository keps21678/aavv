<x-layouts.app :title="__('Detalles del Proveedor')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.proveedores.index')">{{ __('Providers') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Provider Details') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.proveedores.index') }}" class="btn btn-green-dark">{{ __('Back to List') }}</a>
    </div>
    <div class="rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800">
        <div class="px-6 py-4">
            <h1 class="font-bold text-xl mb-4">{{ __('Provider Details') }}: {{ $proveedor->nombre }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna 1 -->
                <div>
                    <div class="mb-4">
                        <strong>NIF:</strong>
                        <span>{{ $proveedor->nif }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Nombre:</strong>
                        <span>{{ $proveedor->nombre }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Teléfono:</strong>
                        <span>{{ $proveedor->telefono }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Email:</strong>
                        <span>{{ $proveedor->email }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Persona de Contacto:</strong>
                        <span>{{ $proveedor->persona_contacto }}</span>
                    </div>
                </div>
                <!-- Columna 2 -->
                <div>
                    <div class="mb-4">
                        <strong>Calle:</strong>
                        <span>{{ $proveedor->calle }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Portal:</strong>
                        <span>{{ $proveedor->portal }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Piso:</strong>
                        <span>{{ $proveedor->piso }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Letra:</strong>
                        <span>{{ $proveedor->letra }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Código Postal:</strong>
                        <span>{{ $proveedor->codigo_postal }}</span>
                    </div>
                </div>
                <!-- Columna 3 -->
                <div>
                    <div class="mb-4">
                        <strong>Población:</strong>
                        <span>{{ $proveedor->poblacion }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Provincia:</strong>
                        <span>{{ $proveedor->provincia }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Domiciliación:</strong>
                        <span>{{ $proveedor->domiciliacion ? 'Sí' : 'No' }}</span>
                        @if ($proveedor->domiciliacion)
                        <br />
                        <flux:modal.trigger name="edit-profile" class="ml-2">
                            <flux:button icon:trailing="eye" variant="outline">
                                Ver IBAN
                            </flux:button>
                        </flux:modal.trigger>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Gastos relacionados -->
            <div class="mt-8">
                <strong>Gastos relacionados:</strong>
                @if ($proveedor->gastos->isEmpty())
                <p class="mt-2">No hay gastos relacionados con este proveedor.</p>
                @else
                <table class="table-fixed w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2"
                    id="tabla">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2">Número</th>
                            <th class="px-4 py-2">Fecha Emisión</th>
                            <th class="px-4 py-2">Fecha Vencimiento</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Importe</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedor->gastos as $gasto)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2">{{ $gasto->numero }}</td>
                            <td class="px-4 py-2">{{ $gasto->fecha_emision->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $gasto->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $gasto->descripcion }}</td>
                            <td class="px-2 py-4">
                                <span class="px-2 py-1 rounded-full text-sm text-white"
                                    style="background-color: {{ $gasto->estado->color }}">
                                    {{ $gasto->estado->nombre }}
                                </span>
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">{{ number_format($gasto->importe, 2) }} €</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-end space-x-2">
                                    <flux:button icon:trailing="arrow-up-right"
                                        href="{{ route('admin.gastos.show', $gasto) }}" class="btn btn-green mr-2">
                                        Consultar</flux:button>
                                    <flux:button variant="primary" href="{{ route('admin.gastos.edit', $gasto) }}"
                                        class="btn btn-blue">
                                        Editar</flux:button>
                                    <form class="delete-form" action="{{ route('admin.gastos.destroy', $gasto) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button wire:click="delete" variant="danger" type="submit"
                                            class="btn btn-danger">
                                            Eliminar
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="btn btn-blue">Editar</a>
                <a href="{{ route('admin.proveedores.index') }}" class="btn btn-green-dark">Volver</a>
            </div>
        </div>
    </div>

    <flux:modal name="edit-profile" class="w-1/3 md:w-1/3">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">IBAN</flux:heading>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <flux:input class="mb-2" readonly variant="filled" label="IBAN" placeholder="IBAN del proveedor"
                    :value="$proveedor->iban" />
                <flux:input class="mb-2" readonly variant="filled" label="Titular de la cuenta" placeholder="Titular"
                    :value="$proveedor->titular" />
                <flux:input class="mb-2" readonly variant="filled" label="DNI del Titular" placeholder="DNI"
                    :value="$proveedor->dni_titular" />
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button icon="clipboard" variant="outline"
                    @click="navigator.clipboard.writeText('{{ $proveedor->iban }}')">
                    Copiar IBAN
                </flux:button>
            </div>
        </div>
    </flux:modal>

    @push('js')
    <script>
        $(document).ready(function () {
            $('#tabla').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
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