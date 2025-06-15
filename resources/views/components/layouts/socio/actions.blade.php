<?php

use App\Models\Socio;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Component;

new class extends Socio {
    //
}; ?>

<div class="flex justify-end space-x-2">
    <flux:button icon:trailing="arrow-up-right" href="{{ route('admin.socios.show', $socio) }}"
        class="btn btn-green mr-2">Consultar</flux:button>

    @hasanyrole('admin|editor')
    <flux:button variant="primary" href="{{ route('admin.socios.edit', $socio) }}" class="btn btn-blue">Editar
    </flux:button>
    @endhasanyrole
    
    @hasrole('admin')
    <form class="delete-form" action="{{ route('admin.socios.destroy', $socio) }}" method="POST">
        @csrf
        @method('DELETE')
        <flux:button wire:click="delete" variant="danger" type="submit" class="btn btn-danger">
            Eliminar
        </flux:button>
    </form>
    @endhasrole
</div>