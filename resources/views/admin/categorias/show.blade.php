<x-layouts.app :title="__('Detalles de la Categoría')">
    <div class="flex items-center justify-between mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.categorias.index')">{{ __('Categories') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Category Details') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('admin.categorias.index') }}" class="btn btn-green">
                {{ __('Category List') }}
            </flux:button>
    </div>

    <div class="rounded overflow-hidden shadow-lg text-lg">
        <div class="flex flex-col gap-6 px-4 mb-6">
            <x-auth-header :title="__('Category: ' . ($categoria->nombre ?? ''))"
                :description="__('Category Details')" />
            <x-auth-session-status class="text-center" :status="session('status')" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Datos principales -->
                <div class="flex flex-col gap-6">
                    <flux:input label="{{ __('Category Name') }}" :value="$categoria->nombre" disabled />
                    <flux:input label="{{ __('Category Color') }}" :value="$categoria->color" disabled />
                </div>
                <!-- Datos adicionales -->
                <div class="flex flex-col gap-6">
                    <flux:textarea label="{{ __('Category Description') }}" :value="$categoria->descripcion" disabled />
                    <div>
                        <label class="block mb-1 font-semibold">{{ __('Associated Documents') }}</label>
                        @if($categoria->lopds && $categoria->lopds->count())
                        <ul class="list-disc ml-5">
                            @foreach($categoria->lopds as $lopd)
                            <li>
                                {{ $lopd->descripcion }}
                                <a href="{{ route('admin.lopd.show', $lopd) }}" class="text-blue-600 underline ml-2"
                                    target="_blank">{{ __('View') }}</a>
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