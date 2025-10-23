<?php

namespace App\Console\Commands;

use App\Models\Pedido;
use App\Models\PedidoPago;
use Illuminate\Console\Command;

class MoverPedidosPagos extends Command
{
    protected $signature = 'pedidos:mover-pagos';
    protected $description = 'Move pedidos pagos da tabela pedidos para pedidos_pagos';

    public function handle()
    {
        $pedidosPagos = Pedido::where('status', 'pago')->with(['cliente', 'produto'])->get();
        
        foreach ($pedidosPagos as $pedido) {
            PedidoPago::create([
                'nome_cliente' => $pedido->cliente->nome,
                'email_cliente' => $pedido->cliente->email,
                'nome_produto' => $pedido->produto->nome,
                'descricao_produto' => $pedido->produto->descricao,
                'quantidade' => $pedido->quantidade,
                'preco_unitario' => $pedido->preco_unitario,
                'total' => $pedido->total,
                'data_pedido' => $pedido->data_pedido,
                'data_pagamento' => now(),
                'metodo_pagamento' => 'Dinheiro'
            ]);
            
            $pedido->delete();
        }
        
        $this->info("Movidos {$pedidosPagos->count()} pedidos pagos com sucesso!");
    }
}
