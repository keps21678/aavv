<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-flow-row auto-rows-max gap-4 md:grid-cols-3">
            <div class="relative flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <div class="flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5m6-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Contenido de la tarjeta -->
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mr-2">Número de Socios Activos: </h2>
                    <p class="text-2xl font-extrabold  text-gray-900 dark:text-gray-100">
                        {{ \App\Models\Socio::count() }}
                    </p>
                </div>
            </div>
            <div
                class="relative flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5m6-10a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Número de Socios Activos: </h2>
                <p class="text-4xl font-extrabold  text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Socio::count() }}
                </p>
            </div>
            <div
                class="relative flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5m6-10a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Número de Socios Activos: </h2>
                <p class="text-4xl font-extrabold  text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Socio::count() }}
                </p>

            </div>
        </div>

        <div class="grid grid-flow-row auto-rows-max gap-4 md:grid-cols-3">
            <!-- Card con el número de socios -->
            <div
                class="relative flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
                <!-- Ícono representativo -->
                <div class="flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5m6-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Contenido de la tarjeta -->
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mr-2">Número de Socios Activos: </h2>
                    <p class="text-2xl font-extrabold  text-gray-900 dark:text-gray-100">
                        {{ \App\Models\Socio::count() }}
                    </p>
                </div>
            </div>

            <!-- Tarjetas de ejemplo existentes -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:appointments-calendar />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
