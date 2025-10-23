{{-- Componente para renderizar ações da tabela --}}
{{-- 
    Parâmetros:
    - item: Item atual da tabela
--}}

<div class="dropdown">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
            data-bs-toggle="dropdown" 
            aria-expanded="false">
        <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    
    <ul class="dropdown-menu dropdown-menu-end" 
        style="z-index: 9999; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border: 1px solid rgba(0, 0, 0, 0.1);">
        
        {{-- Ações específicas para logs --}}
        @if(Route::currentRouteName() === 'logs.index')
            {{-- Ação: Ver Detalhes --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route('logs.show', $item->id) }}">
                    <i class="bx bx-eye-alt me-2"></i>
                    Ver Detalhes
                </a>
            </li>
            
            {{-- Ação: Filtrar por Ação --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route('logs.index', ['acao' => $item->acao]) }}">
                    <i class="bx bx-filter-alt me-2"></i>
                    Ver Logs Similares
                </a>
            </li>
            
            {{-- Ação: Filtrar por Data --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route('logs.index', ['data_inicio' => $item->executado_em->format('Y-m-d'), 'data_fim' => $item->executado_em->format('Y-m-d')]) }}">
                    <i class="bx bx-calendar me-2"></i>
                    Logs do Mesmo Dia
                </a>
            </li>
        {{-- Ações específicas para pedidos pagos (só visualização) --}}
        @elseif(Route::currentRouteName() === 'pedidos-pagos.index')
            {{-- Ação: Ver --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route('pedidos-pagos.show', $item->id) }}">
                    <i class="bx bx-eye-alt me-2"></i>
                    Ver Detalhes
                </a>
            </li>
        @else
            {{-- Ação: Ver --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route(str_replace('.index', '.show', Route::currentRouteName()), $item->id) }}">
                    <i class="bx bx-eye-alt me-2"></i>
                    Ver
                </a>
            </li>

            {{-- Ação: Editar --}}
            <li>
                <a class="dropdown-item"
                   href="{{ route(str_replace('.index', '.edit', Route::currentRouteName()), $item->id) }}">
                    <i class="bx bx-edit me-2"></i>
                    Editar
                </a>
            </li>

            {{-- Ação Específica: Toggle Status (para clientes e produtos) --}}
            @if(Route::currentRouteName() === 'clientes.index')
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('clientes.toggle-status', $item->id) }}"
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="dropdown-item {{ $item->status ? 'text-warning' : 'text-success' }}">
                            <i class="bx {{ $item->status ? 'bx-x-circle' : 'bx-check-circle' }} me-2"></i>
                            {{ $item->status ? 'Desativar' : 'Ativar' }}
                        </button>
                    </form>
                </li>
            @elseif(Route::currentRouteName() === 'produtos.index')
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('produtos.toggle-status', $item->id) }}"
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="dropdown-item {{ $item->ativo ? 'text-danger' : 'text-success' }}">
                            <i class="bx {{ $item->ativo ? 'bx-x-circle' : 'bx-check-circle' }} me-2"></i>
                            {{ $item->ativo ? 'Desativar' : 'Ativar' }}
                        </button>
                    </form>
                </li>
            @endif

            {{-- Separador --}}
            <li><hr class="dropdown-divider"></li>

            {{-- Ação: Excluir --}}
            <li>
                <button type="button" 
                        class="dropdown-item text-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalExcluir"
                        data-item-id="{{ $item->id }}"
                        data-item-nome="{{ $item->nome ?? $item->nome_cliente ?? 'Registro' }}"
                        data-rota="{{ route(str_replace('.index', '.destroy', Route::currentRouteName()), ':id') }}">
                    <i class="bx bx-trash me-2"></i>
                    Excluir
                </button>
            </li>
        @endif
    </ul>
</div>

<style>
/* Garantir que o dropdown apareça acima de tudo */
.dropdown-menu {
    z-index: 9999 !important;
    max-height: 300px;
    overflow-y: auto;
}

/* Melhorar aparência dos itens do dropdown */
.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    transition: all 0.15s ease-in-out;
    display: flex;
    align-items: center;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.dropdown-item.text-danger:hover {
    background-color: #f8d7da;
    color: #721c24;
}

.dropdown-item.text-warning:hover {
    background-color: #fff3cd;
    color: #856404;
}

.dropdown-item.text-success:hover {
    background-color: #d1e7dd;
    color: #0f5132;
}

/* Ícones nos itens */
.dropdown-item i {
    width: 16px;
    height: 16px;
    margin-right: 0.5rem;
    flex-shrink: 0;
    font-size: 16px;
}

/* Separador melhorado */
.dropdown-divider {
    margin: 0.25rem 0;
    border-color: rgba(0, 0, 0, 0.1);
}
</style>
