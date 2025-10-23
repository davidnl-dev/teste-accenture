<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSearchAndSort;

class Cliente extends Model
{
    use HasFactory, HasSearchAndSort;

    protected $fillable = ['nome', 'email', 'data_cadastro', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    const CREATED_AT = 'adicionado_em';
    const UPDATED_AT = 'atualizado_em';

    /**
     * Relacionamento com pedidos do cliente
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Scope para buscar apenas clientes ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope para buscar apenas clientes inativos
     */
    public function scopeInativos($query)
    {
        return $query->where('status', false);
    }

    /**
     * Accessor que formata o nome com primeira letra maiúscula
     */
    public function getNomeFormatadoAttribute(): string
    {
        return ucwords(strtolower($this->nome));
    }

    /**
     * Accessor que retorna o status formatado em português
     */
    public function getStatusFormatadoAttribute(): string
    {
        return $this->status ? 'Ativo' : 'Inativo';
    }

    /**
     * Verifica se o cliente pode ser excluído (não possui pedidos)
     */
    public function podeSerExcluido(): bool
    {
        return $this->pedidos()->count() === 0;
    }
}
