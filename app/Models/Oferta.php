<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Oferta extends Model
{
    use HasFactory;

    protected $table = "ofertas";
    protected $fillable = [
        'empresas_id',
        'afectados',
        'categorias_id',
        'articulos_id',
        'desde',
        'hasta',
        'descuento',
        'auditoria'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('rif', 'LIKE', "%$keyword%")
            ->orWhere('nombre', 'LIKE', "%$keyword%");
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulos_id', 'id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categorias_id', 'id');
    }

}
