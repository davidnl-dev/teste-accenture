@extends('layout.app')

@section('title', 'Novo Pedido')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Novo Pedido</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
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
        <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoForm">
            @csrf
            
            <!-- Informações do Pedido -->
            <div class="row row-cards">
                <div class="col-12">
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
                                        <label class="form-label required">Cliente</label>
                                        <select class="form-select @error('cliente_id') is-invalid @enderror" 
                                                name="cliente_id" required>
                                            <option value="">Selecione um cliente</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" 
                                                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->nome }} - {{ $cliente->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cliente_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label required">Produto</label>
                                        <select class="form-select @error('produto_id') is-invalid @enderror" 
                                                name="produto_id" required id="produto-select">
                                            <option value="">Selecione um produto</option>
                                            @foreach($produtos as $produto)
                                                <option value="{{ $produto->id }}" 
                                                        data-preco="{{ $produto->preco }}"
                                                        data-estoque="{{ $produto->estoque }}"
                                                        {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                                    {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }} 
                                                    (Estoque: {{ $produto->estoque }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('produto_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label required">Quantidade</label>
                                        <input type="number" min="1" 
                                               class="form-control @error('quantidade') is-invalid @enderror" 
                                               name="quantidade" value="{{ old('quantidade', 1) }}" 
                                               required id="quantidade-input"
                                               placeholder="Digite a quantidade">
                                        @error('quantidade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label">Preço Unitário</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="text" class="form-control" id="preco-unitario" readonly
                                                   style="background-color: #f8f9fa;">
                                        </div>
                                        <small class="text-muted">
                                            <i class="bx bx-info-circle me-1"></i>
                                            Preço definido pelo produto
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label class="form-label">Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="text" class="form-control" id="total" readonly
                                                   style="background-color: #f8f9fa;">
                                        </div>
                                        <small class="text-muted">
                                            <i class="bx bx-calculator me-1"></i>
                                            Calculado automaticamente
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                name="status">
                                            <option value="pendente" {{ old('status', 'pendente') == 'pendente' ? 'selected' : '' }}>
                                                <i class="bx bx-time me-1"></i>Pendente
                                            </option>
                                            <option value="pago" {{ old('status') == 'pago' ? 'selected' : '' }}>
                                                <i class="bx bx-check-circle me-1"></i>Pago
                                            </option>
                                            <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>
                                                <i class="bx bx-x-circle me-1"></i>Cancelado
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Estoque Disponível</label>
                                        <div class="form-control-plaintext bg-light rounded p-2" id="estoque-disponivel">
                                            <i class="bx bx-package me-1"></i>
                                            Selecione um produto
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bx bx-x me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                Salvar Pedido
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pedidos.js') }}"></script>
@endpush
