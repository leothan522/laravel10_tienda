<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ajustes_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ajustes_id')->unsigned();
            $table->bigInteger('tipos_id')->unsigned();
            $table->bigInteger('articulos_id')->unsigned();
            $table->bigInteger('almacenes_id')->unsigned();
            $table->bigInteger('unidades_id')->unsigned();
            $table->decimal('cantidad', 12, 3);
            $table->decimal('costo_unitario', 12, 3)->nullable();
            $table->decimal('costo_total', 12, 3)->nullable();
            $table->integer('renglon')->nullable();
            $table->foreign('ajustes_id')->references('id')->on('ajustes')->cascadeOnDelete();
            $table->foreign('tipos_id')->references('id')->on('ajustes_tipos')->cascadeOnDelete();
            $table->foreign('articulos_id')->references('id')->on('articulos')->cascadeOnDelete();
            $table->foreign('almacenes_id')->references('id')->on('almacenes')->cascadeOnDelete();
            $table->foreign('unidades_id')->references('id')->on('unidades')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes_detalles');
    }
};
