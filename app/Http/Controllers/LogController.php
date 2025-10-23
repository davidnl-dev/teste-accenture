<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    private const ITENS_POR_PAGINA = 20;
    private const CAMPOS_ORDENACAO_PERMITIDOS = ['acao', 'descricao', 'quantidade_afetada', 'executado_em'];
    private const CAMPOS_BUSCA = ['descricao'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Log::query();

        // Filtro por ação
        if ($request->filled('acao')) {
            $query->where('acao', $request->get('acao'));
        }

        // Filtro por data
        if ($request->filled('data_inicio')) {
            $query->whereDate('executado_em', '>=', $request->get('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('executado_em', '<=', $request->get('data_fim'));
        }

        // Busca por descrição
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                foreach (self::CAMPOS_BUSCA as $campo) {
                    $q->orWhere($campo, 'like', "%{$searchTerm}%");
                }
            });
        }

        // Ordenação
        $sortField = $request->get('sort', 'executado_em');
        $sortDirection = $request->get('direction', 'desc');
        
        if (in_array($sortField, self::CAMPOS_ORDENACAO_PERMITIDOS)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('executado_em', 'desc');
        }

        $logs = $query->paginate(self::ITENS_POR_PAGINA)->withQueryString();

        // Dados para os filtros
        $acoesDisponiveis = Log::getAcoes();
        $estatisticas = $this->getEstatisticas($request);

        return view('logs.index', compact('logs', 'acoesDisponiveis', 'estatisticas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Log $log)
    {
        return view('logs.show', compact('log'));
    }

    /**
     * Obter estatísticas dos logs
     */
    private function getEstatisticas(Request $request): array
    {
        $query = Log::query();

        // Aplicar mesmos filtros da consulta principal
        if ($request->filled('acao')) {
            $query->where('acao', $request->get('acao'));
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('executado_em', '>=', $request->get('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('executado_em', '<=', $request->get('data_fim'));
        }

        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                foreach (self::CAMPOS_BUSCA as $campo) {
                    $q->orWhere($campo, 'like', "%{$searchTerm}%");
                }
            });
        }

        return [
            'total_logs' => $query->count(),
            'total_criacoes' => (clone $query)->where('acao', Log::ACAO_CRIAR)->count(),
            'total_atualizacoes' => (clone $query)->where('acao', Log::ACAO_ATUALIZAR)->count(),
            'total_exclusoes' => (clone $query)->where('acao', Log::ACAO_EXCLUIR)->count(),
            'total_cancelamentos' => (clone $query)->where('acao', Log::ACAO_CANCELAR)->count(),
        ];
    }
}
