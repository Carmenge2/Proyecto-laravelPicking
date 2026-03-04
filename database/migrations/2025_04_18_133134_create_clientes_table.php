<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comercial_id');
            $table->string('nombre_comercial');  // Nombre comercial del cliente
            $table->string('razon_social');      // Razón social del cliente
            $table->string('email')->nullable();  // Correo electrónico
            $table->string('telefono')->nullable();  // Teléfono del cliente
            $table->string('direccion')->nullable();  //direccion del cliente
            $table->string('tipo_negocio')->nullable();  // Tipo de negocio del cliente
            $table->foreign('comercial_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();  // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');  // Eliminar la tabla si se deshace la migración
    }
};
