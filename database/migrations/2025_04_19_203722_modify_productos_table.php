<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductosTable extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Añadir columna 'stock' si no existe
            if (!Schema::hasColumn('productos', 'stock')) {
                $table->integer('stock')->default(0);
            }

            // Añadir columna 'estado' si no existe
            if (!Schema::hasColumn('productos', 'estado')) {
                $table->enum('estado', ['disponible', 'agotado', 'pre-venta'])->default('disponible');
            }

            // Añadir columna 'notas_adicionales' si no existe
            if (!Schema::hasColumn('productos', 'notas_adicionales')) {
                $table->text('notas_adicionales')->nullable();
            }

            // Añadir columna 'precio' si no existe
            if (!Schema::hasColumn('productos', 'precio')) {
                $table->decimal('precio', 8, 2)->default(0.00);
            }

            // Añadir columna 'descripcion' si no existe
            if (!Schema::hasColumn('productos', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'stock')) {
                $table->dropColumn('stock');
            }

            if (Schema::hasColumn('productos', 'estado')) {
                $table->dropColumn('estado');
            }

            if (Schema::hasColumn('productos', 'notas_adicionales')) {
                $table->dropColumn('notas_adicionales');
            }

            if (Schema::hasColumn('productos', 'precio')) {
                $table->dropColumn('precio');
            }

            if (Schema::hasColumn('productos', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
        });
    }
}
