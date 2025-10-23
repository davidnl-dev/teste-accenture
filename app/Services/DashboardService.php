<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;
use App\Models\PedidoPago;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Obter estatísticas gerais do dashboard
     */
    public function getEstatisticas(): array
    {
        return [
            'total_clientes' => Cliente::count(),
            'total_produtos' => Produto::count(),
            'total_pedidos' => Pedido::count() + PedidoPago::count(),
            'total_pedidos_pendentes' => Pedido::pendentes()->count(),
            'total_pedidos_pagos' => PedidoPago::count(),
            'total_pedidos_cancelados' => Pedido::cancelados()->count(),
        ];
    }

    /**
     * Obter últimos pedidos combinados
     */
    public function getUltimosPedidos(int $limit = 5): Collection
    {
        $pedidosNaoPagos = $this->formatarPedidosNaoPagos();
        $pedidosPagos = $this->formatarPedidosPagos();

        return $pedidosNaoPagos
            ->concat($pedidosPagos)
            ->sortByDesc('data_pedido')
            ->take($limit)
            ->values();
    }

    /**
     * Obter dados para gráfico de status dos pedidos
     */
    public function getStatusPedidos(): array
    {
        $estatisticas = $this->getEstatisticas();
        
        return [
            'Pendentes' => $estatisticas['total_pedidos_pendentes'],
            'Pagos' => $estatisticas['total_pedidos_pagos'],
            'Cancelados' => $estatisticas['total_pedidos_cancelados']
        ];
    }

    /**
     * Obter produtos mais vendidos
     */
    public function getProdutosMaisVendidos(int $limit = 5): Collection
    {
        return PedidoPago::selectRaw('nome_produto, SUM(quantidade) as total_vendido')
            ->groupBy('nome_produto')
            ->orderBy('total_vendido', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'nome' => $item->nome_produto,
                    'quantidade' => $item->total_vendido
                ];
            });
    }

    /**
     * Formatar pedidos não pagos para exibição
     */
    private function formatarPedidosNaoPagos(): Collection
    {
        return Pedido::with(['cliente', 'produto'])
            ->get()
            ->map(function ($pedido) {
                return [
                    'id' => $pedido->id,
                    'cliente_nome' => $pedido->cliente->nome,
                    'cliente_email' => $pedido->cliente->email,
                    'produto_nome' => $pedido->produto->nome,
                    'quantidade' => $pedido->quantidade,
                    'total' => $pedido->total,
                    'status' => $pedido->status,
                    'data_pedido' => $pedido->created_at,
                    'tipo' => 'pedido'
                ];
            });
    }

    /**
     * Formatar pedidos pagos para exibição
     */
    private function formatarPedidosPagos(): Collection
    {
        return PedidoPago::all()
            ->map(function ($pedido) {
                return [
                    'id' => $pedido->id,
                    'cliente_nome' => $pedido->nome_cliente,
                    'cliente_email' => $pedido->email_cliente,
                    'produto_nome' => $pedido->nome_produto,
                    'quantidade' => $pedido->quantidade,
                    'total' => $pedido->total,
                    'status' => Pedido::STATUS_PAGO,
                    'data_pedido' => $pedido->data_pedido,
                    'tipo' => 'pedido_pago'
                ];
            });
    }
}
