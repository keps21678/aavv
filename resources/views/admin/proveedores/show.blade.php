<x-layouts.app :title="__('Detalles del Proveedor')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.proveedores.index')">{{ __('Proveedores') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Proveedor') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.proveedores.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Detalles del proveedor: ' . $proveedor->nombre)"
                :description="__('Datos del proveedor')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de tres columnas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="nif" label="NIF" placeholder="Escriba el NIF"
                        :value="old('nif', $proveedor->nif)" disabled />
                    <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                        :value="old('nombre', $proveedor->nombre)" disabled />
                    <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                        :value="old('telefono', $proveedor->telefono)" disabled />
                    <flux:input wire:model="email" label="Correo Electrónico"
                        placeholder="Escriba el correo electrónico" :value="old('email', $proveedor->email)" disabled />
                    <flux:input wire:model="persona_contacto" label="Persona de Contacto"
                        placeholder="Escriba el nombre de la persona de contacto"
                        :value="old('persona_contacto', $proveedor->persona_contacto)" disabled />
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                        :value="old('calle', $proveedor->calle)" disabled />
                    <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                        :value="old('portal', $proveedor->portal)" disabled />
                    <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                        :value="old('piso', $proveedor->piso)" disabled />
                    <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                        :value="old('letra', $proveedor->letra)" disabled />
                    <flux:input wire:model="codigo_postal" label="Código Postal" placeholder="Escriba el código postal"
                        :value="old('codigo_postal', $proveedor->codigo_postal)" disabled />
                </div>

                <!-- Tercera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                        :value="old('poblacion', $proveedor->poblacion)" disabled />
                    <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                        :value="old('provincia', $proveedor->provincia)" disabled />
                    <flux:checkbox wire:model="domiciliacion" label="Domiciliación"
                        :checked="old('domiciliacion', $proveedor->domiciliacion)" class="col" disabled />
                    @if ($proveedor->domiciliacion)
                    <flux:modal.trigger name="edit-profile" class="place-items-stretch">
                        <flux:button icon:trailing="eye" variant="outline" class="col">
                            Ver IBAN
                        </flux:button>
                    </flux:modal.trigger>
                    @endif
                </div>
            </div>

            <!-- gastos relacionadas -->
            <div class="mt-4">
                @if ($proveedor->gastos->isEmpty())
                <p class="">No hay gastos relacionadas con este proveedor.</p>
                @else
                <div class="relative overflow-x-auto">
                    <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-2">Número</th>
                                <th class="px-4 py-2">Fecha Emisión</th>
                                <th class="px-4 py-2">Fecha Vencimiento</th>
                                <th class="px-4 py-2">Descripción</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2">Importe</th>                                
                                <th class="px-4 py-2">Acciones</th> <!-- Nueva columna -->
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
                                    <span class="px-2 py-1 rounded-full text-sm text-white" style="background-color: {{ $gasto->estado->color }}">
                                        {{ $gasto->estado->nombre }}
                                    </span>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap">{{ number_format($gasto->importe, 2) }} €</td>                                
                                <td class="px-4 py-2">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Botón Consultar -->
                                        <flux:button icon:trailing="arrow-up-right"
                                            href="{{ route('admin.gastos.show', $gasto) }}"
                                            class="btn btn-green mr-2">Consultar</flux:button>
                                        <!-- Botón Editar -->
                                        <flux:button variant="primary"
                                            href="{{ route('admin.gastos.edit', $gasto) }}" class="btn btn-blue">
                                            Editar</flux:button>
                                        <!-- Botón Eliminar -->
                                        <form class="delete-form"
                                            action="{{ route('admin.gastos.destroy', $gasto) }}" method="POST">
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
                </div>
                @endif
            </div>
        </div>
    </div>

    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">IBAN</flux:heading>
            </div>
            <div class="container">
                <div class="columns-3 gap-6 mb-6">
                    <flux:input class="mb-2" readonly variant="filled" label="IBAN" placeholder="IBAN del proveedor"
                        :value="$proveedor->iban" />
                    <flux:input class="mb-2" readonly variant="filled" label="Titular de la cuenta"
                        placeholder="Titular" :value="$proveedor->titular" />
                    <flux:input class="mb-2" readonly variant="filled" label="DNI del Titular" placeholder="DNI"
                        :value="$proveedor->dni_titular" />
                </div>
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