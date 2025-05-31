<x-layouts.app :title="__('Detalles de la Categoría')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categorias.index')">{{ __('Categorías') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Detalles de la Categoría') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-green-dark">Volver al Listado</a>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Categoría: ' . ($categoria->nombre ?? ''))"
                :description="__('Datos de la categoría')" />
            <x-auth-session-status class="text-center" :status="session('status')" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Datos principales -->
                <div class="flex flex-col gap-6">
                    <flux:input label="Nombre" :value="$categoria->nombre" disabled />
                    <flux:input label="Color" :value="$categoria->color" disabled />
                </div>
                <!-- Datos adicionales -->
                <div class="flex flex-col gap-6">
                    <flux:textarea label="Descripción" :value="$categoria->descripcion" disabled />
                    <div>
                        <label class="block mb-1 font-semibold">Documentos asociados</label>
                        @if($categoria->lopds && $categoria->lopds->count())
                        <ul class="list-disc ml-5">
                            @foreach($categoria->lopds as $lopd)
                            <li>
                                {{ $lopd->descripcion }}
                                <a href="{{ route('admin.lopd.show', $lopd) }}" class="text-blue-600 underline ml-2"
                                    target="_blank">Ver</a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span>-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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