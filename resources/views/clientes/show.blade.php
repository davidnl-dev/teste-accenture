@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Detalhes do Cliente</h2>
                <div>
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informações do Cliente</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $cliente->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nome:</th>
                                    <td>{{ $cliente->nome }}</td>
                                </tr>
                                <tr>
                                    <th>E-mail:</th>
                                    <td>{{ $cliente->email }}</td>
                                </tr>
                                <tr>
                                    <th>Data Cadastro:</th>
                                    <td>{{ \Carbon\Carbon::parse($cliente->data_cadastro)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($cliente->status)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-danger">Inativo</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Pedidos do Cliente</h5>
                        </div>
                        <div class="card-body">
                            @if($cliente->pedidos->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data</th>
                                                <th>Valor</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cliente->pedidos as $pedido)
                                                <tr>
                                                    <td>{{ $pedido->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y') }}</td>
                                                    <td>R$ {{ number_format($pedido->valor_pedido, 2, ',', '.') }}</td>
                                                    <td>
                                                        @switch($pedido->status)
                                                            @case('pendente')
                                                                <span class="badge bg-warning">Pendente</span>
                                                                @break
                                                            @case('pago')
                                                                <span class="badge bg-success">Pago</span>
                                                                @break
                                                            @case('cancelado')
                                                                <span class="badge bg-danger">Cancelado</span>
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted mb-0">Nenhum pedido encontrado para este cliente.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
