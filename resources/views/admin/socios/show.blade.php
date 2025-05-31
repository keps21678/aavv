<x-layouts.app :title="__('Detalles del Socio/a')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Socio') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.socios.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-2">
            <x-auth-header :title="__('Detalles del socio/a: ' . $socio->nombre . ' ' . $socio->apellidos)"
                :description="__('Datos de la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <!-- Contenedor de tres columnas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Primera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="nsocio" label="Número de Socio" placeholder="Escriba el número de socio"
                        :value="old('nsocio', $socio->nsocio)" disabled />
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <flux:checkbox wire:model="empresa" label="Empresa" :checked="old('empresa', $socio->empresa)"
                            class="col" disabled />
                        <flux:checkbox wire:model="baja" label="Baja" :checked="old('baja', $socio->baja)" class="col"
                            disabled />
                    </div>
                    <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                        :value="old('nombre', $socio->nombre)" disabled />
                    <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                        :value="old('apellidos', $socio->apellidos)" disabled />
                    <flux:input wire:model="dni" label="DNI" placeholder="Escriba el DNI"
                        :value="old('dni', $socio->dni)" disabled />
                    <flux:checkbox wire:model="domiciliacion" label="Domiciliación"
                        :checked="old('domiciliacion', $socio->domiciliacion)" class="col" disabled />
                    @if ($socio->domiciliacion)
                    <flux:modal.trigger name="edit-profile" class="place-items-stretch">
                        <flux:button icon:trailing="eye" variant="outline" class="col">
                            Ver IBAN
                        </flux:button>
                    </flux:modal.trigger>
                    @endif
                </div>

                <!-- Segunda columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                        :value="old('telefono', $socio->telefono)" disabled />
                    <flux:input wire:model="movil" label="Móvil" placeholder="Escriba el móvil"
                        :value="old('movil', $socio->movil)" disabled />
                    <flux:input wire:model="email" label="Correo Electrónico"
                        placeholder="Escriba el correo electrónico" :value="old('email', $socio->email)" disabled />
                    <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                        :value="old('calle', $socio->calle)" disabled />
                    <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                        :value="old('portal', $socio->portal)" disabled />
                </div>

                <!-- Tercera columna -->
                <div class="flex flex-col gap-6">
                    <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                        :value="old('piso', $socio->piso)" disabled />
                    <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                        :value="old('letra', $socio->letra)" disabled />
                    <flux:input wire:model="codigo_postal" label="Código Postal" placeholder="Escriba el código postal"
                        :value="old('codigo_postal', $socio->codigo_postal)" disabled />
                    <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                        :value="old('poblacion', $socio->poblacion)" disabled />
                    <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                        :value="old('provincia', $socio->provincia)" disabled />
                </div>
            </div>

            <!-- Incidencias relacionadas -->
            <div class="">
                @if ($socio->incidencias->isEmpty())
                <p class="">No hay incidencias relacionadas con este socio/a.</p>
                @else
                <table class="table-fixed w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="caption-top">
                        Incidencias/Observaciones relacionadas
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2" hidden>ID</th>
                            <th class="px-4 py-2 w-1/4">Fecha</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Añadido/Modificado el</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socio->incidencias as $incidencia)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2" hidden>{{ $incidencia->id }}</td>
                            <td class="px-4 py-2 w-1/4">{{ $incidencia->fecha_incidencia ?
                                $incidencia->fecha_incidencia->format('Y/m/d') : 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $incidencia->descripcion }}</td>
                            <td class="px-4 py-2">{{ $incidencia->updated_at ? $incidencia->updated_at->format('Y/m/d')
                                : 'N/A' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-end space-x-2">
                                    <flux:button variant="primary"
                                        href="{{ route('admin.incidencias.edit', $incidencia) }}" class="btn btn-blue">
                                        Editar
                                    </flux:button>

                                    <form class="delete-form"
                                        action="{{ route('admin.incidencias.destroy', $incidencia) }}" method="POST">
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
                @endif
            </div>

            <!-- Documentos LOPD asociados -->
            <div class="">
                @if ($socio->lopds && $socio->lopds->isNotEmpty())
                <table class="table-fixed w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="caption-top">
                        Documentos LOPD asociados
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2">Categoría</th>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Fecha Firma</th>
                            <th class="px-4 py-2">Archivo</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Observaciones</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socio->lopds as $lopd)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2">{{ $lopd->categoria->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $lopd->descripcion }}</td>
                            <td class="px-4 py-2">{{ $lopd->fecha_firma ? $lopd->fecha_firma->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                               {{ $lopd->nombre_archivo ?? '-' }}
                            </td>
                            <td class="px-4 py-2">{{ $lopd->estado->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $lopd->observaciones }}</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-end space-x-2">
                                    <flux:button icon:trailing="arrow-up-right"
                                        href="{{ route('admin.lopd.show', $lopd) }}" class="btn btn-green">Consultar
                                    </flux:button>
                                    <flux:button variant="primary" href="{{ route('admin.lopd.edit', $lopd) }}"
                                        class="btn btn-blue">Editar</flux:button>
                                    <form class="delete-form" action="{{ route('admin.lopd.destroy', $lopd) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button variant="danger" type="submit" class="btn btn-danger">
                                            Eliminar
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="">No hay documentos LOPD enlazados a este socio/a.</p>
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
                    <flux:input class="mb-2" readonly variant="filled" label="IBAN" placeholder="IBAN del socio"
                        :value="$socio->iban" disabled />
                    <flux:input class="mb-2" readonly variant="filled" label="Titular de la cuenta"
                        placeholder="Titular" :value="$socio->titular" disabled />
                    <flux:input class="mb-2" readonly variant="filled" label="DNI del Titular" placeholder="DNI"
                        :value="$socio->dni_titular" disabled />
                </div>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button icon="clipboard" variant="outline"
                    @click="navigator.clipboard.writeText('{{ $socio->iban }}')">
                    Copiar IBAN
                </flux:button>
            </div>
        </div>
    </flux:modal>

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