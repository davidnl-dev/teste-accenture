<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
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
            return; // Não criar pedidos se não há clientes ou produtos
        }

        // Criar alguns pedidos de exemplo
        $pedidos = [
            // Pedidos existentes
            [
                'cliente_id' => $clientes->first()->id,
                'produto_id' => $produtos->first()->id,
                'quantidade' => 2,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 2,
                'status' => 'pago',
                'data_pedido' => now()->subDays(5),
            ],
            [
                'cliente_id' => $clientes->skip(1)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->skip(1)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->skip(1)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(1)->first()?->preco ?? $produtos->first()->preco) * 1,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(2),
            ],
            [
                'cliente_id' => $clientes->skip(2)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->skip(2)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 3,
                'preco_unitario' => $produtos->skip(2)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(2)->first()?->preco ?? $produtos->first()->preco) * 3,
                'status' => 'pago',
                'data_pedido' => now()->subDays(1),
            ],
            
            // 5 pedidos pendentes adicionais
            [
                'cliente_id' => $clientes->skip(3)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 1,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(3),
            ],
            [
                'cliente_id' => $clientes->skip(4)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->skip(1)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 2,
                'preco_unitario' => $produtos->skip(1)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(1)->first()?->preco ?? $produtos->first()->preco) * 2,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(4),
            ],
            [
                'cliente_id' => $clientes->skip(5)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->skip(2)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->skip(2)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(2)->first()?->preco ?? $produtos->first()->preco) * 1,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(6),
            ],
            [
                'cliente_id' => $clientes->first()->id,
                'produto_id' => $produtos->skip(1)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->skip(1)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(1)->first()?->preco ?? $produtos->first()->preco) * 1,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(7),
            ],
            [
                'cliente_id' => $clientes->skip(1)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->first()->id,
                'quantidade' => 2,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 2,
                'status' => 'pendente',
                'data_pedido' => now()->subDays(8),
            ],
            
            // 2 pedidos cancelados
            [
                'cliente_id' => $clientes->skip(2)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->first()->preco,
                'total' => $produtos->first()->preco * 1,
                'status' => 'cancelado',
                'data_pedido' => now()->subDays(10),
            ],
            [
                'cliente_id' => $clientes->skip(3)->first()?->id ?? $clientes->first()->id,
                'produto_id' => $produtos->skip(1)->first()?->id ?? $produtos->first()->id,
                'quantidade' => 1,
                'preco_unitario' => $produtos->skip(1)->first()?->preco ?? $produtos->first()->preco,
                'total' => ($produtos->skip(1)->first()?->preco ?? $produtos->first()->preco) * 1,
                'status' => 'cancelado',
                'data_pedido' => now()->subDays(12),
            ],
        ];

        foreach ($pedidos as $pedidoData) {
            $produto = Produto::find($pedidoData['produto_id']);
            
            // Verificar se há estoque suficiente
            if ($produto && $produto->estoque >= $pedidoData['quantidade']) {
                Pedido::create($pedidoData);
                
                // Atualizar estoque
                $produto->decrement('estoque', $pedidoData['quantidade']);
            }
        }
    }
}