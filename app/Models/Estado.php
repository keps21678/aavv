<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $table = 'estados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono',
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
            'color' => 'string',
            'icono' => 'string',
        ];
    }
    /**
     * Get the incidencias that owns the estado.
     */
    public function incidencias()
    {
        return $this->hasMany(Tincidencia::class, 'estado_id');
    }
    /**
     * Get the recibos that owns the estado.
     */
    public function recibos()
    {
        return $this->hasMany(Recibo::class, 'estado_id');
    }
    /**
     * Get the cuotas that owns the estado.
     */
    public function cuotas()
    {
        return $this->hasMany(Cuota::class, 'estado_id');
    }
    /**
     * Get the socios that owns the estado.
     */
    public function socios()
    {
        return $this->hasMany(Socio::class, 'estado_id');
    }
}
