<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tincidencia extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $table = 'tincidencias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
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
            'nombre' => 'string',
            'descripcion' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'tincidencia_id');
    }
}
