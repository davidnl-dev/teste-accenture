<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\ProdutoRequest;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    use Loggable;
    private const ITENS_POR_PAGINA = 6;
    private const CAMPOS_ORDENACAO_PERMITIDOS = ['nome', 'categoria', 'preco', 'estoque', 'ativo', 'adicionado_em'];
    private const CAMPOS_BUSCA = ['nome', 'categoria'];

    /**
     * Exibe a listagem de produtos com busca e ordenação
     */
    public function index(Request $request)
    {
        $query = Produto::query()
            ->search($request->get('search'), self::CAMPOS_BUSCA)
            ->sort(
                $request->get('sort', 'adicionado_em'),
                $request->get('direction', 'desc'),
                self::CAMPOS_ORDENACAO_PERMITIDOS,
                'adicionado_em'
            );

        $produtos = $query->paginate(self::ITENS_POR_PAGINA)->withQueryString();

        return view('produtos.index', compact('produtos'));
    }

    /**
     * Exibe o formulário para criação de novo produto
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Armazena um novo produto no banco de dados
     */
    public function store(ProdutoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto = Produto::create($data);

        // Registrar log da criação
        $this->logCriacao('Produto', $produto->nome, [
            'categoria' => $produto->categoria,
            'preco' => 'R$ ' . number_format($produto->preco, 2, ',', '.'),
            'estoque' => $produto->estoque,
            'status' => $produto->ativo ? 'Ativo' : 'Inativo'
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um produto específico
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Exibe o formulário para edição de um produto
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Atualiza os dados de um produto no banco de dados
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $data = $request->validated();

        if ($request->hasFile('imagem')) {
            // Remove a imagem anterior se existir
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('produtos', 'public');
        }

        $produto->update($data);

        // Registrar log da atualização
        $this->logAtualizacao('Produto', $produto->nome, [
            'categoria' => $produto->categoria,
            'preco' => 'R$ ' . number_format($produto->preco, 2, ',', '.'),
            'estoque' => $produto->estoque,
            'status' => $produto->ativo ? 'Ativo' : 'Inativo'
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove um produto do banco de dados
     */
    public function destroy(Produto $produto)
    {
        // Registrar log da exclusão antes de excluir
        $this->logExclusao('Produto', $produto->nome, [
            'categoria' => $produto->categoria,
            'preco' => 'R$ ' . number_format($produto->preco, 2, ',', '.'),
            'estoque' => $produto->estoque,
            'data_criacao' => $produto->adicionado_em ? $produto->adicionado_em->format('d/m/Y') : 'N/A'
        ]);

        // A imagem será removida automaticamente pelo evento do modelo
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }

    /**
     * Alterna o status ativo/inativo de um produto
     */
    public function toggleStatus(Produto $produto)
    {
        $statusAnterior = $produto->ativo ? 'Ativo' : 'Inativo';
        $produto->update(['ativo' => !$produto->ativo]);
        $statusNovo = $produto->ativo ? 'Ativo' : 'Inativo';
        
        // Registrar log da mudança de status
        $this->logAtualizacao('Produto', $produto->nome, [
            'categoria' => $produto->categoria,
            'status_anterior' => $statusAnterior,
            'status_novo' => $statusNovo
        ]);
        
        $status = $produto->ativo ? 'ativado' : 'desativado';
        
        return redirect()->back()
            ->with('success', "Produto {$status} com sucesso!");
    }
}
