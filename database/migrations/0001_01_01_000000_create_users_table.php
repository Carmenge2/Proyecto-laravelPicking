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
        Schema::create('users', function (Blueprint $table) {
            $table->id();// ID autoincremental
            $table->string('name');
            $table->string('email')->unique();// Email único
            $table->timestamp('email_verified_at')->nullable(); // Fecha verificación email (nullable)
            $table->string('password');
            $table->enum('rol', ['admin', 'comercial'])->default('comercial'); // Rol: admin o comercial, por defecto comercial
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();// Email (clave primaria)
            $table->string('token');// Token de reseteo de contraseña
            $table->timestamp('created_at')->nullable();// Fecha creación token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();// Dirección IP del usuario
            $table->text('user_agent')->nullable();// Información del navegador
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions'); 
    }
};
