<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TSocio extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    //
    protected $table = 'tsocios';
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
    
    // Relación con usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'tsocio_id');
    }

    // Relación con socios
    public function socios()
    {
        return $this->hasMany(Socio::class, 'tsocio_id');
    }   
}
