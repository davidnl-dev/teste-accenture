@extends('layout.app')

@section('title', 'Pedidos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Pedidos</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('pedidos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Novo Pedido
                    </a>
                </div>
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
                \App\Helpers\TabelaHelper::link('Cliente', 'cliente.nome', 'pedidos.show'),
                \App\Helpers\TabelaHelper::texto('Produto', 'produto.nome'),
                \App\Helpers\TabelaHelper::texto('Quantidade', 'quantidade'),
                \App\Helpers\TabelaHelper::moeda('Preço Unit.', 'preco_unitario'),
                \App\Helpers\TabelaHelper::moeda('Total', 'total'),
                \App\Helpers\TabelaHelper::badge('Status', 'status', \App\Helpers\TabelaHelper::coresStatusPedidos()),
                \App\Helpers\TabelaHelper::data('Data', 'data_pedido')
            ];
        @endphp

        <x-tabela 
            titulo="Lista de Pedidos"
            :dados="$pedidos"
            :colunas="$colunas"
        />
    </div>
</div>

{{-- Modal de Confirmação de Exclusão --}}
<x-modal-excluir 
    id="modalExcluir"
    titulo="Excluir Pedido"
    mensagem="Tem certeza que deseja excluir este pedido? Todos os dados relacionados serão perdidos."
    cor="danger"
/>

@endsection
