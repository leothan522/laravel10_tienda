<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;
    protected $table = "stock";
    protected $fillable = [
        'empresas_id',
        'articulos_id',
        'almacenes_id',
        'unidades_id',
        'actual',
        'comprometido',
        'disponible',
        'vendido',
        'estatus',
        'almacen_principal',
        'auditoria'
    ];

    /*public function scopeBuscar($query, $keyword)
    {
        return $query->where('id', "%$keyword%")
            ;
    }*/

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulos_id', 'id');
    }

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacenes_id', 'id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidades_id', 'id');
    }

}
