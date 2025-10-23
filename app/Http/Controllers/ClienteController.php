<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use App\Traits\Loggable;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use Loggable;
    private const ITENS_POR_PAGINA = 6;
    private const CAMPOS_ORDENACAO_PERMITIDOS = ['nome', 'email', 'data_cadastro', 'status'];
    private const CAMPOS_BUSCA = ['nome', 'email'];

    /**
     * Exibe a listagem de clientes com busca e ordenação
     */
    public function index(Request $request)
    {
        $query = Cliente::query()
            ->search($request->get('search'), self::CAMPOS_BUSCA)
            ->sort(
                $request->get('sort', 'nome'),
                $request->get('direction', 'asc'),
                self::CAMPOS_ORDENACAO_PERMITIDOS,
                'nome'
            );

        $clientes = $query->paginate(self::ITENS_POR_PAGINA)->withQueryString();

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Exibe o formulário para criação de novo cliente
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Armazena um novo cliente no banco de dados
     */
    public function store(ClienteRequest $request)
    {
        $cliente = Cliente::create($request->validated());

        // Registrar log da criação
        $this->logCriacao('Cliente', $cliente->nome, [
            'email' => $cliente->email,
            'status' => $cliente->status ? 'Ativo' : 'Inativo'
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um cliente específico
     */
    public function show(Cliente $cliente)
    {
        $cliente->load('pedidos');
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Exibe o formulário para edição de um cliente
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza os dados de um cliente no banco de dados
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $data = $request->validated();
        // Preserva a data de cadastro original
        $data['data_cadastro'] = $cliente->data_cadastro;

        $cliente->update($data);

        // Registrar log da atualização
        $this->logAtualizacao('Cliente', $cliente->nome, [
            'email' => $cliente->email,
            'status' => $cliente->status ? 'Ativo' : 'Inativo'
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove um cliente do banco de dados
     */
    public function destroy(Cliente $cliente)
    {
        if (!$cliente->podeSerExcluido()) {
            return redirect()->route('clientes.index')
                ->with('error', 'Não é possível excluir cliente que possui pedidos!');
        }

        // Registrar log da exclusão antes de excluir
        $this->logExclusao('Cliente', $cliente->nome, [
            'email' => $cliente->email,
            'data_cadastro' => $cliente->data_cadastro->format('d/m/Y')
        ]);

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Alterna o status ativo/inativo de um cliente
     */
    public function toggleStatus(Cliente $cliente)
    {
        $statusAnterior = $cliente->status ? 'Ativo' : 'Inativo';
        $cliente->update(['status' => !$cliente->status]);
        $statusNovo = $cliente->status ? 'Ativo' : 'Inativo';
        
        // Registrar log da mudança de status
        $this->logAtualizacao('Cliente', $cliente->nome, [
            'email' => $cliente->email,
            'status_anterior' => $statusAnterior,
            'status_novo' => $statusNovo
        ]);
        
        $status = $cliente->status ? 'ativado' : 'desativado';
        
        return redirect()->route('clientes.index')
            ->with('success', "Cliente {$status} com sucesso!");
    }
}
