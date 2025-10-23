@extends('layout.app')

@section('title', 'Detalhes do Log')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('logs.index') }}">Logs</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
                    </ol>
                </nav>
                <h2 class="page-title">Detalhes do Log</h2>
                <div class="text-muted mt-1">Informações completas sobre esta ação</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('logs.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6"/></svg>
                        Voltar aos Logs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8">
                {{-- Card Principal --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="badge bg-{{ $log->acao == 'create' ? 'success' : ($log->acao == 'update' ? 'primary' : ($log->acao == 'delete' ? 'danger' : 'warning')) }} me-2">
                                {{ $log->acao_formatada }}
                            </span>
                            Log #{{ $log->id }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ação Realizada</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-{{ $log->acao == 'create' ? 'success' : ($log->acao == 'update' ? 'primary' : ($log->acao == 'delete' ? 'danger' : 'warning')) }}">
                                            {{ $log->acao_formatada }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Quantidade Afetada</label>
                                    <div class="form-control-plaintext">
                                        <span class="h4 mb-0">{{ $log->quantidade_afetada }}</span>
                                        <span class="text-muted">registro(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição Completa</label>
                            <div class="form-control-plaintext bg-light p-3 rounded">
                                {{ $log->descricao }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Data e Hora</label>
                                    <div class="form-control-plaintext">
                                        <i class="bx bx-calendar me-1"></i>
                                        {{ $log->data_formatada }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">ID do Log</label>
                                    <div class="form-control-plaintext">
                                        <code>#{{ $log->id }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card de Informações Técnicas --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Informações Técnicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Valor da Ação</label>
                                    <div class="form-control-plaintext">
                                        <code>{{ $log->acao }}</code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Timestamp</label>
                                    <div class="form-control-plaintext">
                                        <code>{{ $log->executado_em->toISOString() }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">JSON Completo</label>
                            <div class="form-control-plaintext">
                                <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Card de Estatísticas --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Tipo de Ação</div>
                            </div>
                            <div class="h3 mb-1">
                                @switch($log->acao)
                                    @case('create')
                                        <span class="text-success">Criação</span>
                                        @break
                                    @case('update')
                                        <span class="text-primary">Atualização</span>
                                        @break
                                    @case('delete')
                                        <span class="text-danger">Exclusão</span>
                                        @break
                                    @case('cancel')
                                        <span class="text-warning">Cancelamento</span>
                                        @break
                                    @default
                                        <span class="text-muted">Desconhecido</span>
                                @endswitch
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Impacto</div>
                            </div>
                            <div class="h3 mb-1">
                                @if($log->quantidade_afetada == 1)
                                    <span class="text-info">Baixo</span>
                                @elseif($log->quantidade_afetada <= 5)
                                    <span class="text-warning">Médio</span>
                                @else
                                    <span class="text-danger">Alto</span>
                                @endif
                            </div>
                            <div class="text-muted">{{ $log->quantidade_afetada }} registro(s) afetado(s)</div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Tempo Decorrido</div>
                            </div>
                            <div class="h3 mb-1">
                                <span class="text-muted">{{ $log->executado_em->diffForHumans() }}</span>
                            </div>
                            <div class="text-muted">{{ $log->executado_em->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Card de Ações Relacionadas --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Ações Relacionadas</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('logs.index', ['acao' => $log->acao]) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bx bx-filter-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Ver logs similares</div>
                                        <div class="text-muted">Filtrar por {{ $log->acao_formatada }}</div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('logs.index', ['data_inicio' => $log->executado_em->format('Y-m-d'), 'data_fim' => $log->executado_em->format('Y-m-d')]) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bx bx-calendar text-info"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Logs do mesmo dia</div>
                                        <div class="text-muted">{{ $log->executado_em->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </a>
                            
                            <a href="{{ route('logs.index') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bx bx-list-ul text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Todos os logs</div>
                                        <div class="text-muted">Voltar para listagem completa</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.form-label.fw-bold {
    font-weight: 600;
    color: #495057;
}
.subheader {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}
pre {
    font-size: 0.875rem;
    max-height: 300px;
    overflow-y: auto;
}
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
</style>
@endpush
