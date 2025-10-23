<?php

namespace App\Console\Commands;

use App\Jobs\CancelarPedidosPendentes;
use App\Models\Pedido;
use App\Models\Log;
use App\Traits\Loggable;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelarPedidosCommand extends Command
{
    use Loggable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pedidos:cancelar-pendentes 
                            {--dias=7 : Número de dias para considerar pedido como pendente}
                            {--dry-run : Executar em modo de teste (não altera dados)}
                            {--force : Forçar execução mesmo sem pedidos pendentes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancela automaticamente pedidos pendentes há mais de X dias';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dias = (int) $this->option('dias');
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        $this->info("🚀 Iniciando processo de cancelamento de pedidos pendentes...");
        $this->info("📅 Considerando pedidos pendentes há mais de {$dias} dias");
        
        if ($dryRun) {
            $this->warn("⚠️  MODO TESTE ATIVADO - Nenhum dado será alterado");
        }

        $inicioExecucao = Carbon::now();
        $dataLimite = Carbon::now()->subDays($dias);

        // Buscar pedidos pendentes
        $pedidosParaCancelar = Pedido::where('status', Pedido::STATUS_PENDENTE)
            ->where('data_pedido', '<=', $dataLimite)
            ->with(['cliente', 'produto'])
            ->get();

        $quantidade = $pedidosParaCancelar->count();

        if ($quantidade === 0 && !$force) {
            $this->info("✅ Nenhum pedido pendente encontrado há mais de {$dias} dias");
            return Command::SUCCESS;
        }

        $this->info("📊 Encontrados {$quantidade} pedido(s) para cancelamento");

        if ($quantidade > 0) {
            // Mostrar tabela com pedidos que serão cancelados
            $headers = ['ID', 'Cliente', 'Produto', 'Total', 'Data Pedido', 'Dias Pendente'];
            $rows = [];

            foreach ($pedidosParaCancelar as $pedido) {
                $diasPendente = $pedido->data_pedido->diffInDays(Carbon::now());
                $rows[] = [
                    $pedido->id,
                    $pedido->cliente->nome,
                    $pedido->produto->nome,
                    'R$ ' . number_format($pedido->total, 2, ',', '.'),
                    $pedido->data_pedido->format('d/m/Y'),
                    $diasPendente . ' dias'
                ];
            }

            $this->table($headers, $rows);

            if (!$dryRun) {
                if ($this->confirm("Deseja cancelar estes {$quantidade} pedido(s)?")) {
                    $this->processarCancelamento($pedidosParaCancelar, $dataLimite, $inicioExecucao);
                } else {
                    $this->info("❌ Operação cancelada pelo usuário");
                    return Command::SUCCESS;
                }
            } else {
                $this->info("🧪 Modo teste - Simulando cancelamento...");
                $this->simularCancelamento($pedidosParaCancelar, $dataLimite, $inicioExecucao);
            }
        }

        $fimExecucao = Carbon::now();
        $tempoExecucao = $fimExecucao->diffInSeconds($inicioExecucao);

        $this->info("⏱️  Tempo de execução: {$tempoExecucao} segundos");
        $this->info("✅ Processo concluído com sucesso!");

        return Command::SUCCESS;
    }

    /**
     * Processa o cancelamento real dos pedidos
     */
    private function processarCancelamento($pedidosParaCancelar, $dataLimite, $inicioExecucao): void
    {
        $this->info("🔄 Processando cancelamento...");

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

        // Registrar log da execução do comando
        $this->registrarLog(
            Log::ACAO_CANCELAR,
            'Comando Artisan',
            "Execução manual do comando de cancelamento de pedidos",
            $quantidadeCancelada,
            [
                'data_limite' => $dataLimite->format('d/m/Y'),
                'tempo_execucao' => $tempoExecucao . ' segundos',
                'pedidos_cancelados' => $pedidosCancelados,
                'executado_por' => 'Comando Artisan'
            ]
        );

        $this->info("✅ {$quantidadeCancelada} pedido(s) cancelado(s) com sucesso!");
    }

    /**
     * Simula o cancelamento (modo teste)
     */
    private function simularCancelamento($pedidosParaCancelar, $dataLimite, $inicioExecucao): void
    {
        $quantidadeCancelada = $pedidosParaCancelar->count();
        $fimExecucao = Carbon::now();
        $tempoExecucao = $fimExecucao->diffInSeconds($inicioExecucao);

        // Registrar log da simulação
        $this->registrarLog(
            Log::ACAO_CANCELAR,
            'Simulação',
            "Simulação do cancelamento de pedidos pendentes",
            $quantidadeCancelada,
            [
                'data_limite' => $dataLimite->format('d/m/Y'),
                'tempo_execucao' => $tempoExecucao . ' segundos',
                'modo' => 'dry-run',
                'executado_por' => 'Comando Artisan (Teste)'
            ]
        );

        $this->info("🧪 Simulação concluída - {$quantidadeCancelada} pedido(s) seriam cancelado(s)");
    }
}