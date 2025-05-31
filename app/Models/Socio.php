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

    /**
     * Mutadores para encriptar antes de guardar en la base de datos
     */
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = encrypt($value);
    }
    public function setApellidosAttribute($value)
    {
        $this->attributes['apellidos'] = encrypt($value);
    }
    public function setPersonaContactoAttribute($value)
    {
        $this->attributes['persona_contacto'] = encrypt($value);
    }
    public function setEmpresaAttribute($value)
    {
        $this->attributes['empresa'] = encrypt($value);
    }
    public function setCalleAttribute($value)
    {
        $this->attributes['calle'] = encrypt($value);
    }
    public function setDniAttribute($value)
    {
        $this->attributes['dni'] = encrypt($value);
    }
    public function setTitularAttribute($value)
    {
        $this->attributes['titular'] = encrypt($value);
    }
    public function setDniTitularAttribute($value)
    {
        $this->attributes['dni_titular'] = encrypt($value);
    }
    public function setTelefonoAttribute($value)
    {
        $this->attributes['telefono'] = encrypt($value);
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = encrypt($value);
    }
    public function setMovilAttribute($value)
    {
        $this->attributes['movil'] = encrypt($value);
    }
    public function setPortalAttribute($value)
    {
        $this->attributes['portal'] = encrypt($value);
    }
    public function setPisoAttribute($value)
    {
        $this->attributes['piso'] = encrypt($value);
    }
    public function setLetraAttribute($value)
    {
        $this->attributes['letra'] = encrypt($value);
    }

    /**
     * Accesores para desencriptar al obtener de la base de datos
     */
    public function getNombreAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getApellidosAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPersonaContactoAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getEmpresaAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getCalleAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getDniAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getTitularAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getDniTitularAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getTelefonoAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getEmailAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getMovilAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPortalAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPisoAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getLetraAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return null;
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

    public function lopds()
    {
        return $this->hasMany(\App\Models\Lopd::class, 'socio_id');
    }
}
