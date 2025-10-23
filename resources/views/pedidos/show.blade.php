@extends('layout.app')

@section('title', 'Pedido #' . $pedido->id)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Pedido</div>
                <h2 class="page-title">Pedido #{{ $pedido->id }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i>
                        Editar Pedido
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">
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
                                <div class="text-muted">R$ {{ number_format($pedido->total, 2, ',', '.') }}</div>
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
                                <div class="text-muted">{{ $pedido->quantidade }} unidades</div>
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
                                <div class="text-muted">R$ {{ number_format($pedido->preco_unitario, 2, ',', '.') }}</div>
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
                                <span class="bg-{{ $pedido->status === 'pago' ? 'success' : ($pedido->status === 'pendente' ? 'warning' : 'danger') }} text-white avatar">
                                    <i class="bx bx-{{ $pedido->status === 'pago' ? 'check-circle' : ($pedido->status === 'pendente' ? 'clock-3' : 'x-circle') }}"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Status</div>
                                <div class="text-muted">
                                    @if($pedido->status === 'pago')
                                        <span class="badge bg-success text-white">Pago</span>
                                    @elseif($pedido->status === 'pendente')
                                        <span class="badge bg-warning text-white">Pendente</span>
                                    @else
                                        <span class="badge bg-danger text-white">Cancelado</span>
                                    @endif
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
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-shopping-bag me-2"></i>
                            Informações do Pedido
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Cliente</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-primary text-white avatar">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <a href="{{ route('clientes.show', $pedido->cliente) }}" class="text-decoration-none">
                                                <strong>{{ $pedido->cliente->nome }}</strong>
                                            </a>
                                            <div class="text-muted small">{{ $pedido->cliente->email }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Produto</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-info text-white avatar">
                                                <i class="bx bx-package"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <a href="{{ route('produtos.show', $pedido->produto) }}" class="text-decoration-none">
                                                <strong>{{ $pedido->produto->nome }}</strong>
                                            </a>
                                            <div class="text-muted small">{{ $pedido->produto->categoria }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Quantidade</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-package me-2 text-info"></i>
                                        <span class="fs-5">{{ $pedido->quantidade }} unidades</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Preço Unitário</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-dollar-circle me-2 text-success"></i>
                                        <span class="fs-5">R$ {{ number_format($pedido->preco_unitario, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Total</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-money me-2 text-primary"></i>
                                        <span class="fs-5 fw-bold text-primary">R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Data do Pedido</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar me-2 text-secondary"></i>
                                        <span>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Status Atual</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-{{ $pedido->status === 'pago' ? 'check-circle' : ($pedido->status === 'pendente' ? 'time' : 'clock-3') }} me-2 text-{{ $pedido->status === 'pago' ? 'success' : ($pedido->status === 'pendente' ? 'warning' : 'danger') }}"></i>
                                        @if($pedido->status === 'pago')
                                            <span class="badge bg-success text-white fs-6">Pago</span>
                                        @elseif($pedido->status === 'pendente')
                                            <span class="badge bg-warning text-white fs-6">Pendente</span>
                                        @else
                                            <span class="badge bg-danger text-white fs-6">Cancelado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Imagem do Produto -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-image me-2"></i>
                            Imagem do Produto
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($pedido->produto->imagem)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $pedido->produto->imagem) }}" 
                                     alt="{{ $pedido->produto->nome }}" 
                                     class="img-fluid w-100 rounded-top" 
                                     style="height: 300px; object-fit: contain;"
                                     id="productImage">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <button class="btn btn-sm btn-white" 
                                            onclick="toggleImageSize()" 
                                            title="Ampliar imagem">
                                        <i class="bx bx-zoom-in"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top" 
                                 style="height: 300px;">
                                <div class="text-center text-muted">
                                    <i class="bx bx-image-add" style="font-size: 3rem;"></i>
                                    <div class="mt-2">Sem imagem</div>
                                </div>
                            </div>
                        @endif
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
                                        <span>{{ $pedido->adicionado_em ? $pedido->adicionado_em->format('d/m/Y H:i') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Atualizado em</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar-check me-2 text-success"></i>
                                        <span>{{ $pedido->atualizado_em ? $pedido->atualizado_em->format('d/m/Y H:i') : 'N/A' }}</span>
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

<!-- Modal para imagem ampliada -->
@if($pedido->produto->imagem)
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imagem do Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $pedido->produto->imagem) }}" 
                     alt="{{ $pedido->produto->nome }}" 
                     class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="{{ asset('js/imagens.js') }}"></script>
@endpush
