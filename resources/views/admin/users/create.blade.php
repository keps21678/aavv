<x-layouts.app :title="__('Nuevo Usuario')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.users.index')">{{ __('Users') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Create an account') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div>
            <flux:button href="{{ route('admin.users.index') }}"
                class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">{{ __('Users List') }}
            </flux:button>
        </div>
    </div>
    <div class="max-w-sm rounded overflow-hidden shadow-lg p-2 mt-4">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Create an account')"
                :description="__('Enter the details below to create the account')" />
            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class='mb-4'>
                    <flux:input wire:model="name" label="{{ __('Full Name') }}"
                        placeholder="{{ __('Enter Full name') }}" required />
                </div>
                <div class='mb-4'>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email"
                        placeholder="email@example.com" />
                </div>
                <div class='mb-4'>
                    <!-- Password -->
                    <flux:input wire:model="password" :label="__('Password')" type="password" required
                        autocomplete="new-password" :placeholder="__('Password')" />
                </div>
                <div class='mb-4'>
                    <!-- Confirm Password -->
                    <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password"
                        required autocomplete="new-password" :placeholder="__('Confirm password')" />
                </div>
                <div class='mb-4 gap-6'>
                    @foreach ($roles as $role)
                    <input type="checkbox" class="ms-4" name="roles[]" value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ?
                    'checked' : '' }}>
                    {{ $role->name }}
                    @endforeach
                </div>
                <div class="flex justify-end mt-4">
                    <flux:button type="submit" variant="primary" class="btn btn-blue">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>