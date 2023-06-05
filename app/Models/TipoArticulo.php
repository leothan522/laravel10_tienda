<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoArticulo extends Model
{
    use HasFactory;

    protected $table = "articulos_tipo";
    protected $fillable = ['nombre'];

    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class, 'tipos_id', 'id');
    }

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('nombre', 'LIKE', "%$keyword%");
    }

}
