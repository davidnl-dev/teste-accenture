@extends('layout.app')

@section('title', 'Logs do Sistema')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Logs do Sistema</h2>
                <div class="text-muted mt-1">Histórico de todas as ações realizadas no sistema</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <button type="button" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/><path d="M12 7v5l3 3"/></svg>
                        Filtros Avançados
                    </button>
                    <a href="{{ route('logs.index') }}" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg>
                        Limpar Filtros
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Cards de Estatísticas --}}
        <div class="row row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <x-card-stats 
                    :value="$estatisticas['total_logs'] . ' logs'" 
                    :icon="'bx bx-history bx-md'" 
                    :description="'Total de Logs'" 
                    :color="'primary'" 
                />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats 
                    :value="$estatisticas['total_criacoes'] . ' criações'" 
                    :icon="'bx bx-plus-circle bx-md'" 
                    :description="'Novos Registros'" 
                    :color="'success'" 
                />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats 
                    :value="$estatisticas['total_atualizacoes'] . ' atualizações'" 
                    :icon="'bx bx-edit bx-md'" 
                    :description="'Registros Modificados'" 
                    :color="'warning'" 
                />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats 
                    :value="$estatisticas['total_exclusoes'] . ' exclusões'" 
                    :icon="'bx bx-trash bx-md'" 
                    :description="'Registros Removidos'" 
                    :color="'danger'" 
                />
            </div>
        </div>

        {{-- Filtros Rápidos --}}
        @if(request()->hasAny(['acao', 'data_inicio', 'data_fim', 'search']))
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Filtros Ativos</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(request('acao'))
                    <div class="col-auto">
                        <span class="badge bg-primary me-2">
                            Ação: {{ $acoesDisponiveis[request('acao')] ?? request('acao') }}
                            <a href="{{ request()->fullUrlWithQuery(['acao' => null]) }}" class="ms-1 text-white">
                                <i class="bx bx-x"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                    @if(request('data_inicio'))
                    <div class="col-auto">
                        <span class="badge bg-info me-2">
                            Data Início: {{ \Carbon\Carbon::parse(request('data_inicio'))->format('d/m/Y') }}
                            <a href="{{ request()->fullUrlWithQuery(['data_inicio' => null]) }}" class="ms-1 text-white">
                                <i class="bx bx-x"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                    @if(request('data_fim'))
                    <div class="col-auto">
                        <span class="badge bg-info me-2">
                            Data Fim: {{ \Carbon\Carbon::parse(request('data_fim'))->format('d/m/Y') }}
                            <a href="{{ request()->fullUrlWithQuery(['data_fim' => null]) }}" class="ms-1 text-white">
                                <i class="bx bx-x"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                    @if(request('search'))
                    <div class="col-auto">
                        <span class="badge bg-secondary me-2">
                            Busca: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ms-1 text-white">
                                <i class="bx bx-x"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Tabela de Logs --}}
        @php
            $colunas = [
                \App\Helpers\TabelaHelper::ordenavel('Ação', 'acao', 'badge'),
                \App\Helpers\TabelaHelper::ordenavel('Descrição', 'descricao', 'texto'),
                \App\Helpers\TabelaHelper::ordenavel('Quantidade', 'quantidade_afetada', 'texto'),
                \App\Helpers\TabelaHelper::ordenavel('Data/Hora', 'executado_em', 'data')
            ];
        @endphp

        <x-tabela 
            titulo="Histórico de Logs"
            :dados="$logs"
            :colunas="$colunas"
            :acoes="false"
        />
    </div>
</div>

{{-- Modal de Filtros Avançados --}}
<div class="modal modal-blur fade" id="modalFiltros" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="GET" action="{{ route('logs.index') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Filtros Avançados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ação</label>
                                <select class="form-select" name="acao">
                                    <option value="">Todas as ações</option>
                                    @foreach($acoesDisponiveis as $valor => $label)
                                        <option value="{{ $valor }}" {{ request('acao') == $valor ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Buscar na Descrição</label>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Digite palavras-chave...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Início</label>
                                <input type="date" class="form-control" name="data_inicio" 
                                       value="{{ request('data_inicio') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data Fim</label>
                                <input type="date" class="form-control" name="data_fim" 
                                       value="{{ request('data_fim') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ordenar por</label>
                                <select class="form-select" name="sort">
                                    <option value="executado_em" {{ request('sort') == 'executado_em' ? 'selected' : '' }}>Data/Hora</option>
                                    <option value="acao" {{ request('sort') == 'acao' ? 'selected' : '' }}>Ação</option>
                                    <option value="descricao" {{ request('sort') == 'descricao' ? 'selected' : '' }}>Descrição</option>
                                    <option value="quantidade_afetada" {{ request('sort') == 'quantidade_afetada' ? 'selected' : '' }}>Quantidade</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Direção</label>
                                <select class="form-select" name="direction">
                                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Crescente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
