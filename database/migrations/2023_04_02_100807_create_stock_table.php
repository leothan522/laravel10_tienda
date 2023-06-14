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
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresas_id')->unsigned();
            $table->bigInteger('articulos_id')->unsigned();
            $table->bigInteger('almacenes_id')->unsigned();
            $table->bigInteger('unidades_id')->unsigned();
            $table->decimal('actual', 12,3)->nullable();
            $table->decimal('comprometido', 12,3)->nullable();
            $table->decimal('disponible', 12,3)->nullable();
            $table->decimal('vendido', 12,3)->nullable();
            $table->integer('estatus')->default(0);
            $table->integer('almacen_principal')->default(0);
            $table->text('auditoria')->nullable();
            $table->foreign('empresas_id')->references('id')->on('empresas')->cascadeOnDelete();
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
        Schema::dropIfExists('stock');
    }
};
