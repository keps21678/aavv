<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recibo extends Model
{
    /* Campos necesarios para las remesas de recibos en Caja Rural
    IBAN --> ESXXYYYYYYYYYYYYYYYYYYYYYYYY, lo sacamos de la tabla socios
    Nombre del deudor: Apellidos, Nombre --> Socio->nombre, Socio->apellidos, lo sacamos de la tabla socios
    Referencia mandato: NScocio --> Socio->id, lo sacamos de la tabla socios
    Fecha de firma del mandato: 31/10/2009  'Para que no pida justificantes'
    Referencia del adeudo: NSocio --> Socio->id, lo sacamos de la tabla socios
    Tipo de adeudo: RCUR 'Explicado en la WEB de Caja Rural'
    Concepto del adeudo: Cuota "AÑO" --> Cuota->anyo, lo sacamos de la tabla cuotas
    Importe: Cuota que corresponda --> Cuota->cantidad, lo sacamos de la tabla cuotas
    */
    /** @use HasFactory<\Database\Factories\ReciboFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'recibos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'socio_id',
        'tsocio_id',
        'cuota_id',
        'recibo_numero',
        'fecha_emision',
        'fecha_vencimiento',
        'estado_id',
        'descripcion', // Nuevo campo
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
            'tsocio_id' => 'integer',
            'cuota_id' => 'integer',
            'recibo_numero' => 'string',
            'fecha_emision' => 'date',
            'fecha_vencimiento' => 'date',
            'estado_id' => 'integer',
            'descripcion' => 'string', // Nuevo campo
        ];
    }
    /**
     * Get the socio that owns the recibo.
     */
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }
    /**
     * Get the tsocio that owns the recibo.
     */
    public function tsocio()
    {
        return $this->belongsTo(Tsocio::class);
    }
    /**
     * Get the cuota that owns the recibo.
     */
    public function cuota()
    {
        return $this->belongsTo(Cuota::class);
    }
    /**
     * Get the estado that owns the recibo.
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
