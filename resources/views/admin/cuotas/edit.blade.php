<x-layouts.app :title="__('Editar Cuota')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tincidencias.index')">{{ __('Cuotas') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Editar Cuota') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        {{-- <bootstrap:button variant="primary" href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            Create Category</bootstrap:button> --}}
        <div>
            <a href="{{ route('admin.cuotas.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">
                Listado de Cuotas</a>
            <a href="{{ route('admin.cuotas.create') }}"
                class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
                Nueva Cuota</a>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">Edición de Cuota</h1>
            <form action="{{ route('admin.cuotas.update', $cuota) }}" method="POST">
                @csrf
                @method('PUT')

                <div class='mb-4'>
                    <flux:select label="Tipo Cuota/Socio" name="tsocio_id" id="tsocio_id" required>
                        <option value="" disabled {{ !$cuota->tsocio_id ? 'selected' : '' }}>Seleccionar el Tipo
                            Cuota/Socio</option>
                        @foreach ($tsocios as $tsocio)
                            <option value="{{ $tsocio->id }}"
                                {{ $cuota->tsocio_id == $tsocio->id ? 'selected' : '' }}>
                                {{ $tsocio->nombre }} {{ $cuota->tsocio_id == $tsocio->id ? '(Actual)' : '' }}
                            </option>
                        @endforeach
                    </flux:select>
                </div>

                <div class='mb-4'>
                    <flux:input label="Año de aplicación de la cuota" placeholder="2025" type="number" step="1"
                        name="anyo" value="{{ old('anyo', $cuota->anyo) }}" required />
                </div>

                <div class='mb-4'>
                    <flux:input label="Cantidad de la cuota" placeholder="0.00€" type="number" step="0.5"
                        name="cantidad" value="{{ old('cantidad', $cuota->cantidad) }}" required />
                </div>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">Guardar cambios</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
