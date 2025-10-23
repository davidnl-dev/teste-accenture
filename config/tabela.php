<?php

/**
 * Configurações para tipos de colunas da tabela
 * 
 * Este arquivo define os tipos de colunas suportados pelo componente tabela
 * e suas respectivas configurações padrão.
 */

return [
    'tipos' => [
        'texto' => [
            'nome' => 'Texto',
            'descricao' => 'Exibe texto simples',
            'configuracoes' => []
        ],
        
        'imagem' => [
            'nome' => 'Imagem',
            'descricao' => 'Exibe imagem com thumbnail',
            'configuracoes' => [
                'width' => 50,
                'height' => 50,
                'placeholder' => 'Sem imagem'
            ]
        ],
        
        'badge' => [
            'nome' => 'Badge',
            'descricao' => 'Exibe badge com cores personalizáveis',
            'configuracoes' => [
                'cores_padrao' => [
                    '1' => 'bg-success',
                    '0' => 'bg-danger',
                    'true' => 'bg-success',
                    'false' => 'bg-danger'
                ]
            ]
        ],
        
        'moeda' => [
            'nome' => 'Moeda',
            'descricao' => 'Exibe valor monetário formatado',
            'configuracoes' => [
                'simbolo' => 'R$',
                'decimais' => 2,
                'separador_decimal' => ',',
                'separador_milhares' => '.'
            ]
        ],
        
        'data' => [
            'nome' => 'Data',
            'descricao' => 'Exibe data formatada',
            'configuracoes' => [
                'formato' => 'd/m/Y',
                'timezone' => 'America/Sao_Paulo'
            ]
        ],
        
        'avatar' => [
            'nome' => 'Avatar',
            'descricao' => 'Exibe avatar com inicial do nome',
            'configuracoes' => [
                'tamanho' => 'sm',
                'cor' => 'primary',
                'subcampo' => null
            ]
        ],
        
        'link' => [
            'nome' => 'Link',
            'descricao' => 'Exibe texto como link',
            'configuracoes' => [
                'rota' => null,
                'parametro' => 'id'
            ]
        ]
    ],
    
    'alinhamentos' => [
        'left' => 'text-start',
        'center' => 'text-center',
        'right' => 'text-end'
    ],
    
    'cores_badge' => [
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success' => 'bg-success',
        'danger' => 'bg-danger',
        'warning' => 'bg-warning',
        'info' => 'bg-info',
        'light' => 'bg-light',
        'dark' => 'bg-dark'
    ]
];
