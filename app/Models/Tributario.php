<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
