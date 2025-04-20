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
        'calle',
        'portal',
        'piso',
        'letra',
        'codigo_postal',
        'poblacion',
        'provincia',
        'persona_contacto',
        'domiciliacion',
        'iban',
        'titular',
        'dni_titular',
        'tsocio_id',
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
            'telefono' => 'string',
            'movil' => 'string',
            'email' => 'string',
            'calle' => 'string',
            'portal' => 'string',
            'piso' => 'string',
            'letra' => 'string',
            'codigo_postal' => 'string',
            'poblacion' => 'string',
            'provincia' => 'string',
            'persona_contacto' => 'string',
            'domiciliacion' => 'boolean',
            'iban' => 'string',
            'titular' => 'string',
            'dni_titular' => 'string',
            'tsocio_id' => 'integer',
            'cuota_id' => 'integer',
            'baja' => 'boolean'
        ];
    }

    /**
     * Mutador para encriptar el IBAN antes de guardarlo en la base de datos.
     */
    public function setIbanAttribute($value)
    {
        $this->attributes['iban'] = encrypt($value);
    }

    /**
     * Accesor para desencriptar el IBAN al acceder al atributo.
     */
    public function getIbanAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null; // Retorna null si no se puede desencriptar
        }
    }

    public function tsocio()
    {
        return $this->belongsTo(TSocio::class, 'tsocio_id', 'id');
    }

    public function cuota_id()
    {
        return $this->belongsTo(Cuota::class, 'cuota_id', 'id');
    }

    public function cuota()
    {
        return $this->belongsTo(Cuota::class, 'cuota_id');
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'socio_id');
    }
}
