<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtImg extends Model
{
    use HasFactory;
    protected $table = "articulos_imagenes";
    protected $fillable = [
        'imagen',
        'mini',
        'detail',
        'cart',
        'banner'
    ];

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'articulos_id', 'id');
    }

}
