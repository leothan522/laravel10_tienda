<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtUnid extends Model
{
    use HasFactory;
    protected $table = "articulos_unidades";
    protected $fillable = ['articulos_id', 'unidades_id'];

    public function articulo():BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulos_id', 'id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'unidades_id', 'id');
    }

}
