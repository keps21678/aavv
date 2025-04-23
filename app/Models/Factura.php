<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'proveedor_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'importe',
        'estado',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;

    /**
     * Relación con el modelo Proveedor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
