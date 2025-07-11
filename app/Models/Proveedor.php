<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\Models\Gasto; // Ensure the Gasto model exists in the specified namespace
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    /** @use HasFactory<\Database\Factories\ProveedorFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nif',
        'nombre',
        'telefono',
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
        'titular', // Uncomment if needed
        'dni_titular', // Uncomment if needed
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
            'nif' => 'string',
            'nombre' => 'string',
            'telefono' => 'string',
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

    /**
     * Mutador para encriptar el IBAN antes de guardarlo.
     *
     * @param string $value
     * @return void
     */
    public function setIbanAttribute(string $value): void
    {
        $this->attributes['iban'] = Crypt::encryptString($value);
    }

    /**
     * Accesor para desencriptar el IBAN al acceder a él.
     *
     * @return string
     */
    public function getIbanAttribute(): string
    {
        return Crypt::decryptString($this->attributes['iban']);
    }
    /**
     * Validar la solicitud de creación o actualización.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public static function validateRequest($request): void
    {
        $request->validate([
            'nif' => 'required|string|max:9',
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'calle' => 'nullable|string|max:255',
            'portal' => 'nullable|string|max:10',
            'piso' => 'nullable|string|max:10',
            'letra' => 'nullable|string|max:1',
            'codigo_postal' => 'nullable|string|max:10',
            'poblacion' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'persona_contacto' => 'nullable|string|max:255',
            'domiciliacion' => 'boolean',
            // No validamos el IBAN aquí, ya que se valida en el mutador
        ]);
    }
    /**
     * Relación con gastos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Gasto::class, 'proveedor_id');
    }

    // Mutadores para encriptar antes de guardar
    public function setNifAttribute($value)
    {
        $this->attributes['nif'] = Crypt::encryptString($value);
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = Crypt::encryptString($value);
    }
    public function setTelefonoAttribute($value)
    {
        $this->attributes['telefono'] = Crypt::encryptString($value);
    }
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encryptString($value);
    }
    public function setCalleAttribute($value)
    {
        $this->attributes['calle'] = Crypt::encryptString($value);
    }
    public function setPortalAttribute($value)
    {
        $this->attributes['portal'] = Crypt::encryptString($value);
    }
    public function setPisoAttribute($value)
    {
        $this->attributes['piso'] = Crypt::encryptString($value);
    }
    public function setPersonaContactoAttribute($value)
    {
        $this->attributes['persona_contacto'] = Crypt::encryptString($value);
    }

    // Accesores para desencriptar al obtener
    public function getNifAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getNombreAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getTelefonoAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getEmailAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getCalleAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPortalAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPisoAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function getPersonaContactoAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
