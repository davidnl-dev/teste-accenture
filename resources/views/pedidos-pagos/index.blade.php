@extends('layout.app')

@section('title', 'Pedidos Pagos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Pedidos Pagos</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                    </div>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @php
            $colunas = [
                \App\Helpers\TabelaHelper::texto('Cliente', 'nome_cliente'),
                \App\Helpers\TabelaHelper::link('Produto', 'nome_produto', 'produtos.show'),
                \App\Helpers\TabelaHelper::texto('Quantidade', 'quantidade'),
                \App\Helpers\TabelaHelper::moeda('Preço Unit.', 'preco_unitario'),
                \App\Helpers\TabelaHelper::moeda('Total', 'total'),
                \App\Helpers\TabelaHelper::data('Data Pedido', 'data_pedido'),
                \App\Helpers\TabelaHelper::data('Data Pagamento', 'data_pagamento')
            ];
        @endphp

        <x-tabela 
            titulo="Lista de Pedidos Pagos"
            :dados="$pedidosPagos"
            :colunas="$colunas"
            :acoes="true"
        />
    </div>
</div>
@endsection
