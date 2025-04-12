<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuota extends Model
{
    /** @use HasFactory<\Database\Factories\IncidenciaFactory> */
    use HasFactory;

    protected $table = 'cuotas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tsocio_id',
        'anyo',
        'cantidad',
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
            'tsocio_id' => 'integer',
            'anyo' => 'integer',
            'cantidad' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
    public function tsocio()
    {
        return $this->belongsTo(TSocio::class, 'tsocio_id');
    }
}
