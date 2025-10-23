<?php

namespace Database\Seeders;

use App\Models\PedidoPago;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class PedidoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar clientes e produtos existentes
        $clientes = Cliente::all();
        $produtos = Produto::all();

        if ($clientes->isEmpty() || $produtos->isEmpty()) {
            return; // Não criar pedidos pagos se não há clientes ou produtos
        }

        // Criar 4 pedidos pagos
        $pedidosPagos = [
            [
                'nome_cliente' => $clientes->first()->nome,
                'email_cliente' => $clientes->first()->email,
                'nome_produto' => $produtos->first()->nome,
                'descricao_produto' => $produtos->first()->descricao,
                'quantidade' => 2,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 2,
                'data_pedido' => now()->subDays(15),
                'data_pagamento' => now()->subDays(14),
                'metodo_pagamento' => 'Cartão de Crédito',
            ],
            [
                'nome_cliente' => $clientes->skip(1)->first()?->nome ?? $clientes->first()->nome,
                'email_cliente' => $clientes->skip(1)->first()?->email ?? $clientes->first()->email,
                'nome_produto' => $produtos->skip(1)->first()?->nome ?? $produtos->first()->nome,
                'descricao_produto' => $produtos->skip(1)->first()?->descricao ?? $produtos->first()->descricao,
                'quantidade' => 1,
                'preco_unitario' => $produtos->skip(1)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(1)->first()?->preco ?? $produtos->first()->preco) * 1,
                'data_pedido' => now()->subDays(18),
                'data_pagamento' => now()->subDays(17),
                'metodo_pagamento' => 'PIX',
            ],
            [
                'nome_cliente' => $clientes->skip(2)->first()?->nome ?? $clientes->first()->nome,
                'email_cliente' => $clientes->skip(2)->first()?->email ?? $clientes->first()->email,
                'nome_produto' => $produtos->skip(2)->first()?->nome ?? $produtos->first()->nome,
                'descricao_produto' => $produtos->skip(2)->first()?->descricao ?? $produtos->first()->descricao,
                'quantidade' => 3,
                'preco_unitario' => $produtos->skip(2)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(2)->first()?->preco ?? $produtos->first()->preco) * 3,
                'data_pedido' => now()->subDays(20),
                'data_pagamento' => now()->subDays(19),
                'metodo_pagamento' => 'Boleto Bancário',
            ],
            [
                'nome_cliente' => $clientes->skip(3)->first()?->nome ?? $clientes->first()->nome,
                'email_cliente' => $clientes->skip(3)->first()?->email ?? $clientes->first()->email,
                'nome_produto' => $produtos->first()->nome,
                'descricao_produto' => $produtos->first()->descricao,
                'quantidade' => 1,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 1,
                'data_pedido' => now()->subDays(22),
                'data_pagamento' => now()->subDays(21),
                'metodo_pagamento' => 'Cartão de Débito',
            ],
        ];

        foreach ($pedidosPagos as $pedidoPagoData) {
            PedidoPago::create($pedidoPagoData);
        }
    }
}
