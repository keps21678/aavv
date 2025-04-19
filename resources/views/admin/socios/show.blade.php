<x-layouts.app :title="__('Detalles del Socio')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Socio') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.socios.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="max-w-4xl mx-auto rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
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
                            class="col" disabled/>
                        <flux:checkbox wire:model="baja" label="Baja" :checked="old('baja', $socio->baja)"
                            class="col" disabled/>
                        <flux:checkbox wire:model="domiciliacion" label="Domiciliación"
                            :checked="old('domiciliacion', $socio->domiciliacion)" class="col" disabled/>
                        @if ($socio->domiciliacion)
                            <flux:modal.trigger name="edit-profile" class="place-items-stretch">
                                <flux:button icon:trailing="eye" variant="outline" class="col-span-3">
                                    Ver IBAN
                                </flux:button>
                            </flux:modal.trigger>
                        @endif
                    </div>
                    <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                        :value="old('nombre', $socio->nombre)" disabled />
                    <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                        :value="old('apellidos', $socio->apellidos)" disabled />
                    <flux:input wire:model="dni" label="DNI" placeholder="Escriba el DNI"
                        :value="old('dni', $socio->dni)" disabled />
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
                        :value="old('letra', $socio->letra)" />
                    <flux:input wire:model="codigo_postal" label="Código Postal" placeholder="Escriba el código postal"
                        :value="old('codigo_postal', $socio->codigo_postal)" disabled />
                    <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                        :value="old('poblacion', $socio->poblacion)" disabled />
                    <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                        :value="old('provincia', $socio->provincia)" disabled />
                </div>
            </div>
            <!-- Incidencias relacionadas -->
            <div class="mt-8">
                @if ($socio->incidencias->isEmpty())
                <p class="">No hay incidencias relacionadas con este socio.</p>
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
                            <th class="px-4 py-2" hidden>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socio->incidencias as $incidencia)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2" hidden>{{ $incidencia->id }}</td>
                            <td class="px-4 py-2 w-1/4">{{ $incidencia->fecha_incidencia }}</td>
                            <td class="px-4 py-2">{{ $incidencia->descripcion }}</td>
                            <td class="px-4 py-2" hidden>{{ $incidencia->estado }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">IBAN</flux:heading>     
            </div>
            <flux:input readonly variant="filled" label="IBAN" placeholder="IBAN del socio" :value="$socio->iban" />
            <div class="flex">
                <flux:spacer />
                <flux:button icon="clipboard" variant="outline" @click="navigator.clipboard.writeText('{{ $socio->iban }}')">
                   Copiar IBAN
                </flux:button>
            </div>
        </div>
    </flux:modal>    
</x-layouts.app>