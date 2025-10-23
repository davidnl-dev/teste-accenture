<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Agendamento de tarefas automáticas
Schedule::command('pedidos:cancelar-pendentes')
    ->daily()
    ->at('02:00')
    ->name('cancelar-pedidos-pendentes')
    ->description('Cancela automaticamente pedidos pendentes há mais de 7 dias')
    ->withoutOverlapping()
    ->runInBackground();

// Alternativa usando Job diretamente
Schedule::job(new \App\Jobs\CancelarPedidosPendentes())
    ->daily()
    ->at('02:30')
    ->name('job-cancelar-pedidos')
    ->description('Job para cancelar pedidos pendentes')
    ->withoutOverlapping();
