<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tributario extends Model
{
    use HasFactory;

    protected $table = "tributarios";
    protected $fillable = [
        'codigo',
        'taza',
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ->orWhere('taza', 'LIKE', "%$keyword%")
            ;
    }

    public function articulos(): HasMany
    {
        return $this->hasMany(Articulo::class, 'tributarios_id', 'id');
    }

}
