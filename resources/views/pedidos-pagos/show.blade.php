@extends('layout.app')

@section('title', 'Detalhes do Pedido Pago #' . $pedidoPago->id)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Detalhes do Pedido Pago</div>
                <h2 class="page-title">Pedido Pago #{{ $pedidoPago->id }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('pedidos-pagos.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <!-- Cards de Estatísticas -->
        <div class="row row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <i class="bx bx-dollar"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Total do Pedido</div>
                                <div class="text-muted">R$ {{ number_format($pedidoPago->total, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-info text-white avatar">
                                    <i class="bx bx-package"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Quantidade</div>
                                <div class="text-muted">{{ $pedidoPago->quantidade }} unidades</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <i class="bx bx-dollar-circle"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Preço Unitário</div>
                                <div class="text-muted">R$ {{ number_format($pedidoPago->preco_unitario, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <i class="bx bx-check-circle"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Status</div>
                                <div class="text-muted">
                                    <span class="badge bg-success text-white">Pago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="row row-cards">
            <!-- Informações do Pedido -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-shopping-bag me-2"></i>
                            Informações do Pedido
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Seção: Cliente e Produto -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-primary">Cliente</label>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="me-3">
                                            <span class="bg-primary text-white avatar">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <strong class="fs-5">{{ $pedidoPago->nome_cliente }}</strong>
                                            @if($pedidoPago->email_cliente)
                                                <div class="text-muted">{{ $pedidoPago->email_cliente }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-info">Produto</label>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="me-3">
                                            <span class="bg-info text-white avatar">
                                                <i class="bx bx-package"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <strong class="fs-5">{{ $pedidoPago->nome_produto }}</strong>
                                            @if($pedidoPago->descricao_produto)
                                                <div class="text-muted">{{ $pedidoPago->descricao_produto }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Seção: Valores Financeiros -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <label class="form-label fw-bold text-secondary">Quantidade</label>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-package me-2 text-info fs-4"></i>
                                        <span class="fs-4 fw-bold">{{ $pedidoPago->quantidade }} unidades</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <label class="form-label fw-bold text-secondary">Preço Unitário</label>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-dollar-circle me-2 text-success fs-4"></i>
                                        <span class="fs-4 fw-bold text-success">R$ {{ number_format($pedidoPago->preco_unitario, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                    <label class="form-label fw-bold text-primary">Total</label>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-money me-2 text-primary fs-4"></i>
                                        <span class="fs-3 fw-bold text-primary">R$ {{ number_format($pedidoPago->total, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Seção: Datas -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary">Data do Pedido</label>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <i class="bx bx-calendar me-3 text-secondary fs-4"></i>
                                        <span class="fs-5">{{ $pedidoPago->data_pedido ? $pedidoPago->data_pedido->format('d/m/Y H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-success">Data do Pagamento</label>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <i class="bx bx-calendar-check me-3 text-success fs-4"></i>
                                        <span class="fs-5">{{ $pedidoPago->data_pagamento ? $pedidoPago->data_pagamento->format('d/m/Y H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Informações do Sistema -->
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-info-circle me-2"></i>
                            Informações do Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Criado em</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar-plus me-2 text-info"></i>
                                        <span>{{ $pedidoPago->adicionado_em ? $pedidoPago->adicionado_em->format('d/m/Y H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Atualizado em</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar-check me-2 text-success"></i>
                                        <span>{{ $pedidoPago->atualizado_em ? $pedidoPago->atualizado_em->format('d/m/Y H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
