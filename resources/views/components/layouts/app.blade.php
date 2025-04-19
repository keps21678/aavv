<x-layouts.app.sidebar>
    <flux:main>
        {{ $slot }}
    </flux:main>

    @stack('js')
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));            
            {{ session()->forget('swal') }}
        </script>
    @endif
</x-layouts.app.sidebar>
