<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AjusTipo extends Model
{
    use HasFactory;
    protected $table = "ajustes_tipos";
    protected $fillable = [
        'codigo',
        'descripcion',
        'tipo'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ->orWhere('descripcion', 'LIKE', "%$keyword%")
            ;
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(AjusDetalle::class, 'tipos_id', 'id');
    }

}
