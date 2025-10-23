<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSearchAndSort;

class PedidoPago extends Model
{
    use HasFactory, HasSearchAndSort;

    protected $table = 'pedidos_pagos';

    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'nome_produto',
        'descricao_produto',
        'quantidade',
        'preco_unitario',
        'total',
        'data_pedido',
        'data_pagamento',
        'metodo_pagamento',
        'adicionado_em',
        'atualizado_em'
    ];

    protected $casts = [
        'preco_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'quantidade' => 'integer',
        'data_pedido' => 'datetime',
        'data_pagamento' => 'datetime',
        'adicionado_em' => 'datetime',
        'atualizado_em' => 'datetime'
    ];

    const CREATED_AT = 'adicionado_em';
    const UPDATED_AT = 'atualizado_em';

    // Constantes para métodos de pagamento
    const METODO_DINHEIRO = 'Dinheiro';
    const METODO_CARTAO = 'Cartão';
    const METODO_PIX = 'PIX';
    const METODO_BOLETO = 'Boleto';

    /**
     * Scope para pedidos por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_pagamento', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para pedidos por método de pagamento
     */
    public function scopePorMetodoPagamento($query, string $metodo)
    {
        return $query->where('metodo_pagamento', $metodo);
    }

    /**
     * Accessor para total formatado
     */
    public function getTotalFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->total, 2, ',', '.');
    }

    /**
     * Accessor para preço unitário formatado
     */
    public function getPrecoUnitarioFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->preco_unitario, 2, ',', '.');
    }

    /**
     * Accessor para data de pagamento formatada
     */
    public function getDataPagamentoFormatadaAttribute(): string
    {
        return $this->data_pagamento->format('d/m/Y H:i');
    }

    /**
     * Accessor para data do pedido formatada
     */
    public function getDataPedidoFormatadaAttribute(): string
    {
        return $this->data_pedido->format('d/m/Y H:i');
    }

    /**
     * Obter métodos de pagamento disponíveis
     */
    public static function getMetodosPagamento(): array
    {
        return [
            self::METODO_DINHEIRO => 'Dinheiro',
            self::METODO_CARTAO => 'Cartão',
            self::METODO_PIX => 'PIX',
            self::METODO_BOLETO => 'Boleto',
        ];
    }
}
