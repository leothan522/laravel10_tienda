<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            ->orWhere('nombre', 'LIKE', "%$keyword%")
            ;
    }
}
