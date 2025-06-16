<x-layouts.app :title="__('Editar usuario/a')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">{{ __('Users') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edit User') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('register') }}" class="btn btn-green">{{ __('New User') }}</flux:button>
            <flux:button href="{{ route('admin.users.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Users List') }}</flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        {{-- <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains"> --}}
        <div class="px-6 py-4">
            <h1 class="flex justify-end font-bold text-xl mb-4">{{ __('Edit User') }}</h1>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class='mb-4'>
                    <flux:input wire:model="name" label="{{ __('Full Name') }}" placeholder="{{ __('Enter full name') }}"
                        :value="old('name', $user->name)" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="email" label="{{ __('Email') }}" placeholder="{{ __('Enter user email') }}"
                        :value="old('email', $user->email)" required />
                </div>
                <div class='mb-4 gap-2'>
                    @foreach ($roles as $role)
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                            {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                        {{ $role->name }}
                    @endforeach
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
