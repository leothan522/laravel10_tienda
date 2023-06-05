<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidad extends Model
{
    use HasFactory;

    protected $table = "unidades";
    protected $fillable = [
        'codigo',
        'nombre',
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ->orWhere('nombre', 'LIKE', "%$keyword%")
            ;
    }

    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class, 'unidades_id', 'id');
    }

    public function artund(): HasMany
    {
        return $this->hasMany(ArtUnid::class, 'unidades_id', 'id');
    }

}
