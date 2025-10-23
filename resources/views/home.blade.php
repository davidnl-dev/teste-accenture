@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Dashboard</div>
                <h2 class="page-title">Bem-vindo ao Sistema de Gerenciamento</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="{{ route('pedidos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Novo Pedido
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
                <x-card-stats :value="$totalClientes . ' clientes'" :icon="'bx bx-user bx-md'" :description="'Total de Clientes'" :color="'primary'" />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats :value="$totalProdutos . ' produtos'" :icon="'bx bx-cube bx-md'" :description="'Total de Produtos'" :color="'warning'" />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats :value="$totalPedidosPendentes . ' pedidos'" :icon="'bx bx-clock-3 bx-md'" :description="'Pedidos Pendentes'" :color="'danger'" />
            </div>
            <div class="col-sm-6 col-lg-3">
                <x-card-stats :value="$totalPedidosPagos . ' pedidos pagos'" :icon="'bx bx-check-circle bx-md'" :description="'Pedidos Pagos'" :color="'success'" />
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row row-cards mb-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produtos Mais Vendidos</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-produtos-vendidos"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Status dos Pedidos</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-status-pedidos"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Últimos Pedidos -->
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Últimos 5 Pedidos</h3>
                        <div class="card-actions">
                            <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-list-ul icon"></i>
                                Ver Todos
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosPedidos as $pedido)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="bg-primary text-white avatar avatar-sm me-2">
                                                    {{ strtoupper(substr($pedido['cliente_nome'], 0, 1)) }}
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">{{ $pedido['cliente_nome'] }}</div>
                                                    <div class="text-muted">{{ $pedido['cliente_email'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $pedido['produto_nome'] }}</td>
                                        <td>{{ $pedido['quantidade'] }}</td>
                                        <td>R$ {{ number_format($pedido['total'], 2, ',', '.') }}</td>
                                        <td>
                                            @if($pedido['status'] === 'pago')
                                                <span class="badge bg-success text-white">Pago</span>
                                            @elseif($pedido['status'] === 'pendente')
                                                <span class="badge bg-warning text-white">Pendente</span>
                                            @else
                                                <span class="badge bg-danger text-white">Cancelado</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($pedido['data_pedido'])->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($pedido['tipo'] === 'pedido')
                                                <a href="{{ route('pedidos.show', $pedido['id']) }}" class="btn btn-action">
                                                    <i class="bx bx-eye-alt icon"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('pedidos-pagos.show', $pedido['id']) }}" class="btn btn-action">
                                                    <i class="bx bx-eye-alt icon"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">Nenhum pedido encontrado.</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Disponibilizar dados para o JavaScript externo
    window.statusPedidos = @json($statusPedidos);
    window.produtosMaisVendidos = @json($produtosMaisVendidos);
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
