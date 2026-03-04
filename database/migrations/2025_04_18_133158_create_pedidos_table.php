<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade'); // cliente que hace el pedido
            $table->date('fecha')->default(DB::raw('CURRENT_DATE'));
            $table->foreignId('comercial_id')->constrained('users')->onDelete('cascade'); 
            $table->integer('cantidad')->default(1);
            $table->decimal('total', 10, 2)->default(0); // total en euros
            $table->enum('estado', ['pendiente', 'enviado', 'cancelado'])->default('pendiente'); // estado del pedido
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pedidos');
    }
};
