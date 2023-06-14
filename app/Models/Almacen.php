<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Almacen extends Model
{
    use HasFactory;

    protected $table = "almacenes";
    protected $fillable = [
        'empresas_id',
        'codigo',
        'nombre'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ->orWhere('nombre', 'LIKE', "%$keyword%")
            ;
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    public function ajusdetalles(): HasMany
    {
        return $this->hasMany(AjusDetalle::class, 'almacenes_id', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'almacenes_id', 'id');
    }

}
