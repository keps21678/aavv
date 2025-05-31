<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',         // Nombre de la categoría
        'descripcion',    // Descripción de la categoría
        'color',          // Color asociado a la categoría
    ];
    public $timestamps = true;
    protected $casts = [
        'nombre' => 'string',
        'descripcion' => 'string',
        'color' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relación con el modelo Lopd.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lopds()
    {
        return $this->hasMany(Lopd::class, 'categoria_id');
    }
}
