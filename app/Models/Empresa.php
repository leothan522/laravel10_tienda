<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = "empresa";
    protected $fillable = [
        'rif',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'moneda',
        'supervisor',
        'logo',
        'miniatura',
        'banner',
        'default',
    ];
}
