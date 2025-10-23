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
        Schema::create('pedidos_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente'); // Nome do cliente (não FK)
            $table->string('email_cliente'); // Email do cliente (não FK)
            $table->string('nome_produto'); // Nome do produto (não FK)
            $table->text('descricao_produto')->nullable(); // Descrição do produto (não FK)
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamp('data_pedido');
            $table->timestamp('data_pagamento')->useCurrent();
            $table->string('metodo_pagamento')->nullable();
            $table->timestamp('adicionado_em')->default(now());
            $table->timestamp('atualizado_em')->nullable()->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_pagos');
    }
};
