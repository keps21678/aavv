<x-layouts.app :title="__('Nuevo Socio/a')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios/as') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Crear una cuenta de Socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <a href="{{ route('admin.socios.index') }}" class="btn btn-green-dark">Listado de Socios/as</a>
        </div>
    </div>
    <div class="max-w-4xl mx-auto rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Crear una cuenta de socio/a')"
                :description="__('Introduce los detalles para crear la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.store') }}" method="POST">
                @csrf
                <!-- Contenedor de tres columnas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="nsocio" label="Número de Socio" placeholder="Escriba el número de socio"
                            :value="old('nsocio', $socio->nsocio)" required />
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <flux:checkbox wire:model="empresa" label="Empresa"
                                :checked="old('empresa', $socio->empresa)" class="col"/>
                            <flux:checkbox wire:model="baja" label="Baja" :checked="old('baja', $socio->baja)" class="col"/>
                            <flux:checkbox wire:model="domiciliacion" label="Domiciliación"
                                :checked="old('domiciliacion', $socio->domiciliacion)" class="col"/>
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
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>