<x-layouts.app :title="__('Nuevo Proveedor')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.proveedores.index')">{{ __('Providers') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('New Provider') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.proveedores.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Provider List') }}</flux:button>
        </div>
    </div>
    <div class="rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('New Provider')" :description="__('Enter the details to create the provider')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.proveedores.store') }}" method="POST">
                @csrf
                <!-- Contenedor de tres columnas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-2">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="nif" label="NIF" placeholder="Escriba el NIF"
                            :value="old('nif', $proveedor->nif ?? '')" required />
                        <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                            :value="old('nombre', $proveedor->nombre ?? '')" required />
                        <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                            :value="old('telefono', $proveedor->telefono ?? '')" />
                        <flux:input wire:model="email" label="Correo Electrónico" placeholder="Escriba el correo electrónico"
                            :value="old('email', $proveedor->email ?? '')" />
                    </div>

                    <!-- Segunda columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                            :value="old('calle', $proveedor->calle ?? '')" />
                        <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                            :value="old('portal', $proveedor->portal ?? '')" />
                        <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                            :value="old('piso', $proveedor->piso ?? '')" />
                        <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                            :value="old('letra', $proveedor->letra ?? '')" />
                        <flux:input wire:model="codigo_postal" label="Código Postal" placeholder="Escriba el código postal"
                            :value="old('codigo_postal', $proveedor->codigo_postal ?? '')" />
                    </div>

                    <!-- Tercera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                            :value="old('poblacion', $proveedor->poblacion ?? '')" />
                        <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                            :value="old('provincia', $proveedor->provincia ?? '')" />
                        <flux:input wire:model="persona_contacto" label="Persona de Contacto"
                            placeholder="Escriba el nombre de la persona de contacto"
                            :value="old('persona_contacto', $proveedor->persona_contacto ?? '')" />
                    </div>
                </div>
        </div>
        <div class="ms-4">
            <div x-data="{ showIBAN: {{ old('domiciliacion', $proveedor->domiciliacion ?? false) ? 'true' : 'false' }} }">
                <div class="flex items-center">
                    <input type="checkbox" id="domiciliacion" name="domiciliacion" value="1"
                        {{ old('domiciliacion', $proveedor->domiciliacion ?? false) ? 'checked' : '' }}
                        class="form-checkbox h-5 w-5" @change="showIBAN = $event.target.checked">
                    <label for="domiciliacion" class="ml-2">Domiciliación</label>
                </div>
                <template x-if="showIBAN">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-2">
                        <flux:input variant="filled" label="IBAN" placeholder="IBAN de la cuenta"
                            :value="old('iban', $proveedor->iban ?? '')" />
                        <flux:input variant="filled" label="Titular de la cuenta"
                            placeholder="Nombre y apellidos del titular"
                            :value="old('titular', $proveedor->titular ?? '')" />
                        <flux:input variant="filled" label="DNI del titular de la cuenta" placeholder="DNI del titular"
                            :value="old('dni_titular', $proveedor->dni_titular ?? '')" />
                    </div>
                </template>
            </div>
        </div>
        <!-- Botón de envío -->
        <div class="flex justify-end mt-6">
            <flux:button type="submit" variant="primary" class="btn btn-blue mb-4 me-4">{{ __('Save') }}</flux:button>
        </div>
        </form>
    </div>
    </div>
</x-layouts.app>