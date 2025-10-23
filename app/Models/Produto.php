<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasSearchAndSort;

class Produto extends Model
{
    use HasFactory, HasSearchAndSort;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'estoque',
        'imagem',
        'categoria',
        'ativo'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
        'estoque' => 'integer'
    ];

    const CREATED_AT = 'adicionado_em';
    const UPDATED_AT = 'atualizado_em';

    /**
     * Relacionamento com pedidos
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Scope para produtos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para produtos inativos
     */
    public function scopeInativos($query)
    {
        return $query->where('ativo', false);
    }

    /**
     * Scope para produtos com estoque
     */
    public function scopeComEstoque($query)
    {
        return $query->where('estoque', '>', 0);
    }

    /**
     * Scope para produtos sem estoque
     */
    public function scopeSemEstoque($query)
    {
        return $query->where('estoque', '<=', 0);
    }

    /**
     * Scope para produtos por categoria
     */
    public function scopePorCategoria($query, string $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Accessor para preço formatado
     */
    public function getPrecoFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    /**
     * Accessor para status formatado
     */
    public function getStatusFormatadoAttribute(): string
    {
        return $this->ativo ? 'Ativo' : 'Inativo';
    }

    /**
     * Accessor para URL da imagem
     */
    public function getImagemUrlAttribute(): ?string
    {
        if (!$this->imagem) {
            return null;
        }

        return asset('storage/' . $this->imagem);
    }

    /**
     * Verificar se o produto está ativo
     */
    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    /**
     * Verificar se tem estoque suficiente
     */
    public function temEstoque(int $quantidade): bool
    {
        return $this->estoque >= $quantidade;
    }

    /**
     * Verificar se está disponível para venda
     */
    public function isDisponivel(): bool
    {
        return $this->ativo && $this->estoque > 0;
    }

    /**
     * Boot method para eventos do modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Deletar imagem quando o produto for excluído
        static::deleting(function ($produto) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
        });
    }
}
