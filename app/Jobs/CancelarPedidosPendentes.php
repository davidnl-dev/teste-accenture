<?php

namespace App\Jobs;

use App\Models\Pedido;
use App\Models\Log;
use App\Traits\Loggable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelarPedidosPendentes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Loggable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inicioExecucao = Carbon::now();
        
        // Buscar pedidos pendentes há mais de 7 dias
        $dataLimite = Carbon::now()->subDays(7);
        
        $pedidosParaCancelar = Pedido::where('status', Pedido::STATUS_PENDENTE)
            ->where('data_pedido', '<=', $dataLimite)
            ->with(['cliente', 'produto'])
            ->get();

        $quantidadeCancelada = 0;
        $pedidosCancelados = [];

        DB::transaction(function () use ($pedidosParaCancelar, &$quantidadeCancelada, &$pedidosCancelados) {
            foreach ($pedidosParaCancelar as $pedido) {
                $pedido->update(['status' => Pedido::STATUS_CANCELADO]);
                
                // Registrar log individual para cada pedido cancelado
                $this->logCancelamento('Pedido', "Pedido #{$pedido->id}", [
                    'cliente' => $pedido->cliente->nome,
                    'produto' => $pedido->produto->nome,
                    'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
                    'dias_pendente' => $pedido->data_pedido->diffInDays(Carbon::now()),
                    'motivo' => 'Cancelamento automático por tempo limite'
                ]);
                
                $pedidosCancelados[] = [
                    'id' => $pedido->id,
                    'cliente' => $pedido->cliente->nome,
                    'produto' => $pedido->produto->nome,
                    'total' => $pedido->total,
                    'dias_pendente' => $pedido->data_pedido->diffInDays(Carbon::now())
                ];
                
                $quantidadeCancelada++;
            }
        });

        $fimExecucao = Carbon::now();
        $tempoExecucao = $fimExecucao->diffInSeconds($inicioExecucao);

        // Registrar log da execução do job
        $this->registrarLog(
            Log::ACAO_CANCELAR,
            'Job Automático',
            "Execução do job de cancelamento automático de pedidos",
            $quantidadeCancelada,
            [
                'data_limite' => $dataLimite->format('d/m/Y'),
                'tempo_execucao' => $tempoExecucao . ' segundos',
                'pedidos_cancelados' => $pedidosCancelados
            ]
        );

        // Log adicional para auditoria
        if ($quantidadeCancelada > 0) {
            $this->registrarLog(
                Log::ACAO_ATUALIZAR,
                'Sistema',
                "Job executado com sucesso - {$quantidadeCancelada} pedido(s) cancelado(s) automaticamente",
                1,
                [
                    'job' => 'CancelarPedidosPendentes',
                    'executado_em' => $inicioExecucao->format('d/m/Y H:i:s'),
                    'tempo_execucao' => $tempoExecucao . 's'
                ]
            );
        }
    }
}
