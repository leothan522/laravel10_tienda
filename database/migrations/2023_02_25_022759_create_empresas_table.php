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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('rif')->unique();
            $table->string('nombre');
            $table->text('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('moneda')->default('Bs.');
            $table->string('supervisor')->nullable();
            $table->text('logo')->nullable();
            $table->text('miniatura')->nullable();
            $table->text('banner')->nullable();
            $table->integer('default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
