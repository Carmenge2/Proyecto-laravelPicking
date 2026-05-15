<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->index('nombre_comercial');
            $table->index('razon_social');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->index('estado');
            $table->index('fecha');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropIndex(['nombre_comercial']);
            $table->dropIndex(['razon_social']);
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['fecha']);
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropIndex(['nombre']);
        });
    }
};
