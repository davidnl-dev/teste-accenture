@extends('layout.app')

@section('title', 'Produtos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Produtos</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('produtos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Novo Produto
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
                \App\Helpers\TabelaHelper::imagem('Imagem', 'imagem'),
                \App\Helpers\TabelaHelper::link('Nome', 'nome', 'produtos.show'),
                \App\Helpers\TabelaHelper::texto('Categoria', 'categoria'),
                \App\Helpers\TabelaHelper::moeda('Preço', 'preco'),
                \App\Helpers\TabelaHelper::texto('Estoque', 'estoque'),
                \App\Helpers\TabelaHelper::badge('Status', 'ativo', \App\Helpers\TabelaHelper::coresStatus()),
                \App\Helpers\TabelaHelper::data('Criado em', 'adicionado_em')
            ];
        @endphp

        <x-tabela 
            titulo="Lista de Produtos"
            :dados="$produtos"
            :colunas="$colunas"
        />
    </div>
</div>

{{-- Modal de Confirmação de Exclusão --}}
<x-modal-excluir 
    id="modalExcluir"
    titulo="Excluir Produto"
    mensagem="Tem certeza que deseja excluir este produto? Todos os dados relacionados serão perdidos."
    cor="danger"
/>

@endsection
