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
        Schema::create('ajustes_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->integer('tipo');
            $table->timestamps();
        });

        DB::table("ajustes_tipos")
            ->insert([
                "codigo" => "E01",
                "descripcion" => "ENTRADA",
                "tipo" => 1,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);

        DB::table("ajustes_tipos")
            ->insert([
                "codigo" => "S01",
                "descripcion" => "SALIDA",
                "tipo" => 2,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes_tipos');
    }
};
