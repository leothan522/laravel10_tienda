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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('plataforma')->default(0);
            $table->integer('estatus')->default(1);
            $table->integer('role')->default(0);
            $table->bigInteger('roles_id')->unsigned()->nullable();
            $table->text('permisos')->nullable();
            $table->text('empresas_id')->nullable();
            $table->timestamps();
        });

        DB::table("users")
            ->insert([
                "name" => "Yonathan Castillo",
                "email" => "leothan522@gmail.com",
                "email_verified_at" => \Carbon\Carbon::now(),
                "password" => \Illuminate\Support\Facades\Hash::make("20025623"),
                "role" => 100,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
