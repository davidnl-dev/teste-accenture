<?php

namespace App\Http\Controllers;

use App\Models\PedidoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PedidoPagoController extends Controller
{
    private const ITENS_POR_PAGINA = 6;
    private const CAMPOS_ORDENACAO_PERMITIDOS = ['data_pagamento', 'data_pedido', 'total'];
    private const CAMPOS_BUSCA = ['nome_cliente', 'nome_produto'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PedidoPago::query()
            ->search($request->get('search'), self::CAMPOS_BUSCA)
            ->sort(
                $request->get('sort', 'data_pagamento'),
                $request->get('direction', 'desc'),
                self::CAMPOS_ORDENACAO_PERMITIDOS,
                'data_pagamento'
            );

        $pedidosPagos = $query->paginate(self::ITENS_POR_PAGINA)->withQueryString();

        return view('pedidos-pagos.index', compact('pedidosPagos'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pedidoPago = PedidoPago::findOrFail($id);
        
        return view('pedidos-pagos.show', compact('pedidoPago'));
    }
}
