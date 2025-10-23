@extends('layout.app')

@section('title', $produto->nome)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Produto</div>
                <h2 class="page-title">{{ $produto->nome }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i>
                        Editar Produto
                    </a>
                    <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">
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
                                    <i class="bx bx-dollar-circle"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Preço</div>
                                <div class="text-muted">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
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
                                <span class="bg-warning text-white avatar">
                                    <i class="bx bx-package"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Estoque</div>
                                <div class="text-muted">{{ $produto->estoque }} unidades</div>
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
                                    <i class="bx bx-tabs"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Categoria</div>
                                <div class="text-muted">{{ $produto->categoria ?? 'Não informado' }}</div>
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
                                <span class="bg-{{ $produto->ativo ? 'success' : 'danger' }} text-white avatar">
                                    <i class="bx {{ $produto->ativo ? 'bx-check-circle' : 'bx-x-circle' }}"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Status</div>
                                <div class="text-muted">
                                    @if($produto->ativo)
                                        <span class="badge bg-success text-white">Ativo</span>
                                    @else
                                        <span class="badge bg-danger text-white">Inativo</span>
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
                        @if($produto->imagem)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                     alt="{{ $produto->nome }}" 
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

            <!-- Informações Detalhadas -->
            <div class="col-lg-8 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-info-circle me-2"></i>
                            Informações Detalhadas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Nome do Produto</label>
                                    <div class="fs-4 fw-semibold text-primary">{{ $produto->nome }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Categoria</label>
                                    <div class="fs-5">
                                        @if($produto->categoria)
                                            <span class="badge bg-info text-white fs-6">{{ $produto->categoria }}</span>
                                        @else
                                            <span class="text-muted">Não informado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($produto->descricao)
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Descrição</label>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $produto->descricao }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Preço Unitário</label>
                                    <div class="fs-3 fw-bold text-success">R$ {{ number_format($produto->preco, 2, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Estoque Disponível</label>
                                    <div class="fs-3 fw-bold {{ $produto->estoque > 10 ? 'text-success' : ($produto->estoque > 0 ? 'text-warning' : 'text-danger') }}">
                                        {{ $produto->estoque }}
                                        <small class="fs-6 text-muted">unidades</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Status</label>
                                    <div class="fs-5">
                                        @if($produto->ativo)
                                            <span class="badge bg-success text-white fs-6">
                                                <i class="bx bx-check-circle me-1"></i>
                                                Ativo
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white fs-6">
                                                <i class="bx bx-x-circle me-1"></i>
                                                Inativo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações do Sistema -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bx bx-time me-2"></i>
                            Informações do Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Data de Criação</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar-plus me-2 text-primary"></i>
                                        <span>{{ $produto->adicionado_em ? $produto->adicionado_em->format('d/m/Y') : 'N/A' }}</span>
                                        <small class="text-muted ms-2">{{ $produto->adicionado_em ? $produto->adicionado_em->format('H:i') : '' }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Última Atualização</label>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-calendar-edit me-2 text-warning"></i>
                                        <span>{{ $produto->atualizado_em ? $produto->atualizado_em->format('d/m/Y') : 'N/A' }}</span>
                                        <small class="text-muted ms-2">{{ $produto->atualizado_em ? $produto->atualizado_em->format('H:i') : '' }}</small>
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
@if($produto->imagem)
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $produto->nome }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $produto->imagem) }}" 
                     alt="{{ $produto->nome }}" 
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
