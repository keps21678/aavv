<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lopd extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lopds';
    protected $primaryKey = 'id';
    protected $fillable = [
        'socio_id',           // Relación con el socio al que pertenece la documentación
        'category_id',        // Tipo de documento (consentimiento, aviso, etc.)
        'descripcion',        // Descripción breve del documento
        'fecha_firma',        // Fecha en la que se firmó el documento
        'archivo',            // Ruta o nombre del archivo almacenado
        'estado_id',             // Estado del documento (vigente, caducado, revocado, etc.)
        'observaciones',      // Observaciones adicionales
    ];
    public $timestamps = true;

    protected $casts = [
        'socio_id' => 'integer',
        'category_id' => 'integer',
        'descripcion' => 'string',
        'fecha_firma' => 'datetime',
        'archivo' => 'string',
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
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
