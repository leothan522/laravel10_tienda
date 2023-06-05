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
        Schema::create('tributarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->decimal('taza', 12, 2)->nullable();
            $table->timestamps();
        });
        DB::table("tributarios")
            ->insert([
                "codigo" => "GENERAL",
                "taza" => 16,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        DB::table("tributarios")
            ->insert([
                "codigo" => "EXENTO",
                "taza" => 0,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tributarios');
    }
};
