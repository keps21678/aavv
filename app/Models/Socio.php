<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    /** @use HasFactory<\Database\Factories\SocioFactory> */
    use HasFactory;

    protected $table = 'socios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nsocio',
        'empresa',
        'nombre',
        'apellidos',
        'dni',
        'telefono',
        'movil',
        'email',
        'direccion',
        'codigo_postal',
        'localidad',
        'provincia',
        'persona_contacto',
        'domiciliacion',
        'iban',
        'tiposocio_id',
        'cuota_id',
        'baja',
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
            'nsocio' => 'integer',
            'empresa' => 'boolean',
            'nombre' => 'string',
            'apellidos' => 'string',
            'dni' => 'string',
            'telefono' => 'string', // Cambiado de PhoneNumber::class a 'string'
            'movil' => 'string',    // Cambiado de PhoneNumber::class a 'string'
            'email' => 'string',    // Cambiado de Email::class a 'string'
            'direccion' => 'string',
            'codigo_postal' => 'string',
            'poblacion' => 'string',
            'provincia' => 'string',
            'persona_contacto' => 'string',
            'domiciliacion' => 'boolean',
            'iban' => 'string',
            'tiposocio_id' => 'integer',
            'cuota_id' => 'integer',
            'baja' => 'boolean'
        ];
    }
}
