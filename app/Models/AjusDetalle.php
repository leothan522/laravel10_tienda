<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AjusDetalle extends Model
{
    use HasFactory;
    protected $table = "ajustes_detalles";
    protected $fillable = [
        'ajustes_id',
        'tipos_id',
        'articulos_id',
        'almacenes_id',
        'unidades_id',
        'cantidad',
        'costo_unitario',
        'costo_total',
        'renglon'
    ];

    public function ajustes(): BelongsTo
    {
        return $this->belongsTo(Ajuste::class, 'ajustes_id', 'id');
    }

    public function tipos(): BelongsTo
    {
        return $this->belongsTo(AjusTipo::class, 'tipos_id', 'id');
    }

}
