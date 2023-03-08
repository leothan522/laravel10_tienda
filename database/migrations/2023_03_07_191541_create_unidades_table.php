<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table("unidades")
            ->insert([
                "codigo" => "UND",
                "nombre" => "UNIDAD",
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        DB::table("unidades")
            ->insert([
                "codigo" => "KG",
                "nombre" => "KILOGRAMOS",
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        DB::table("unidades")
            ->insert([
                "codigo" => "CAJA",
                "nombre" => "CAJA",
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        DB::table("unidades")
            ->insert([
                "codigo" => "BULTO",
                "nombre" => "BULTO",
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};
