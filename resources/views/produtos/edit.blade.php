@extends('layout.app')

@section('title', 'Editar Produto')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Editar Produto</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
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
        <form action="{{ route('produtos.update', $produto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Seção da Imagem -->
            <div class="row row-cards mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bx bx-image me-2"></i>
                                Imagem do Produto
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <!-- Imagem Atual ou Área de Upload -->
                            @if($produto->imagem)
                                <div id="currentImage" class="mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $produto->imagem) }}" 
                                             alt="{{ $produto->nome }}" 
                                             class="img-fluid rounded shadow" 
                                             style="max-height: 300px; max-width: 100%;"
                                             id="currentImg">
                                        <button type="button" 
                                                class="btn btn-sm btn-primary position-absolute top-0 end-0 m-2" 
                                                onclick="changeImage()"
                                                title="Alterar imagem">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Imagem atual</small>
                                    </div>
                                </div>
                            @endif

                            <!-- Área de Upload (oculta se há imagem atual) -->
                            <div class="mb-4 {{ $produto->imagem ? 'd-none' : '' }}" id="uploadArea">
                                <div class="upload-area">
                                    <div class="upload-content">
                                        <i class="bx bx-cloud-upload" style="font-size: 3rem; color: #6c757d;"></i>
                                        <h4 class="mt-3">Arraste uma imagem aqui</h4>
                                        <p class="text-muted">ou clique para selecionar</p>
                                        <input type="file" 
                                               class="form-control @error('imagem') is-invalid @enderror" 
                                               name="imagem" 
                                               id="imageInput"
                                               accept="image/*"
                                               style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;">
                                        @error('imagem')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pré-visualização da Nova Imagem -->
                            <div id="imagePreview" class="d-none">
                                <div class="position-relative d-inline-block">
                                    <img id="previewImg" 
                                         class="img-fluid rounded shadow" 
                                         style="max-height: 300px; max-width: 100%;"
                                         alt="Pré-visualização">
                                    <button type="button" 
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                                            onclick="removeNewImage()"
                                            title="Remover nova imagem">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <small class="text-success">Nova imagem selecionada</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações do Produto -->
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bx bx-info-circle me-2"></i>
                                Informações do Produto
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nome do Produto</label>
                                        <input type="text" 
                                               class="form-control @error('nome') is-invalid @enderror" 
                                               name="nome" 
                                               value="{{ old('nome', $produto->nome) }}" 
                                               placeholder="Digite o nome do produto"
                                               required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Categoria</label>
                                        <input type="text" 
                                               class="form-control @error('categoria') is-invalid @enderror" 
                                               name="categoria" 
                                               value="{{ old('categoria', $produto->categoria) }}"
                                               placeholder="Ex: Eletrônicos, Roupas, etc.">
                                        @error('categoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                          name="descricao" 
                                          rows="4"
                                          placeholder="Descreva o produto...">{{ old('descricao', $produto->descricao) }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Preço</label>
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input type="number" 
                                                   step="0.01" 
                                                   min="0" 
                                                   class="form-control @error('preco') is-invalid @enderror" 
                                                   name="preco" 
                                                   value="{{ old('preco', $produto->preco) }}" 
                                                   placeholder="0,00"
                                                   required>
                                            @error('preco')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Estoque</label>
                                        <input type="number" 
                                               min="0" 
                                               class="form-control @error('estoque') is-invalid @enderror" 
                                               name="estoque" 
                                               value="{{ old('estoque', $produto->estoque) }}" 
                                               placeholder="0"
                                               required>
                                        @error('estoque')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   name="ativo" 
                                                   value="1" 
                                                   id="statusSwitch"
                                                   {{ old('ativo', $produto->ativo) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusSwitch">
                                                Produto ativo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bx bx-x me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                Atualizar Produto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    position: relative;
}

.upload-area:hover {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.upload-area.dragover {
    border-color: #007bff;
    background-color: #e3f2fd;
    transform: scale(1.02);
}

.upload-content {
    pointer-events: none;
}
</style>

@endsection

@push('scripts')
<script src="{{ asset('js/produtos.js') }}"></script>
@endpush
