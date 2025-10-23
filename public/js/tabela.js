/**
 * Tabela JavaScript
 * Gerencia funcionalidades de busca, ordenação e interações da tabela
 */

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const clearSearchBtn = document.getElementById('clear-search');
    
    // Função para atualizar a URL com parâmetros
    function updateUrl(params) {
        const url = new URL(window.location);
        
        // Limpar parâmetros existentes
        url.searchParams.delete('search');
        url.searchParams.delete('page');
        
        // Adicionar novos parâmetros
        Object.keys(params).forEach(key => {
            if (params[key]) {
                url.searchParams.set(key, params[key]);
            }
        });
        
        // Redirecionar para nova URL
        window.location.href = url.toString();
    }
    
    // Funcionalidade de busca
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.trim();
                updateUrl({
                    search: searchTerm
                });
            }, 500); // Delay de 500ms para evitar muitas requisições
        });
        
        // Botão de limpar busca
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                updateUrl({
                    search: ''
                });
            });
        }
    }
    
    // Funcionalidade de ordenação
    const sortableHeaders = document.querySelectorAll('th[data-sortable]');
    sortableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            const field = this.dataset.field;
            const currentSort = new URLSearchParams(window.location.search).get('sort');
            const currentDirection = new URLSearchParams(window.location.search).get('direction');
            
            let direction = 'asc';
            if (currentSort === field && currentDirection === 'asc') {
                direction = 'desc';
            }
            
            updateUrl({
                search: searchInput ? searchInput.value : '',
                sort: field,
                direction: direction
            });
        });
    });
});
