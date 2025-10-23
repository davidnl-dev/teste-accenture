<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        $estatisticas = $this->dashboardService->getEstatisticas();
        $ultimosPedidos = $this->dashboardService->getUltimosPedidos();
        $statusPedidos = $this->dashboardService->getStatusPedidos();
        $produtosMaisVendidos = $this->dashboardService->getProdutosMaisVendidos();

        // Extrair variáveis individuais para compatibilidade com a view
        $totalClientes = $estatisticas['total_clientes'];
        $totalProdutos = $estatisticas['total_produtos'];
        $totalPedidosPendentes = $estatisticas['total_pedidos_pendentes'];
        $totalPedidosPagos = $estatisticas['total_pedidos_pagos'];

        return view('home', compact(
            'totalClientes',
            'totalProdutos',
            'totalPedidosPendentes',
            'totalPedidosPagos',
            'ultimosPedidos',
            'statusPedidos',
            'produtosMaisVendidos'
        ));
    }
}
