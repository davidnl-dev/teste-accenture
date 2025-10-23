<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSearchAndSort;

class Pedido extends Model
{
    use HasFactory, HasSearchAndSort;

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'total',
        'status',
        'data_pedido'
    ];

    protected $casts = [
        'preco_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'quantidade' => 'integer',
        'data_pedido' => 'datetime'
    ];

    const CREATED_AT = 'adicionado_em';
    const UPDATED_AT = 'atualizado_em';

    // Constantes para status dos pedidos
    const STATUS_PENDENTE = 'pendente';
    const STATUS_PAGO = 'pago';
    const STATUS_CANCELADO = 'cancelado';

    /**
     * Relacionamento com o cliente que fez o pedido
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com o produto do pedido
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    /**
     * Scope para buscar apenas pedidos pendentes
     */
    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }

    /**
     * Scope para buscar apenas pedidos pagos
     */
    public function scopePagos($query)
    {
        return $query->where('status', self::STATUS_PAGO);
    }

    /**
     * Scope para buscar apenas pedidos cancelados
     */
    public function scopeCancelados($query)
    {
        return $query->where('status', self::STATUS_CANCELADO);
    }

    /**
     * Scope para buscar pedidos não pagos (pendentes ou cancelados)
     */
    public function scopeNaoPagos($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDENTE, self::STATUS_CANCELADO]);
    }

    /**
     * Accessor que retorna o status formatado em português
     */
    public function getStatusFormatadoAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDENTE => 'Pendente',
            self::STATUS_PAGO => 'Pago',
            self::STATUS_CANCELADO => 'Cancelado',
            default => 'Desconhecido'
        };
    }

    /**
     * Accessor que formata o valor total em moeda brasileira
     */
    public function getTotalFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->total, 2, ',', '.');
    }

    /**
     * Verifica se o pedido está pendente
     */
    public function isPendente(): bool
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    /**
     * Verifica se o pedido está pago
     */
    public function isPago(): bool
    {
        return $this->status === self::STATUS_PAGO;
    }

    /**
     * Verifica se o pedido está cancelado
     */
    public function isCancelado(): bool
    {
        return $this->status === self::STATUS_CANCELADO;
    }
}
