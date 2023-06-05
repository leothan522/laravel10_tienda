<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtIden extends Model
{
    use HasFactory;
    protected $table = "articulos_identificadores";
    protected $fillable = ['articulos_id', 'serial', 'cantidad'];

    public function articulo():BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulos_id', 'id');
    }
}
