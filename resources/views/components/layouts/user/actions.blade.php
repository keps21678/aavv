<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Component;

new class extends User {
    //
}; ?>

<div class="flex justify-end space-x-2">
    
    @hasanyrole('admin|editor')
        <flux:button variant="primary" href="{{ route('admin.users.edit', $user) }}" class="btn btn-blue">Editar
        </flux:button>
    @endhasanyrole
    
    @hasrole('admin')
        <form class="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <flux:button variant="danger" type="submit" class="btn btn-danger">Eliminar
            </flux:button>
        </form>
    @endhasrole
</div>