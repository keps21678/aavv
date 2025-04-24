<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Factura extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'facturas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'proveedor_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'descripcion',
        'importe',
        'estado_id',
    ];
    public $timestamps = true;
    
    protected $casts = [
        'proveedor_id' => 'integer',
        'numero' => 'string',
        'descripcion' => 'string',
        'importe' => 'decimal:2',
        'estado_id' => 'integer',
        'fecha_emision' => 'datetime',
        'fecha_vencimiento' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el modelo Proveedor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    /**
     * Relación con el modelo Estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
