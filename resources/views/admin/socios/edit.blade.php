<x-layouts.app :title="__('Editar socio/a')">
    <div class="flex items-center justify-between mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios/as') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Socio/a') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.socios.create') }}"
                class="btn btn-green text-white font-bold py-2 px-4 rounded text-xs">{{ __('New Member') }}
            </flux:button>
            <flux:button href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Member List') }}
            </flux:button>
        </div>
    </div>

    <div class="rounded overflow-hidden shadow-lg">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Editar la cuenta del socio/a: ' . $socio->nombre . ' ' . $socio->apellidos)"
                :description="__('Introduce las modificaciones de la cuenta')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.socios.update', $socio) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Contenedor de tres columnas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
                    <!-- Primera columna -->
                    <div class="flex flex-col gap-6">
                        <flux:input wire:model="nsocio" label="Número de Socio" placeholder="Escriba el número de socio"
                            :value="old('nsocio', $socio->nsocio)" />
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="empresa" name="empresa" value="1" {{ old('empresa',
                                    $socio->empresa) ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5">
                                <label for="empresa" class="ml-2">Empresa</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="baja" name="baja" value="1" {{ old('baja', $socio->baja) ?
                                'checked' : '' }}
                                class="form-checkbox h-5 w-5" >
                                <label for="baja" class="ml-2">Baja</label>
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
                <div class="">
                    <div x-data="{ showIBAN: {{ old('domiciliacion', $socio->domiciliacion) ? 'true' : 'false' }} }">
                        <div class="flex items-center">
                            <input type="checkbox" id="domiciliacion" name="domiciliacion" value="1" {{
                                old('domiciliacion', $socio->domiciliacion) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5" @change="showIBAN = $event.target.checked">
                            <label for="domiciliacion" class="ml-2">Domiciliación</label>
                        </div>
                        <template x-if="showIBAN">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-2">
                                <flux:input variant="filled" label="IBAN" placeholder="IBAN de la cuenta"
                                    type='password' :value="old('iban', $socio->iban)" viewable />
                                <flux:input variant="filled" label="Titular de la cuenta"
                                    placeholder="Nombre y apellidos del titular"
                                    :value="old('titular', $socio->titular)" />
                                <flux:input variant="filled" label="DNI del titular de la cuenta"
                                    placeholder="dni_titular" :value="old('dni_titular', $socio->dni_titular)" />
                            </div>
                        </template>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-2">
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
                </div>
                <!-- Botón de envío -->
                <div class="flex justify-end mt-6 mb-4">
                    <!-- Incidencias -->
                    @if ($socio->incidencias_count > 0)
                    <flux:button variant="outline" label="Incidencias"
                        href="{{ route('admin.incidencias.index', ['socio_id' => $socio->id]) }}"
                        class="btn btn-green-dark text-white font-bold py-1 px-3 rounded mr-2">
                        {{ $socio->incidencias_count }}&nbsp;&nbsp;Incidencia/s
                    </flux:button>
                    @else
                    <flux:button variant="filled"
                        href="{{ route('admin.incidencias.create', ['socio_id' => $socio->id]) }}"
                        class="btn btn-yellow text-white font-bold py-1 px-3 rounded mr-2">
                        {{ __('Open Incident') }}
                    </flux:button>
                    @endif
                    <!-- Documentos LOPD -->
                    @if ($socio->lopds_count > 0)
                    <flux:button label="Documentos LOPD"
                        href="{{ route('admin.lopd.index', ['socio_id' => $socio->id]) }}"
                        class="btn btn-green-dark text-white font-bold py-1 px-3 rounded mr-2">
                        {{ $socio->lopds_count }}&nbsp;&nbsp;Documento/s
                    </flux:button>
                    @else
                    <flux:button href="{{ route('admin.lopd.create', ['socio_id' => $socio->id]) }}"
                        class="btn btn-yellow text-white font-bold py-1 px-3 rounded mr-2">
                        Subir Documento
                    </flux:button>
                    @endif
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
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