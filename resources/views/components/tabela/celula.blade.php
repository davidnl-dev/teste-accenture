{{-- Componente para renderizar células da tabela --}}
{{-- 
    Parâmetros:
    - item: Item atual da tabela
    - coluna: Configuração da coluna
--}}

@php
    $tipo = $coluna['tipo'] ?? 'texto';
    $campo = $coluna['campo'];
@endphp

{{-- Tipo: Imagem --}}
@if($tipo === 'imagem')
    @if($item->{$campo})
        <img src="{{ asset('storage/' . $item->{$campo}) }}" 
             alt="{{ $item->{$campo} }}" 
             class="img-thumbnail"
             style="width: 50px; height: 50px; object-fit: cover;">
    @else
        <div class="bg-light d-flex align-items-center justify-content-center" 
             style="width: 50px; height: 50px;">
            <span class="text-muted">Sem imagem</span>
        </div>
    @endif

{{-- Tipo: Badge --}}
@elseif($tipo === 'badge')
    @php
        $valor = $item->{$campo};
        $classe = 'bg-secondary text-white';
        $icone = '';
        $texto = '';
        
        // Aplicar cores personalizadas se definidas
        if (isset($coluna['cores'][$valor])) {
            $classe = $coluna['cores'][$valor] . ' text-white';
        }
        
        // Lógica para ações de logs
        if ($campo === 'acao') {
            switch ($valor) {
                case 'create':
                    $classe = 'bg-success text-white';
                    $icone = '<i class="fas fa-plus-circle me-1"></i>';
                    $texto = 'Criado';
                    break;
                case 'update':
                    $classe = 'bg-primary text-white';
                    $icone = '<i class="fas fa-edit me-1"></i>';
                    $texto = 'Atualizado';
                    break;
                case 'delete':
                    $classe = 'bg-danger text-white';
                    $icone = '<i class="fas fa-trash me-1"></i>';
                    $texto = 'Excluído';
                    break;
                case 'cancel':
                    $classe = 'bg-warning text-white';
                    $icone = '<i class="fas fa-ban me-1"></i>';
                    $texto = 'Cancelado';
                    break;
                default:
                    $texto = ucfirst($valor);
            }
        }
        // Lógica para status específicos
        elseif (in_array($campo, ['status', 'ativo'])) {
            // Status ativo/inativo (clientes/produtos) - verificar primeiro
            if ($valor == 1 || $valor === true || $valor === '1') {
                $icone = '<i class="fas fa-check-circle me-1"></i>';
                $texto = 'Ativo';
            } elseif ($valor == 0 || $valor === false || $valor === '0') {
                $icone = '<i class="fas fa-times-circle me-1"></i>';
                $texto = 'Inativo';
            }
            // Status de pedidos - verificar depois
            elseif (in_array($valor, ['pendente', 'pago', 'cancelado'])) {
                switch ($valor) {
                    case 'pendente':
                        $icone = '<i class="fas fa-clock me-1"></i>';
                        $texto = 'Pendente';
                        break;
                    case 'pago':
                        $icone = '<i class="fas fa-check-circle me-1"></i>';
                        $texto = 'Pago';
                        break;
                    case 'cancelado':
                        $icone = '<i class="fas fa-times-circle me-1"></i>';
                        $texto = 'Cancelado';
                        break;
                }
            } else {
                $texto = $valor;
            }
        } else {
            $texto = $valor;
        }
    @endphp
    <span class="badge {{ $classe }}">
        {!! $icone !!}{{ $texto }}
    </span>

{{-- Tipo: Moeda --}}
@elseif($tipo === 'moeda')
    R$ {{ number_format($item->{$campo}, 2, ',', '.') }}

{{-- Tipo: Data --}}
@elseif($tipo === 'data')
    {{ \Carbon\Carbon::parse($item->{$campo})->format('d/m/Y') }}

{{-- Tipo: Avatar --}}
@elseif($tipo === 'avatar')
    <div class="d-flex align-items-center">
        <span class="bg-primary text-white avatar avatar-sm me-2">
            {{ strtoupper(substr($item->{$campo}, 0, 1)) }}
        </span>
        <div>
            <div class="font-weight-medium">{{ $item->{$campo} }}</div>
            @if(isset($coluna['subcampo']))
                <div class="text-muted">{{ $item->{$coluna['subcampo']} }}</div>
            @endif
        </div>
    </div>

{{-- Tipo: Olho --}}
@elseif($tipo === 'olho')
    @php
        $valor = $item->{$campo};
        
        // Suporte para relacionamentos (ex: cliente.nome)
        if (strpos($campo, '.') !== false) {
            $partes = explode('.', $campo);
            $valor = $item;
            foreach ($partes as $parte) {
                $valor = $valor->{$parte} ?? '';
            }
        }
    @endphp
    <div class="d-flex align-items-center justify-content-center">
        <span class="font-weight-medium me-2">{{ $valor }}</span>
        <a href="{{ route($coluna['rota'], $item->id) }}" class="btn btn-action btn-sm" title="Visualizar">
            <i class="bx bx-eye-alt icon"></i>
        </a>
    </div>

{{-- Tipo: Link --}}
@elseif($tipo === 'link')
    @php
        $valor = $item->{$campo};
        
        // Suporte para relacionamentos (ex: cliente.nome)
        if (strpos($campo, '.') !== false) {
            $partes = explode('.', $campo);
            $valor = $item;
            foreach ($partes as $parte) {
                $valor = $valor->{$parte} ?? '';
            }
        }
        
        // Para pedidos pagos, buscar o produto pelo nome para obter o ID
        $produtoId = null;
        if (isset($coluna['rota']) && $coluna['rota'] === 'produtos.show') {
            $produto = \App\Models\Produto::where('nome', $valor)->first();
            $produtoId = $produto ? $produto->id : null;
        }
    @endphp
    @if($produtoId)
        <a href="{{ route($coluna['rota'], $produtoId) }}" class="text-primary text-decoration-none">
            {{ $valor }}
        </a>
    @else
        <a href="{{ route($coluna['rota'], $item->id) }}" class="text-primary text-decoration-none">
            {{ $valor }}
        </a>
    @endif

{{-- Tipo: Texto (padrão) --}}
@else
    @php
        $valor = $item->{$campo};
        
        // Suporte para relacionamentos (ex: cliente.nome)
        if (strpos($campo, '.') !== false) {
            $partes = explode('.', $campo);
            $valor = $item;
            foreach ($partes as $parte) {
                $valor = $valor->{$parte} ?? '';
            }
        }
    @endphp
    {{ $valor }}
@endif
