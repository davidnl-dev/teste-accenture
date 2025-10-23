<?php

namespace App\Traits;

use App\Models\Log;

trait Loggable
{
    /**
     * Registra uma ação no log do sistema
     *
     * @param string $acao Ação realizada (create, update, delete, etc.)
     * @param string $modelo Nome do modelo afetado
     * @param string $descricao Descrição detalhada da ação
     * @param int $quantidadeAfetada Quantidade de registros afetados
     * @param array $dadosAdicionais Dados adicionais para contexto
     * @return Log
     */
    protected function registrarLog(
        string $acao,
        string $modelo,
        string $descricao,
        int $quantidadeAfetada = 1,
        array $dadosAdicionais = []
    ): Log {
        $descricaoCompleta = $this->construirDescricao($descricao, $dadosAdicionais);
        
        return Log::criar($acao, $descricaoCompleta, $quantidadeAfetada);
    }

    /**
     * Registra log de criação
     *
     * @param string $modelo Nome do modelo
     * @param string $identificador Identificador do registro (nome, ID, etc.)
     * @param array $dadosAdicionais Dados adicionais
     * @return Log
     */
    protected function logCriacao(string $modelo, string $identificador, array $dadosAdicionais = []): Log
    {
        $descricao = "Novo {$modelo} criado: {$identificador}";
        return $this->registrarLog(Log::ACAO_CRIAR, $modelo, $descricao, 1, $dadosAdicionais);
    }

    /**
     * Registra log de atualização
     *
     * @param string $modelo Nome do modelo
     * @param string $identificador Identificador do registro
     * @param array $dadosAdicionais Dados adicionais
     * @return Log
     */
    protected function logAtualizacao(string $modelo, string $identificador, array $dadosAdicionais = []): Log
    {
        $descricao = "{$modelo} atualizado: {$identificador}";
        return $this->registrarLog(Log::ACAO_ATUALIZAR, $modelo, $descricao, 1, $dadosAdicionais);
    }

    /**
     * Registra log de exclusão
     *
     * @param string $modelo Nome do modelo
     * @param string $identificador Identificador do registro
     * @param array $dadosAdicionais Dados adicionais
     * @return Log
     */
    protected function logExclusao(string $modelo, string $identificador, array $dadosAdicionais = []): Log
    {
        $descricao = "{$modelo} excluído: {$identificador}";
        return $this->registrarLog(Log::ACAO_EXCLUIR, $modelo, $descricao, 1, $dadosAdicionais);
    }

    /**
     * Registra log de cancelamento
     *
     * @param string $modelo Nome do modelo
     * @param string $identificador Identificador do registro
     * @param array $dadosAdicionais Dados adicionais
     * @return Log
     */
    protected function logCancelamento(string $modelo, string $identificador, array $dadosAdicionais = []): Log
    {
        $descricao = "{$modelo} cancelado: {$identificador}";
        return $this->registrarLog(Log::ACAO_CANCELAR, $modelo, $descricao, 1, $dadosAdicionais);
    }

    /**
     * Constrói a descrição completa do log
     *
     * @param string $descricao Descrição base
     * @param array $dadosAdicionais Dados adicionais
     * @return string
     */
    private function construirDescricao(string $descricao, array $dadosAdicionais): string
    {
        if (empty($dadosAdicionais)) {
            return $descricao;
        }

        $detalhes = [];
        foreach ($dadosAdicionais as $chave => $valor) {
            if (is_array($valor)) {
                $valor = implode(', ', $valor);
            }
            $detalhes[] = "{$chave}: {$valor}";
        }

        return $descricao . ' (' . implode(', ', $detalhes) . ')';
    }
}
