/**
 * Dashboard JavaScript
 * Gerencia gráficos e interações da página inicial
 */

document.addEventListener('DOMContentLoaded', function() {
    // Dados dos gráficos
    const statusPedidos = window.statusPedidos || {};
    const produtosMaisVendidos = window.produtosMaisVendidos || [];

    // Gráfico de Status dos Pedidos (Donut melhorado)
    const statusOptions = {
        series: Object.values(statusPedidos),
        chart: {
            type: 'donut',
            height: 265,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#ffc107', '#28a745', '#dc3545'],
        labels: Object.keys(statusPedidos),
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            fontFamily: 'Helvetica, Arial, sans-serif',
            fontWeight: 500,
            markers: {
                width: 12,
                height: 12,
                radius: 6,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '16px',
                            fontWeight: 600,
                            color: '#374151',
                            offsetY: -10,
                            formatter: function (val) {
                                return val
                            }
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#444',
                            offsetY: 10,
                            formatter: function (val) {
                                const total = Object.values(statusPedidos).reduce((a, b) => a + b, 0);
                                return val + ' (' + ((val / total) * 100).toFixed(1) + '%)';
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#6b7280',
                            formatter: function (w) {
                                const total = Object.values(statusPedidos).reduce((a, b) => a + b, 0);
                                return total + ' pedidos';
                            }
                        }
                    }
                },
                expandOnClick: true
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '12px',
                fontWeight: 600,
                colors: ['#ffffff']
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                color: '#000',
                opacity: 0.45
            },
            formatter: function(val, opts) {
                const value = opts.w.config.series[opts.seriesIndex];
                return value > 0 ? value : '';
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#ffffff']
        },
        tooltip: {
            enabled: true,
            shared: false,
            followCursor: true,
            fillSeriesColor: false,
            theme: 'light',
            style: {
                fontSize: '14px',
                fontFamily: 'Helvetica, Arial, sans-serif'
            },
            y: {
                formatter: function(value, { seriesIndex, w }) {
                    const total = Object.values(statusPedidos).reduce((a, b) => a + b, 0);
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return value + ' pedidos (' + percentage + '%)';
                }
            }
        },
        states: {
            hover: {
                filter: {
                    type: 'lighten',
                    value: 0.1
                }
            },
            active: {
                allowMultipleDataPointsSelection: false,
                filter: {
                    type: 'darken',
                    value: 0.1
                }
            }
        },
        responsive: [{
            breakpoint: 768,
            options: {
                chart: {
                    height: 250
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%',
                            labels: {
                                name: {
                                    fontSize: '14px'
                                },
                                value: {
                                    fontSize: '18px'
                                },
                                total: {
                                    fontSize: '12px'
                                }
                            }
                        }
                    }
                }
            }
        }]
    };

    const statusChart = new ApexCharts(document.querySelector("#chart-status-pedidos"), statusOptions);
    statusChart.render();

    // Gráfico de Produtos Mais Vendidos (Barras Verticais)
    const produtosOptions = {
        series: [{
            name: 'Quantidade Vendida',
            data: produtosMaisVendidos.map(item => item.quantidade)
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: true
            }
        },
        colors: ['#2fb344'],
        plotOptions: {
            bar: {
                borderRadius: 4
            }
        },
        dataLabels: {
            enabled: true
        },
        xaxis: {
            categories: produtosMaisVendidos.map(item => item.nome.length > 20 ? item.nome.substring(0, 20) + '...' : item.nome)
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return value + ' unidades';
                }
            }
        }
    };

    const produtosChart = new ApexCharts(document.querySelector("#chart-produtos-vendidos"), produtosOptions);
    produtosChart.render();

    // Adicionar evento de clique nos segmentos do gráfico
    statusChart.on('dataPointSelection', function(event, chartContext, config) {
        const status = Object.keys(statusPedidos)[config.dataPointIndex];
        const valor = Object.values(statusPedidos)[config.dataPointIndex];
        
        // Criar modal com detalhes do status
        const modalHtml = `
            <div class="modal fade" id="statusModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes - ${status}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="display-6 font-weight-bold text-primary">${valor}</div>
                                            <div class="text-muted">Pedidos</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="display-6 font-weight-bold text-success">
                                                ${((valor / Object.values(statusPedidos).reduce((a, b) => a + b, 0)) * 100).toFixed(1)}%
                                            </div>
                                            <div class="text-muted">do Total</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="/pedidos" class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3h6v6h-6z"/><path d="M3 13h13"/><path d="M3 17h9"/></svg>
                                    Ver Todos os Pedidos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remover modal anterior se existir
        const existingModal = document.getElementById('statusModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Adicionar novo modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('statusModal'));
        modal.show();
    });

    // Adicionar animação de entrada suave
    setTimeout(() => {
        document.querySelector('#chart-status-pedidos').style.opacity = '0';
        document.querySelector('#chart-status-pedidos').style.transform = 'scale(0.8)';
        document.querySelector('#chart-status-pedidos').style.transition = 'all 0.5s ease';
        
        setTimeout(() => {
            document.querySelector('#chart-status-pedidos').style.opacity = '1';
            document.querySelector('#chart-status-pedidos').style.transform = 'scale(1)';
        }, 100);
    }, 100);
});
