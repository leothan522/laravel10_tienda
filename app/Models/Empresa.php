<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";
    protected $fillable = [
        'rif',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'moneda',
        'supervisor',
        'default',
        'imagen',
        'mini',
        'detail',
        'cart',
        'banner',
        'permisos'
    ];

    public function scopeBuscar($query, $keyword)
    {
        return $query->where('rif', 'LIKE', "%$keyword%")
            ->orWhere('nombre', 'LIKE', "%$keyword%");
    }

    public function precio(): HasMany
    {
        return $this->hasMany(Precio::class, 'precios_id', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'empresas_id', 'id');
    }

    public function almacen(): HasMany
    {
        return $this->hasMany(Almacen::class, 'empresas_id', 'id');
    }

    public function ajustes(): HasMany
    {
        return $this->hasMany(Ajuste::class, 'empresas_id', 'id');
    }

}
