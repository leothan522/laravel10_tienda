<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articulo extends Model
{
    use HasFactory;

    protected $table = "articulos";
    protected $fillable = [
        'codigo',
        'descripcion',
        'tipo',
        'categorias_id',
        'procedencias_id',
        'tributarios_id',
        'unidades_id',
        'marca',
        'modelo',
        'referencia',
        'adicional',
        'decimales',
        'estatus',
        'imagen',
        'mini',
        'detail',
        'cart',
        'banner'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('codigo', 'LIKE', "%$keyword%")
            ->orWhere('descripcion', 'LIKE', "%$keyword%")
            ;
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categorias_id', 'id');
    }

    public function procedencia(): BelongsTo
    {
        return $this->belongsTo(Procedencia::class, 'procedencias_id', 'id');
    }

    public function tributario(): BelongsTo
    {
        return $this->belongsTo(Tributario::class, 'tributarios_id', 'id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidades_id', 'id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoArticulo::class, 'tipos_id', 'id');
    }

    public function artund(): HasMany
    {
        return $this->hasMany(ArtUnid::class, 'articulos_id', 'id');
    }

    public function artimg(): HasMany
    {
        return $this->hasMany(ArtImg::class, 'articulos_id', 'id');
    }

    public function artiden(): HasMany
    {
        return $this->hasMany(ArtIden::class, 'articulos_id', 'id');
    }

    public function precio(): HasMany
    {
        return $this->hasMany(Precio::class, 'articulos_id', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'articulos_id', 'id');
    }

    public function ajusdetalles(): HasMany
    {
        return $this->hasMany(AjusDetalle::class, 'articulos_id', 'id');
    }

    public function oferta(): HasMany
    {
        return $this->hasMany(Oferta::class, 'articulos_id', 'id');
    }



}
