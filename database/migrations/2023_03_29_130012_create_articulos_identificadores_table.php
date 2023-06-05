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
        Schema::create('articulos_identificadores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('articulos_id')->unsigned();
            $table->string('serial')->unique();
            $table->decimal('cantidad',12,3);
            $table->foreign('articulos_id')->references('id')->on('articulos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos_identificadores');
    }
};
