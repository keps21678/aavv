<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documentaciones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'categoria_id',        // Tipo de documento (consentimiento, aviso, etc.)
        'descripcion',        // Descripción breve del documento
        'fecha_firma',        // Fecha en la que se firmó el documento
        'archivo',            // Ruta o nombre del archivo almacenado
        'nombre_archivo',     // Nombre del archivo para mostrar
        'estado_id',             // Estado del documento (vigente, caducado, revocado, etc.)
        'observaciones',      // Observaciones adicionales
    ];
    public $timestamps = true;

    protected $casts = [
        'categoria_id' => 'integer',
        'descripcion' => 'string',
        'fecha_firma' => 'datetime',
        'archivo' => 'string',
        'nombre_archivo' => 'string',
        'estado_id' => 'integer', 
        'observaciones' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];    
    /**
     * Relación con el modelo Estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    /**
     * Relación con el modelo Estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
