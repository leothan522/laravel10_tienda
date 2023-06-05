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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->bigInteger('tipos_id')->unsigned()->nullable();
            $table->bigInteger('categorias_id')->unsigned()->nullable();
            $table->bigInteger('procedencias_id')->unsigned()->nullable();
            $table->bigInteger('tributarios_id')->unsigned()->nullable();
            $table->bigInteger('unidades_id')->unsigned()->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->text('referencia')->nullable();
            $table->text('adicional')->nullable();
            $table->integer('decimales')->default(0);
            $table->integer('estatus')->default(1);
            $table->text('imagen')->nullable();
            $table->text('mini')->nullable();
            $table->text('detail')->nullable();
            $table->text('cart')->nullable();
            $table->text('banner')->nullable();
            $table->foreign('tipos_id')->references('id')->on('articulos_tipo')->nullOnDelete();
            $table->foreign('categorias_id')->references('id')->on('categorias')->nullOnDelete();
            $table->foreign('procedencias_id')->references('id')->on('procedencias')->nullOnDelete();
            $table->foreign('tributarios_id')->references('id')->on('tributarios')->nullOnDelete();
            $table->foreign('unidades_id')->references('id')->on('unidades')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
