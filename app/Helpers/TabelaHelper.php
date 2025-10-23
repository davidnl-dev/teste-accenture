<?php

namespace App\Helpers;

/**
 * Helper para configuração de colunas da tabela
 * 
 * Este helper fornece métodos estáticos para facilitar
 * a criação de configurações de colunas de forma mais limpa.
 */

class TabelaHelper
{
    /**
     * Cria configuração para coluna de texto
     */
    public static function texto(string $titulo, string $campo, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'texto',
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de imagem
     */
    public static function imagem(string $titulo, string $campo, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'imagem',
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de badge
     */
    public static function badge(string $titulo, string $campo, array $cores = [], array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'badge',
            'cores' => $cores,
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de moeda
     */
    public static function moeda(string $titulo, string $campo, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'moeda',
            'alinhamento' => 'text-end'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de data
     */
    public static function data(string $titulo, string $campo, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'data',
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de avatar
     */
    public static function avatar(string $titulo, string $campo, $subcampo = null, array $opcoes = []): array
    {
        $config = [
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'avatar',
            'alinhamento' => 'text-start'
        ];

        if ($subcampo) {
            $config['subcampo'] = $subcampo;
        }

        return array_merge($config, $opcoes);
    }

    /**
     * Cria configuração para coluna com ícone de olho
     */
    public static function olho(string $titulo, string $campo, string $rota, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'olho',
            'rota' => $rota,
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna de link
     */
    public static function link(string $titulo, string $campo, string $rota, array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => 'link',
            'rota' => $rota,
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna ordenável
     */
    public static function ordenavel(string $titulo, string $campo, string $tipo = 'texto', array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => $tipo,
            'ordenavel' => true,
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria configuração para coluna com busca
     */
    public static function busca(string $titulo, string $campo, string $tipo = 'texto', array $opcoes = []): array
    {
        return array_merge([
            'titulo' => $titulo,
            'campo' => $campo,
            'tipo' => $tipo,
            'busca' => true,
            'alinhamento' => 'text-center'
        ], $opcoes);
    }

    /**
     * Cria cores padrão para badges de status
     */
    public static function coresStatus(): array
    {
        return [
            '1' => 'bg-success',
            '0' => 'bg-danger',
            'true' => 'bg-success',
            'false' => 'bg-danger',
            'ativo' => 'bg-success',
            'inativo' => 'bg-danger'
        ];
    }

    /**
     * Cria cores padrão para status de pedidos
     */
    public static function coresStatusPedidos(): array
    {
        return [
            'pendente' => 'bg-warning',
            'pago' => 'bg-success',
            'cancelado' => 'bg-danger'
        ];
    }
}
