@extends('layout.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Editar Cliente</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
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
        <form action="{{ route('clientes.update', $cliente) }}" method="POST" id="clienteForm">
            @csrf
            @method('PUT')
            
            <!-- Informações do Cliente -->
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bx bx-user-edit me-2"></i>
                                Informações do Cliente
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label required">Nome Completo</label>
                                        <input type="text" 
                                               class="form-control @error('nome') is-invalid @enderror" 
                                               name="nome" 
                                               value="{{ old('nome', $cliente->nome) }}" 
                                               placeholder="Digite o nome completo do cliente"
                                               required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label required">E-mail</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email" 
                                               value="{{ old('email', $cliente->email) }}"
                                               placeholder="cliente@exemplo.com"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Data de Cadastro</label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="data_cadastro" 
                                               value="{{ $cliente->data_cadastro }}"
                                               readonly
                                               style="background-color: #f8f9fa;">
                                        <small class="text-muted">
                                            <i class="bx bx-info-circle me-1"></i>
                                            Data não pode ser alterada
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   name="status" 
                                                   value="1" 
                                                   id="statusSwitch"
                                                   {{ old('status', $cliente->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusSwitch">
                                                Cliente ativo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bx bx-x me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                Atualizar Cliente
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
<script src="{{ asset('js/clientes.js') }}"></script>
@endpush
