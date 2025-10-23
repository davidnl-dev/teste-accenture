<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'Smartphone Samsung Galaxy S24',
                'descricao' => 'Smartphone Android com tela de 6.2 polegadas, 128GB de armazenamento, câmera tripla de 50MP.',
                'preco' => 1299.99,
                'estoque' => 15,
                'categoria' => 'Eletrônicos',
                'imagem' => 'produtos/smartphone-samsung.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Notebook Dell Inspiron 15',
                'descricao' => 'Notebook com processador Intel i5, 8GB RAM, 256GB SSD, tela de 15.6 polegadas.',
                'preco' => 2499.99,
                'estoque' => 8,
                'categoria' => 'Informática',
                'imagem' => 'produtos/notebook-dell.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Fone de Ouvido Sony WH-1000XM4',
                'descricao' => 'Fone de ouvido sem fio com cancelamento de ruído ativo e bateria de 30 horas.',
                'preco' => 899.99,
                'estoque' => 12,
                'categoria' => 'Áudio',
                'imagem' => 'produtos/fone-sony.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Smart TV LG 55" 4K',
                'descricao' => 'Smart TV LED 55 polegadas com resolução 4K, HDR10 e sistema webOS.',
                'preco' => 1899.99,
                'estoque' => 5,
                'categoria' => 'TV e Vídeo',
                'imagem' => 'produtos/tv-lg.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Câmera Canon EOS R6',
                'descricao' => 'Câmera mirrorless full-frame com sensor de 20MP e gravação 4K.',
                'preco' => 4599.99,
                'estoque' => 3,
                'categoria' => 'Fotografia',
                'imagem' => 'produtos/camera-canon.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Tablet iPad Air 10.9"',
                'descricao' => 'Tablet Apple com chip M1, 64GB de armazenamento e tela Liquid Retina.',
                'preco' => 1999.99,
                'estoque' => 10,
                'categoria' => 'Tablets',
                'imagem' => 'produtos/ipad-air.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Console PlayStation 5',
                'descricao' => 'Console de videogame Sony PlayStation 5 com SSD de 825GB.',
                'preco' => 3999.99,
                'estoque' => 2,
                'categoria' => 'Games',
                'imagem' => 'produtos/ps5.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Monitor Samsung 27" 4K',
                'descricao' => 'Monitor LED 27 polegadas com resolução 4K, HDR10 e taxa de atualização de 60Hz.',
                'preco' => 1299.99,
                'estoque' => 7,
                'categoria' => 'Monitores',
                'imagem' => 'produtos/monitor-samsung.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Mouse Logitech MX Master 3',
                'descricao' => 'Mouse sem fio ergonômico com sensor de alta precisão e bateria de 70 dias.',
                'preco' => 299.99,
                'estoque' => 20,
                'categoria' => 'Periféricos',
                'imagem' => 'produtos/mouse-logitech.jpg',
                'ativo' => true
            ],
            [
                'nome' => 'Teclado Mecânico Corsair K95',
                'descricao' => 'Teclado mecânico gaming com switches Cherry MX Speed e iluminação RGB.',
                'preco' => 599.99,
                'estoque' => 6,
                'categoria' => 'Periféricos',
                'imagem' => 'produtos/teclado-corsair.jpg',
                'ativo' => true
            ]
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }

        // Criar imagens placeholder (você pode substituir por imagens reais)
        $this->criarImagensPlaceholder();
    }

    private function criarImagensPlaceholder()
    {
        $imagens = [
            'smartphone-samsung.jpg',
            'notebook-dell.jpg',
            'fone-sony.jpg',
            'tv-lg.jpg',
            'camera-canon.jpg',
            'ipad-air.jpg',
            'ps5.jpg',
            'monitor-samsung.jpg',
            'mouse-logitech.jpg',
            'teclado-corsair.jpg'
        ];

        // Criar diretório se não existir
        if (!Storage::disk('public')->exists('produtos')) {
            Storage::disk('public')->makeDirectory('produtos');
        }

        // Criar arquivos de imagem placeholder (SVG simples)
        foreach ($imagens as $imagem) {
            $caminho = 'produtos/' . $imagem;
            if (!Storage::disk('public')->exists($caminho)) {
                $svg = '<svg width="300" height="200" xmlns="http://www.w3.org/2000/svg">
                    <rect width="300" height="200" fill="#f0f0f0" stroke="#ccc" stroke-width="2"/>
                    <text x="150" y="100" text-anchor="middle" font-family="Arial" font-size="16" fill="#666">
                        Imagem do Produto
                    </text>
                </svg>';
                Storage::disk('public')->put($caminho, $svg);
            }
        }
    }
}
