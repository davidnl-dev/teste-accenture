<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Http\Requests\PedidoRequest;
use App\Services\PedidoService;
use App\Traits\Loggable;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    use Loggable;
    private const ITENS_POR_PAGINA = 6;
    private const CAMPOS_ORDENACAO_PERMITIDOS = ['data_pedido', 'status', 'total'];
    private const CAMPOS_BUSCA = ['cliente.nome', 'produto.nome'];

    public function __construct(
        private PedidoService $pedidoService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'produto'])
            ->naoPagos()
            ->search($request->get('search'), self::CAMPOS_BUSCA)
            ->sort(
                $request->get('sort', 'data_pedido'),
                $request->get('direction', 'desc'),
                self::CAMPOS_ORDENACAO_PERMITIDOS,
                'data_pedido'
            );

        $pedidos = $query->paginate(self::ITENS_POR_PAGINA)->withQueryString();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::ativos()->orderBy('nome')->get();
        $produtos = Produto::ativos()->comEstoque()->orderBy('nome')->get();
        
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedidoRequest $request)
    {
        try {
            $data = $request->validated();
            $pedido = $this->pedidoService->criarPedido($data);

            // Se o pedido foi movido para pedidos_pagos, redireciona para lá
            if ($data['status'] === 'pago') {
                return redirect()->route('pedidos-pagos.index')
                    ->with('success', 'Pedido pago criado com sucesso!');
            }

            // Registrar log da criação apenas se o pedido ainda existe na tabela pedidos
            $this->logCriacao('Pedido', "Pedido #{$pedido->id}", [
                'cliente' => $pedido->cliente->nome,
                'produto' => $pedido->produto->nome,
                'quantidade' => $pedido->quantidade,
                'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
                'status' => $pedido->status
            ]);

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['quantidade' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'produto']);
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::orderBy('status', 'desc')->orderBy('nome')->get();
        $produtos = Produto::ativos()->orderBy('nome')->get();
        
        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedidoRequest $request, Pedido $pedido)
    {
        try {
            $this->pedidoService->atualizarPedido($pedido, $request->validated());

            // Registrar log da atualização
            $this->logAtualizacao('Pedido', "Pedido #{$pedido->id}", [
                'cliente' => $pedido->cliente->nome,
                'produto' => $pedido->produto->nome,
                'quantidade' => $pedido->quantidade,
                'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
                'status' => $pedido->status
            ]);

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['quantidade' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        // Registrar log da exclusão antes de excluir
        $this->logExclusao('Pedido', "Pedido #{$pedido->id}", [
            'cliente' => $pedido->cliente->nome,
            'produto' => $pedido->produto->nome,
            'quantidade' => $pedido->quantidade,
            'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
            'data_pedido' => $pedido->data_pedido->format('d/m/Y')
        ]);

        $this->pedidoService->excluirPedido($pedido);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido excluído com sucesso!');
    }
}
