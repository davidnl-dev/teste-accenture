<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'acao',
        'descricao', 
        'quantidade_afetada',
        'executado_em'
    ];

    protected $casts = [
        'executado_em' => 'datetime',
        'quantidade_afetada' => 'integer',
    ];

    // Constantes para ações do sistema
    const ACAO_CRIAR = 'create';
    const ACAO_ATUALIZAR = 'update';
    const ACAO_EXCLUIR = 'delete';
    const ACAO_CANCELAR = 'cancel';

    /**
     * Scope para logs por ação
     */
    public function scopePorAcao($query, string $acao)
    {
        return $query->where('acao', $acao);
    }

    /**
     * Scope para logs por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('executado_em', [$dataInicio, $dataFim]);
    }

    /**
     * Accessor para data formatada
     */
    public function getDataFormatadaAttribute(): string
    {
        return $this->executado_em->format('d/m/Y H:i:s');
    }

    /**
     * Accessor para ação formatada
     */
    public function getAcaoFormatadaAttribute(): string
    {
        return match($this->acao) {
            self::ACAO_CRIAR => 'Criado',
            self::ACAO_ATUALIZAR => 'Atualizado',
            self::ACAO_EXCLUIR => 'Excluído',
            self::ACAO_CANCELAR => 'Cancelado',
            default => 'Desconhecido'
        };
    }

    /**
     * Obter ações disponíveis
     */
    public static function getAcoes(): array
    {
        return [
            self::ACAO_CRIAR => 'Criar',
            self::ACAO_ATUALIZAR => 'Atualizar',
            self::ACAO_EXCLUIR => 'Excluir',
            self::ACAO_CANCELAR => 'Cancelar',
        ];
    }

    /**
     * Criar log automaticamente
     */
    public static function criar(string $acao, string $descricao, int $quantidadeAfetada = 1): self
    {
        return self::create([
            'acao' => $acao,
            'descricao' => $descricao,
            'quantidade_afetada' => $quantidadeAfetada,
            'executado_em' => now(),
        ]);
    }
}
