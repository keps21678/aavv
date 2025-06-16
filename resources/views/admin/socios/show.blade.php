<x-layouts.app :title="__('Detalles del Socio/a')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.socios.index')">{{ __('Socios') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles del Socio') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.socios.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Member List') }}
            </flux:button>
    </div>
    <div class="rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800">
        <div class="px-6 py-4">
            <h1 class="font-bold text-xl mb-4">Detalles del Socio/a: {{ $socio->apellidos }}, {{ $socio->nombre }}</h1>                            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna 1 -->
                <div>
                    <div class="mb-4">
                        <strong>Nº Socio:</strong>
                        <span>{{ $socio->nsocio }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Nombre:</strong>
                        <span>{{ $socio->nombre }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Apellidos:</strong>
                        <span>{{ $socio->apellidos }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>DNI:</strong>
                        <span>{{ $socio->dni }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Email:</strong>
                        <span>{{ $socio->email }}</span>
                    </div>
                </div>
                <!-- Columna 2 -->
                <div>
                    <div class="mb-4">                        
                        <flux:checkbox wire:model="empresa" label="Empresa"
                        :checked="old('empresa', $socio->empresa)" class="col" disabled />
                    </div>
                    <div class="mb-4">
                        <flux:checkbox wire:model="baja" label="Baja"
                        :checked="old('baja', $socio->baja)" class="col" disabled />
                    </div>
                    <div class="mb-4">
                        <strong>Domiciliación:</strong>
                        <span>{{ $socio->domiciliacion ? 'Sí' : 'No' }}</span>
                        @if ($socio->domiciliacion)
                        <br />
                        <flux:modal.trigger name="edit-profile" class="ml-2">
                            <flux:button icon:trailing="eye" variant="outline">
                                Ver IBAN
                            </flux:button>
                        </flux:modal.trigger>
                        @endif
                    </div>
                    <div class="mb-4">
                        <strong>Teléfono:</strong>
                        <span>{{ $socio->telefono }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Móvil:</strong>
                        <span>{{ $socio->movil }}</span>
                    </div>
                </div>
                <!-- Columna 3 -->
                <div>                    
                    <div class="mb-4">
                        <strong>Calle:</strong>
                        <span>{{ $socio->calle }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Portal:</strong>
                        <span>{{ $socio->portal }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Piso:</strong>
                        <span>{{ $socio->piso }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Letra:</strong>
                        <span>{{ $socio->letra }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Código Postal:</strong>
                        <span>{{ $socio->codigo_postal }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Población:</strong>
                        <span>{{ $socio->poblacion }}</span>
                    </div>
                    <div class="mb-4">
                        <strong>Provincia:</strong>
                        <span>{{ $socio->provincia }}</span>
                    </div>
                </div>
            </div>

            <!-- Incidencias relacionadas -->
            <div class="mt-8">                                
                @if ($socio->incidencias->isEmpty())
                <p class="mt-2">No hay incidencias relacionadas con este socio/a.</p>
                @else
                <div x-data="{ open: false }">
                    <flux:button @click="open = !open" class="mb-2" variant="outline">
                        <span x-show="open">Ocultar incidencias</span>
                        <span x-show="!open">Mostrar incidencias</span>
                    </flux:button>
                    <span class="ms-4 mt-2 inline-block">
                        {{ $socio->incidencias->count() > 0 ? $socio->incidencias->count() . ' incidencia(s) relacionada(s).' : '' }}
                    </span>
                    <div x-show="open" x-transition>
                        <table class="table-fixed w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-2" hidden>{{ __('ID') }}</th>
                                    <th class="px-4 py-2 w-1/4">{{ __('Date') }}</th>
                                    <th class="px-4 py-2">{{ __('Description') }}</th>
                                    <th class="px-4 py-2">{{ __('Added/Modified on') }}</th>
                                    @hasanyrole('admin|editor|viewer')
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                    @endhasanyrole
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
                                    @hasanyrole('admin|editor|viewer')
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end space-x-2">
                                            <flux:button icon:trailing="arrow-up-right"
                                                href="{{ route('admin.incidencias.show', $incidencia) }}"
                                                class="btn btn-green">Consultar</flux:button>
                                            @hasanyrole('admin|editor')
                                            <flux:button variant="primary"
                                                href="{{ route('admin.incidencias.edit', $incidencia) }}" class="btn btn-blue">
                                                {{ __('Edit') }}
                                            </flux:button>
                                            @endhasanyrole
                                            @hasrole('admin')
                                            <form class="delete-form"
                                                action="{{ route('admin.incidencias.destroy', $incidencia) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button variant="danger" type="submit" class="btn btn-danger">{{ __('Delete') }}
                                                </flux:button>
                                            </form>
                                            @endhasrole
                                        </div>
                                    </td>
                                    @endhasanyrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Documentos LOPD asociados -->
            <div class="mt-8">                
                @if ($socio->lopds && $socio->lopds->isNotEmpty())
                <div x-data="{ open: false }">
                    <flux:button @click="open = !open" class="mb-2" variant="outline">
                        <span x-show="open">Ocultar documentos LOPD</span>
                        <span x-show="!open">Mostrar documentos LOPD</span>
                    </flux:button>
                    <span class="ms-4 mt-2 inline-block">
                        {{ $socio->lopds->count() > 0 ? $socio->lopds->count() . ' documento(s) LOPD asociado(s).' : '' }}
                    </span>
                    <div x-show="open" x-transition>
                        <table class="table-fixed w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-2">Categoría</th>
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Fecha Firma</th>
                                    <th class="px-4 py-2">Archivo</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Observaciones</th>
                                    @hasanyrole('admin|editor|viewer')
                                    <th class="px-4 py-2">Acciones</th>
                                    @endhasanyrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socio->lopds as $lopd)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <td class="px-4 py-2">{{ $lopd->categoria->nombre ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $lopd->descripcion }}</td>
                                    <td class="px-4 py-2">{{ $lopd->fecha_firma ? $lopd->fecha_firma->format('d/m/Y') : '-' }}</td>
                                    <td class="px-4 py-2">{{ $lopd->nombre_archivo ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $lopd->estado->nombre ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $lopd->observaciones }}</td>
                                    @hasanyrole('admin|editor|viewer')
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end space-x-2">
                                            <flux:button icon:trailing="arrow-up-right"
                                                href="{{ route('admin.lopd.show', $lopd) }}" class="btn btn-green">Consultar
                                            </flux:button>
                                            @hasanyrole('admin|editor')
                                            <flux:button variant="primary" href="{{ route('admin.lopd.edit', $lopd) }}"
                                                class="btn btn-blue">Editar</flux:button>
                                            @endhasanyrole
                                            @hasrole('admin')
                                            <form class="delete-form" action="{{ route('admin.lopd.destroy', $lopd) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button variant="danger" type="submit" class="btn btn-danger">
                                                    Eliminar
                                                </flux:button>
                                            </form>
                                            @endhasrole
                                        </div>
                                    </td>
                                    @endhasanyrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                @else
                <p class="mt-2">No hay documentos LOPD enlazados a este socio/a.</p>
                @endif
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                @hasanyrole('admin|editor')
                <flux:button href="{{ route('admin.socios.edit', $socio) }}" class="btn btn-blue">
                    {{ __('Edit') }}
                </flux:button>                
                @endhasanyrole
                <flux:button href="{{ route('admin.socios.index', $socio) }}" class="btn btn-green-dark mb-4 me-4">
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>
    </div>

    <flux:modal name="edit-profile" class="w-1/3 md:w-1/3">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">IBAN</flux:heading>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <flux:input class="mb-2" readonly variant="filled" label="IBAN" placeholder="IBAN del socio"
                    :value="$socio->iban" disabled />
                <flux:input class="mb-2" readonly variant="filled" label="Titular de la cuenta" placeholder="Titular"
                    :value="$socio->titular" disabled />
                <flux:input class="mb-2" readonly variant="filled" label="DNI del Titular" placeholder="DNI"
                    :value="$socio->dni_titular" disabled />
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