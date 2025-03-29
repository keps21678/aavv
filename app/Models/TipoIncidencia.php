<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoIncidencia extends Model
{
    use HasFactory;
    //
    protected $table = 'tipos_incidencias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nombre' => 'string',
            'descripcion' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
