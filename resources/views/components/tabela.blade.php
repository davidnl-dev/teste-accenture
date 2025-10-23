@props([
    'titulo' => 'Tabela',
    'dados' => [],
    'colunas' => [],
    'acoes' => true,
    'busca' => true,
    'paginacao' => true,
])

{{-- Componente de Tabela Reutilizável --}}
{{-- 
    Parâmetros:
    - titulo: Título da tabela
    - dados: Collection/Array de dados
    - colunas: Array com configuração das colunas
    - acoes: Boolean para mostrar coluna de ações
    - busca: Boolean para mostrar campo de busca
    - paginacao: Boolean para mostrar paginação
--}}

<div class="card">
    {{-- Header da Tabela --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="card-title mb-0">{{ $titulo }}</h3>
            @if ($busca)
                <div class="input-group input-group-sm" style="width: 300px; margin-left: auto;">
                    <input type="text" 
                           class="form-control" 
                           placeholder="Digite para buscar..." 
                           id="search-input"
                           value="{{ request('search', '') }}"
                           aria-label="Buscar registros">
                    <button class="btn btn-outline-secondary" 
                            type="button" 
                            id="clear-search"
                            title="Limpar busca">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>


    {{-- Tabela --}}
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            {{-- Cabeçalho da Tabela --}}
            <thead>
                <tr>
                    {{-- Colunas Dinâmicas --}}
                    @foreach ($colunas as $coluna)
                        <th class="text-center" 
                            @if(isset($coluna['ordenavel']) && $coluna['ordenavel'])
                                data-sortable="true" 
                                data-field="{{ $coluna['campo'] }}"
                                style="cursor: pointer;"
                            @endif>
                            {{ $coluna['titulo'] }}
                            @if (isset($coluna['ordenavel']) && $coluna['ordenavel'])
                                @php
                                    $currentSort = request('sort');
                                    $currentDirection = request('direction');
                                    $isActive = $currentSort === $coluna['campo'];
                                @endphp
                                @if($isActive)
                                    @if($currentDirection === 'asc')
                                        <i class='bx bx-sort-up bx-sm align-middle ms-1 text-primary'></i>
                                    @else
                                        <i class='bx bx-sort-down bx-sm align-middle ms-1 text-primary'></i>
                                    @endif
                                @else
                                    <i class='bx bx-sort bx-sm align-middle ms-1'></i>
                                @endif
                            @endif
                        </th>
                    @endforeach

                    {{-- Coluna de Ações --}}
                    @if ($acoes)
                        <th class="text-center">Ações</th>
                    @endif
                </tr>
            </thead>

            {{-- Corpo da Tabela --}}
            <tbody>
                @forelse($dados as $item)
                    <tr>
                        {{-- Células das Colunas --}}
                        @foreach ($colunas as $coluna)
                            <td class="{{ $coluna['alinhamento'] ?? 'text-center' }}">
                                @include('components.tabela.celula', [
                                    'item' => $item,
                                    'coluna' => $coluna,
                                ])
                            </td>
                        @endforeach

                        {{-- Coluna de Ações --}}
                        @if ($acoes)
                            <td class="text-center">
                                @include('components.tabela.acoes', ['item' => $item])
                            </td>
                        @endif
                    </tr>
                @empty
                    {{-- Estado Vazio --}}
                    <tr>
                        <td colspan="{{ count($colunas) + ($acoes ? 1 : 0) }}" class="text-center py-4">
                            <div class="text-muted">Nenhum registro encontrado.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if ($paginacao && $dados->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $dados->links() }}
            </div>
        </div>
    @endif
</div>

{{-- JavaScript para funcionalidades da tabela --}}
@if ($busca || $paginacao)
@push('scripts')
<script src="{{ asset('js/tabela.js') }}"></script>
@endpush
@endif
