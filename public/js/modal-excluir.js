/**
 * Modal de Exclusão JavaScript
 * Gerencia funcionalidades do modal de confirmação de exclusão
 */

document.addEventListener("DOMContentLoaded", function () {
    const modalId = "modalExcluir"; // ID padrão do modal
    const modal = document.getElementById(modalId);
    const form = document.getElementById(`formExcluir${modalId}`);

    if (!modal || !form) return;

    // Configurar ação do modal quando abrir
    modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const itemId = button.getAttribute("data-item-id");
        const itemNome = button.getAttribute("data-item-nome");
        const rota = button.getAttribute("data-rota");

        // Atualizar informações do modal
        if (itemNome) {
            const itemElement = modal.querySelector(".text-dark");
            if (itemElement) {
                itemElement.textContent = itemNome;
            }
        }

        // Configurar ação do formulário
        if (rota && itemId) {
            form.action = rota.replace(":id", itemId);
        }
    });

    // Adicionar loading state no submit
    form.addEventListener("submit", function () {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML =
            '<i class="bx bx-loader-alt bx-spin me-1"></i>Excluindo...';
        submitBtn.disabled = true;
    });
});
