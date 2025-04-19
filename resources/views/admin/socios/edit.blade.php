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

    <div class="max-w-4xl mx-auto rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Editar la cuenta del socio/a: ' . $socio->nombre . ' ' . $socio->apellidos)"
                :description="__('Introduce laas modificaciones de la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.update', $socio) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Contenedor de tres columnas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="nsocio" label="Número de Socio" placeholder="Escriba el número de socio"
                            :value="old('nsocio', $socio->nsocio)" required />
                        <div x-data="{ showIBAN: {{ old('domiciliacion', $socio->domiciliacion) ? 'true' : 'false' }} }">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <flux:checkbox wire:model="empresa" name="empresa" label="Empresa"
                                    :checked="old('empresa', $socio->empresa)" class="col" />
                                <flux:checkbox wire:model="baja" name="baja" label="Baja"
                                    :checked="old('baja', $socio->baja)" class="col" />
                                <flux:checkbox wire:model="domiciliacion" name="domiciliacion" label="Domiciliación"
                                    :checked="old('domiciliacion', $socio->domiciliacion)" class="col"
                                    @change="showIBAN = $event.target.checked" />
                                <template x-if="showIBAN" class="mt-2">
                                    <flux:modal.trigger name="view-iban" class="place-items-end">
                                        <flux:button icon:trailing="eye" variant="outline" class="col-span-3">
                                            Ver IBAN
                                        </flux:button>
                                    </flux:modal.trigger>
                                </template>
                            </div>
                        </div>
                        <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                            :value="old('nombre', $socio->nombre)" required />
                        @error('nombre')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                            :value="old('apellidos', $socio->apellidos)" required />
                        <flux:input wire:model="dni" label="DNI" placeholder="Escriba el DNI"
                            :value="old('dni', $socio->dni)" required />
                    </div>

                    <!-- Segunda columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                            :value="old('telefono', $socio->telefono)" />
                        <flux:input wire:model="movil" label="Móvil" placeholder="Escriba el móvil"
                            :value="old('movil', $socio->movil)" />
                        <flux:input wire:model="email" label="Correo Electrónico"
                            placeholder="Escriba el correo electrónico" :value="old('email', $socio->email)" />
                        <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                            :value="old('calle', $socio->calle)" />
                        <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                            :value="old('portal', $socio->portal)" />
                    </div>

                    <!-- Tercera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                            :value="old('piso', $socio->piso)" />
                        <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                            :value="old('letra', $socio->letra)" />
                        <flux:input wire:model="codigo_postal" label="Código Postal"
                            placeholder="Escriba el código postal"
                            :value="old('codigo_postal', $socio->codigo_postal)" />
                        <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                            :value="old('poblacion', $socio->poblacion)" />
                        <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                            :value="old('provincia', $socio->provincia)" />
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="flex justify-end mt-6 mb-4">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
    <flux:modal name="view-iban" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">IBAN</flux:heading>
            </div>
            <flux:input readonly variant="filled" label="IBAN" placeholder="IBAN del socio"
                :value="$socio->iban ? $socio->iban : 'Sin IBAN definido'" />
            <div class="flex">
                <flux:spacer />
                <flux:button icon="clipboard" variant="outline"
                    @click="navigator.clipboard.writeText('{{ $socio->iban }}')">
                    Copiar IBAN
                </flux:button>
            </div>
        </div>
    </flux:modal>
</x-layouts.app>