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
        Schema::create('precios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('articulos_id')->unsigned();
            $table->bigInteger('empresas_id')->unsigned();
            $table->bigInteger('unidades_id')->unsigned();
            $table->string('moneda')->default('Bs.');
            $table->decimal('precio', 12,2);
            $table->text('auditoria')->nullable();
            $table->foreign('articulos_id')->references('id')->on('articulos')->cascadeOnDelete();
            $table->foreign('empresas_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreign('unidades_id')->references('id')->on('unidades')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};
