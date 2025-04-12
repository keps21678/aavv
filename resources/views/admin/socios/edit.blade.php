<x-layouts.app :title="__('Editar socio/a')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios/as') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.socios.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">Nuevo/a Socio/a</a>
            <a href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">Listado de Socios</a>
        </div>
    </div> 

    <div class="mx-auto rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <h1 class="font-bold text-xl mb-6">Edición de Socio/a</h1>
            <form action="{{ route('admin.socios.update', $socio) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Campos organizados en varias columnas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex w-full max-w-sm flex-col gap-2">
                        <div class="mb-4">
                            <flux:input wire:model="nsocio" label="Número de Socio"
                                placeholder="Escriba el número de socio" :value="old('nsocio', $socio->nsocio)"
                                required />
                        </div>
                        <div class="mb-4">
                            <flux:checkbox wire:model="empresa" label="Empresa"
                                :checked="old('empresa', $socio->empresa)" />
                        </div>
                    </div>
                    <div class="flex w-full max-w-sm flex-col gap-2">
                        <div class="mb-4">
                            <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                                :value="old('nombre', $socio->nombre)" required />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                                :value="old('apellidos', $socio->apellidos)" required />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="dni" label="DNI" placeholder="Escriba el DNI"
                                :value="old('dni', $socio->dni)" required />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                                :value="old('telefono', $socio->telefono)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="movil" label="Móvil" placeholder="Escriba el móvil"
                                :value="old('movil', $socio->movil)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="email" label="Correo Electrónico"
                                placeholder="Escriba el correo electrónico" :value="old('email', $socio->email)" />
                        </div>
                    </div>
                    <div class="flex w-full max-w-sm flex-col gap-2">
                        <div class="mb-4">
                            <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                                :value="old('calle', $socio->calle)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                                :value="old('portal', $socio->portal)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                                :value="old('piso', $socio->piso)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                                :value="old('letra', $socio->letra)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="codigo_postal" label="Código Postal"
                                placeholder="Escriba el código postal"
                                :value="old('codigo_postal', $socio->codigo_postal)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                                :value="old('poblacion', $socio->poblacion)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                                :value="old('provincia', $socio->provincia)" />
                        </div>
                    </div>
                    <div class="flex w-full max-w-sm flex-col gap-2">
                        <div class="mb-4">
                            <flux:input wire:model="persona_contacto" label="Persona de Contacto"
                                placeholder="Escriba la persona de contacto"
                                :value="old('persona_contacto', $socio->persona_contacto)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="domiciliacion" label="Domiciliación"
                                placeholder="Escriba si tiene domiciliación"
                                :value="old('domiciliacion', $socio->domiciliacion)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="iban" label="IBAN" placeholder="Escriba el IBAN"
                                :value="old('iban', $socio->iban)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="tsocio_id" label="Tipo de Socio"
                                placeholder="Escriba el tipo de socio" :value="old('tsocio_id', $socio->tsocio_id)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="cuota_id" label="Cuota" placeholder="Escriba la cuota"
                                :value="old('cuota_id', $socio->cuota_id)" />
                        </div>
                        <div class="mb-4">
                            <flux:input wire:model="baja" label="Baja" placeholder="Escriba si está dado de baja"
                                :value="old('baja', $socio->baja)" />
                        </div>
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
