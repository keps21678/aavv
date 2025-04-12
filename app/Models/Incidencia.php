<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    /** @use HasFactory<\Database\Factories\IncidenciaFactory> */
    use HasFactory;

    protected $table = 'incidencias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'socio_id',
        'tipo_incidencia_id',
        'descripcion',
        'fecha_incidencia',
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
            'socio_id' => 'integer',
            'tipo_incidencia_id' => 'integer',
            'descripcion' => 'string',
            'fecha_incidencia' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
    // filepath: d:\xampp\htdocs\laravel\prueba01\app\Models\Incidencia.php
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }
    public function tincidencia()
    {
        return $this->belongsTo(Tincidencia::class, 'tincidencia_id');
    }
}
