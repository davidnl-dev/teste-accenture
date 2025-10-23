<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar clientes de exemplo
        Cliente::create([
            'nome' => 'Pedro Oliveira',
            'email' => 'pedro.oliveira@accenture.com',
            'data_cadastro' => '2025-08-10',
            'status' => true,
        ]);

        Cliente::create([
            'nome' => 'Ana Costa',
            'email' => 'ana.costa@accenture.com',
            'data_cadastro' => '2025-09-05',
            'status' => false,
        ]);

        Cliente::create([
            'nome' => 'Carlos Ferreira',
            'email' => 'carlos.ferreira@accenture.com',
            'data_cadastro' => '2025-10-12',
            'status' => true,
        ]);

        // Adicionar 3 novos clientes
        Cliente::create([
            'nome' => 'Maria Silva',
            'email' => 'maria.silva@accenture.com',
            'data_cadastro' => '2025-10-15',
            'status' => true,
        ]);

        Cliente::create([
            'nome' => 'João Santos',
            'email' => 'joao.santos@accenture.com',
            'data_cadastro' => '2025-10-18',
            'status' => true,
        ]);

        Cliente::create([
            'nome' => 'Fernanda Lima',
            'email' => 'fernanda.lima@accenture.com',
            'data_cadastro' => '2025-10-20',
            'status' => false,
        ]);
    }
}