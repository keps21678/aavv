<x-layouts.app :title="__('Users List')">
    <div class="flex items-center justify-between">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">{{ __('Dashboard') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Users') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        @hasrole('admin')
        <flux:button href="{{ route('admin.users.create') }}" class="btn btn-green-dark text-white font-bold py-2 px-4 rounded text-xs">
            {{ __('New User') }} </flux:button>
        @endhasrole
    </div>
    <br />
    <div class="relative overflow-x-auto px-4">
        <hr class="solid">
        <table id="tabla" class="display w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">{{ __('ID') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Name') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Role') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Email') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Language') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Appearance') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Created At') }}</th>
                    <th scope="col" class="px-6 py-3">{{ __('Updated At') }}</th>
                    @hasanyrole('admin|editor')
                    <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->id }}</th>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">
                        @foreach ($user->roles as $role)
                        {{ $role->name }}
                        @endforeach
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->language ?? '-' }}</td>
                    <td class="px-6 py-4">{{ ucfirst($user->appearance ?? '-') }}</td>
                    <td class="px-6 py-4">{{ $user->created_at }}</td>
                    <td class="px-6 py-4">{{ $user->updated_at }}</td>
                    @hasanyrole('admin|editor')
                    <td class="px-6 py-4">
                        <div class="flex justify-end space-x-2">
                            <x-layouts.user.actions :user="$user" />
                        </div>
                    </td>
                    @endhasanyrole
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
    @push('js')
    <script>
        $(document).ready(function () {                
           $('#tabla').DataTable({
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                layout: {
                    topStart: 'buttons',
                    topEnd: 'search',
                    bottom: null,
                    bottomStart: null,
                    bottomEnd: 'info',
                },
                responsive: true,
                paging: false,
                scrollCollapse: true,
                scrollY: '60vh',
                language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Traducción al español
                },
            });
        
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    Swal.fire({
                        title: {!! json_encode(__('Are you sure?')) !!},
                        text: {!! json_encode(__('You won\'t be able to revert this!')) !!},
                        icon: 'warning',showCancelButton: true,                        
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: {!! json_encode(__('Yes, delete it!')) !!},
                        cancelButtonText: {!! json_encode(__('Cancel')) !!}
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-layouts.app>