<x-layouts.app :title="__('Nuevo Socio')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Members') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('New Member') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Member List') }}
            </flux:button>
        </div>
    </div>
    <div class="rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('New Member')" :description="__('Enter the details to create the member')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.store') }}" method="POST">
                @csrf
                <!-- Contenedor de tres columnas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-2">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="nsocio" label="Nº Socio" placeholder="Número de socio"
                            :value="old('nsocio', $socio->nsocio ?? '')" required />
                        <flux:input wire:model="nombre" label="Nombre" placeholder="Escriba el nombre"
                            :value="old('nombre', $socio->nombre ?? '')" required />
                        <flux:input wire:model="apellidos" label="Apellidos" placeholder="Escriba los apellidos"
                            :value="old('apellidos', $socio->apellidos ?? '')" required />
                        <flux:input wire:model="dni" label="DNI" placeholder="Escriba el DNI"
                            :value="old('dni', $socio->dni ?? '')" required />
                        <flux:input wire:model="telefono" label="Teléfono" placeholder="Escriba el teléfono"
                            :value="old('telefono', $socio->telefono ?? '')" />
                        <flux:input wire:model="movil" label="Móvil" placeholder="Escriba el móvil"
                            :value="old('movil', $socio->movil ?? '')" />
                        <flux:input wire:model="email" label="Correo Electrónico"
                            placeholder="Escriba el correo electrónico" :value="old('email', $socio->email ?? '')" />
                    </div>

                    <!-- Segunda columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="calle" label="Calle" placeholder="Escriba la calle"
                            :value="old('calle', $socio->calle ?? '')" />
                        <flux:input wire:model="portal" label="Portal" placeholder="Escriba el portal"
                            :value="old('portal', $socio->portal ?? '')" />
                        <flux:input wire:model="piso" label="Piso" placeholder="Escriba el piso"
                            :value="old('piso', $socio->piso ?? '')" />
                        <flux:input wire:model="letra" label="Letra" placeholder="Escriba la letra"
                            :value="old('letra', $socio->letra ?? '')" />
                        <flux:input wire:model="codigo_postal" label="Código Postal"
                            placeholder="Escriba el código postal"
                            :value="old('codigo_postal', $socio->codigo_postal ?? '')" />
                        <flux:input wire:model="poblacion" label="Población" placeholder="Escriba la población"
                            :value="old('poblacion', $socio->poblacion ?? '')" />
                        <flux:input wire:model="provincia" label="Provincia" placeholder="Escriba la provincia"
                            :value="old('provincia', $socio->provincia ?? '')" />
                    </div>

                    <!-- Tercera columna -->
                    <div class="flex flex-col gap-6">
                        <!-- Tipo de Socio -->
                        <flux:select wire:model="tsocio_id" label="Tipo Socio" name="tsocio_id" id="tsocio_id" required>
                            <option value="" disabled>Seleccionar el tipo Socio/a</option>
                            @foreach ($tsocios as $tsocio)
                            <option value="{{ $tsocio->id }}" {{ $socio->tsocio_id == $tsocio->id ? 'selected' : '' }}>
                                {{ $tsocio->nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                        <!-- Cuota -->
                        <flux:select wire:model="cuotas_id" label="Cuota" name="cuota_id" id="cuota_id" required>
                            <option value="" disabled selected>Seleccionar cuota</option>
                            @foreach ($cuotas as $cuota)
                            <option value="{{ $cuota->id }}" {{ $socio->cuota_id == $cuota->id ? 'selected' : '' }}>
                                {{ $cuota->cantidad }} € / {{ $cuota->anyo }}
                            </option>
                            @endforeach
                        </flux:select>
                        <!-- Empresa -->
                        <div class="flex items-center">
                            <input type="checkbox" id="empresa" name="empresa" value="1" {{ old('empresa',
                                $socio->empresa ?? false) ? 'checked' : '' }} class="form-checkbox h-5 w-5">
                            <label for="empresa" class="ml-2">{{ __('Empresa') }}</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="baja" name="baja" value="1" {{ old('baja', $socio->baja ?? false)
                            ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5">
                            <label for="baja" class="ml-2">{{ __('Baja') }}</label>
                        </div>

                        <div class="">
                            <div
                                x-data="{ showIBAN: {{ old('domiciliacion', $proveedor->domiciliacion ?? false) ? 'true' : 'false' }} }">
                                <div class="flex items-center">
                                    <input type="checkbox" id="domiciliacion" name="domiciliacion" value="1" {{
                                        old('domiciliacion', $proveedor->domiciliacion ?? false) ? 'checked' : '' }}
                                    class="form-checkbox h-5 w-5" @change="showIBAN = $event.target.checked">
                                    <label for="domiciliacion" class="ml-2">Domiciliación</label>
                                </div>
                                <template x-if="showIBAN">
                                    <div class="flex flex-col gap-6 mt-4">
                                        <flux:input variant="filled" label="IBAN" placeholder="IBAN de la cuenta"
                                            :value="old('iban', $proveedor->iban ?? '')" />
                                        <flux:input variant="filled" label="Titular de la cuenta"
                                            placeholder="Nombre y apellidos del titular"
                                            :value="old('titular', $proveedor->titular ?? '')" />
                                        <flux:input variant="filled" label="DNI del titular de la cuenta"
                                            placeholder="DNI del titular"
                                            :value="old('dni_titular', $proveedor->dni_titular ?? '')" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
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