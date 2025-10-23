@props([
    'id' => 'modalExcluir',
    'titulo' => 'Confirmar Exclusão',
    'mensagem' => 'Tem certeza que deseja excluir este registro?',
    'itemNome' => '',
    'rota' => '',
    'itemId' => null,
    'cor' => 'danger'
])

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 mt-5">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-{{ $cor }} bg-opacity-10 rounded-circle p-3">
                            <i class="bx bx-trash text-{{ $cor }}" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="{{ $id }}Label">{{ $titulo }}</h5>
                        <small class="text-muted">Esta ação não pode ser desfeita</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body pt-3">
                <div class="alert alert-{{ $cor }} alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bx bx-error-circle me-2 mt-1"></i>
                        <div>
                            <strong>Atenção!</strong>
                            <p class="mb-0 mt-1">{{ $mensagem }}</p>
                            @if($itemNome)
                                <div class="mt-2">
                                    <strong>Item:</strong> <span class="text-dark">{{ $itemNome }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="bg-light rounded p-3 mt-3">
                    <h6 class="mb-2">
                        <i class="bx bx-info-circle me-1"></i>
                        O que acontecerá:
                    </h6>
                    <ul class="mb-0 small text-muted">
                        <li>O registro será <strong>permanentemente removido</strong> do sistema</li>
                        <li>Todos os dados relacionados serão <strong>perdidos</strong></li>
                        <li>Esta ação <strong>não pode ser desfeita</strong></li>
                    </ul>
                </div>
            </div>
            
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>
                    Cancelar
                </button>
                <form id="formExcluir{{ $id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-{{ $cor }}">
                        <i class="bx bx-trash me-1"></i>
                        Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/modal-excluir.js') }}"></script>
@endpush
