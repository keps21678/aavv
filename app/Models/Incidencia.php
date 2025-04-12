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
        'tincidencia_id',
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
            'tincidencia_id' => 'integer',
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
    
    public static function validateRequest($request)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'tincidencia_id' => 'required|exists:tincidencias,id',
            'descripcion' => 'required|string|max:255',
            'fecha_incidencia' => 'required|date',
        ]);
    }
}
