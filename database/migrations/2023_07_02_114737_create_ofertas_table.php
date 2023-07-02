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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresas_id')->unsigned();
            $table->integer('afectados');
            $table->bigInteger('categorias_id')->unsigned()->nullable();
            $table->bigInteger('articulos_id')->unsigned()->nullable();
            $table->dateTime('desde');
            $table->dateTime('hasta');
            $table->integer('descuento');
            $table->text('auditoria')->nullable();
            $table->foreign('empresas_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreign('categorias_id')->references('id')->on('categorias')->cascadeOnDelete();
            $table->foreign('articulos_id')->references('id')->on('articulos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
