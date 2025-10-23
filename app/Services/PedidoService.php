<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoPago;
use App\Models\Produto;
use App\Models\Log;
use App\Traits\Loggable;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    use Loggable;
    /**
     * Cria um novo pedido e gerencia o estoque automaticamente
     */
    public function criarPedido(array $data): Pedido
    {
        $produto = Produto::findOrFail($data['produto_id']);
        
        $this->validarEstoque($produto, $data['quantidade']);
        
        $data['preco_unitario'] = $produto->preco;
        $data['total'] = $produto->preco * $data['quantidade'];

        return DB::transaction(function () use ($data, $produto) {
            $pedido = Pedido::create($data);
            
            // Atualiza o estoque do produto
            $produto->decrement('estoque', $data['quantidade']);
            
            // Registrar log da atualização de estoque
            $this->registrarLog(
                Log::ACAO_ATUALIZAR,
                'Produto',
                "Estoque reduzido para produto: {$produto->nome}",
                1,
                [
                    'produto' => $produto->nome,
                    'quantidade_reduzida' => $data['quantidade'],
                    'estoque_atual' => $produto->fresh()->estoque,
                    'motivo' => 'Pedido criado'
                ]
            );
            
            // Se o pedido for pago, move para tabela de pedidos pagos
            if ($data['status'] === Pedido::STATUS_PAGO) {
                $this->moverParaPedidosPagos($pedido);
            }

            return $pedido;
        });
    }

    /**
     * Atualiza um pedido existente e gerencia mudanças no estoque
     */
    public function atualizarPedido(Pedido $pedido, array $data): Pedido
    {
        $produto = Produto::findOrFail($data['produto_id']);
        $quantidadeAnterior = $pedido->quantidade;
        
        // Se mudou o produto, devolve estoque do produto anterior
        if ($produto->id !== $pedido->produto_id) {
            $produtoAnterior = Produto::find($pedido->produto_id);
            $produtoAnterior->increment('estoque', $quantidadeAnterior);
        }

        $this->validarEstoque($produto, $data['quantidade']);

        $data['preco_unitario'] = $produto->preco;
        $data['total'] = $produto->preco * $data['quantidade'];

        return DB::transaction(function () use ($data, $pedido, $produto, $quantidadeAnterior) {
            $pedido->update($data);
            
            // Atualiza o estoque baseado na diferença de quantidade
            $this->atualizarEstoque($produto, $pedido, $quantidadeAnterior, $data['quantidade']);
            
            // Se o pedido foi marcado como pago, move para tabela de pedidos pagos
            if ($data['status'] === Pedido::STATUS_PAGO && $pedido->status !== Pedido::STATUS_PAGO) {
                $this->moverParaPedidosPagos($pedido);
            }

            return $pedido;
        });
    }

    /**
     * Exclui um pedido e devolve o estoque automaticamente
     */
    public function excluirPedido(Pedido $pedido): void
    {
        DB::transaction(function () use ($pedido) {
            // Devolve o estoque do produto
            $produto = $pedido->produto;
            $produto->increment('estoque', $pedido->quantidade);
            
            // Registrar log da devolução de estoque
            $this->registrarLog(
                Log::ACAO_ATUALIZAR,
                'Produto',
                "Estoque devolvido para produto: {$produto->nome}",
                1,
                [
                    'produto' => $produto->nome,
                    'quantidade_devolvida' => $pedido->quantidade,
                    'estoque_atual' => $produto->fresh()->estoque,
                    'motivo' => 'Pedido excluído'
                ]
            );
            
            $pedido->delete();
        });
    }

    /**
     * Move um pedido para a tabela de pedidos pagos e remove da tabela original
     */
    public function moverParaPedidosPagos(Pedido $pedido): void
    {
        // Cria registro na tabela de pedidos pagos
        $pedidoPago = PedidoPago::create([
            'nome_cliente' => $pedido->cliente->nome,
            'email_cliente' => $pedido->cliente->email,
            'nome_produto' => $pedido->produto->nome,
            'descricao_produto' => $pedido->produto->descricao,
            'quantidade' => $pedido->quantidade,
            'preco_unitario' => $pedido->preco_unitario,
            'total' => $pedido->total,
            'data_pedido' => $pedido->data_pedido ?? now(),
            'data_pagamento' => now(),
            'metodo_pagamento' => PedidoPago::METODO_DINHEIRO
        ]);

        $this->logCriacao('Pedido Pago', "Pedido #{$pedido->id}", [
            'cliente' => $pedido->cliente->nome,
            'produto' => $pedido->produto->nome,
            'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
            'metodo_pagamento' => 'Dinheiro'
        ]);

        $pedido->delete();
    }

    /**
     * Valida se há estoque suficiente para a quantidade solicitada
     */
    private function validarEstoque(Produto $produto, int $quantidade): void
    {
        if (!$produto->temEstoque($quantidade)) {
            throw new \Exception("Estoque insuficiente. Disponível: {$produto->estoque}");
        }
    }

    /**
     * Atualiza o estoque baseado na diferença entre quantidade anterior e nova
     */
    private function atualizarEstoque(Produto $produto, Pedido $pedido, int $quantidadeAnterior, int $novaQuantidade): void
    {
        if ($produto->id === $pedido->produto_id) {
            $diferenca = $novaQuantidade - $quantidadeAnterior;
            if ($diferenca > 0) {
                $produto->decrement('estoque', $diferenca);
            } else {
                $produto->increment('estoque', abs($diferenca));
            }
        } else {
            $produto->decrement('estoque', $novaQuantidade);
        }
    }
}
