/**
 * Pedidos JavaScript
 * Gerencia cálculos de total, validações e interações dos formulários de pedidos
 */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("pedidoForm");
    if (!form) return;

    const submitBtn = form.querySelector('button[type="submit"]');
    const produtoSelect = document.getElementById("produto-select");
    const quantidadeInput = document.getElementById("quantidade-input");
    const precoUnitario = document.getElementById("preco-unitario");
    const total = document.getElementById("total");
    const estoqueDisponivel = document.getElementById("estoque-disponivel");

    // Loading state durante envio
    form.addEventListener("submit", function () {
        const isEdit = form.action.includes("update");
        submitBtn.innerHTML = `<i class="bx bx-loader-alt bx-spin me-1"></i>${
            isEdit ? "Atualizando..." : "Salvando..."
        }`;
        submitBtn.disabled = true;
    });

    function calcularTotal() {
        if (!produtoSelect || !quantidadeInput || !precoUnitario || !total)
            return;

        const produto = produtoSelect.options[produtoSelect.selectedIndex];
        const preco = parseFloat(produto.dataset.preco) || 0;
        const quantidade = parseInt(quantidadeInput.value) || 0;

        precoUnitario.value = preco.toFixed(2).replace(".", ",");
        total.value = (preco * quantidade).toFixed(2).replace(".", ",");
    }

    function atualizarEstoque() {
        if (!produtoSelect || !quantidadeInput || !estoqueDisponivel) return;

        const produto = produtoSelect.options[produtoSelect.selectedIndex];
        const estoque = produto.dataset.estoque || 0;

        if (produto.value) {
            estoqueDisponivel.innerHTML = `<i class="bx bx-package me-1"></i>${estoque} unidades disponíveis`;
            quantidadeInput.max = estoque;

            // Validação de estoque
            if (parseInt(quantidadeInput.value) > estoque) {
                quantidadeInput.classList.add("is-invalid");
                quantidadeInput.setCustomValidity(
                    "Quantidade maior que o estoque disponível"
                );
            } else {
                quantidadeInput.classList.remove("is-invalid");
                quantidadeInput.setCustomValidity("");
            }
        } else {
            estoqueDisponivel.innerHTML =
                '<i class="bx bx-package me-1"></i>Selecione um produto';
            quantidadeInput.max = "";
        }
    }

    if (produtoSelect) {
        produtoSelect.addEventListener("change", function () {
            atualizarEstoque();
            calcularTotal();
        });
    }

    if (quantidadeInput) {
        quantidadeInput.addEventListener("input", function () {
            calcularTotal();
            atualizarEstoque(); // Revalidar estoque
        });
    }

    // Auto-focus no primeiro campo
    const firstSelect = document.querySelector('select[name="cliente_id"]');
    if (firstSelect) {
        firstSelect.focus();
    }

    // Validação em tempo real
    const inputs = form.querySelectorAll("input[required], select[required]");
    inputs.forEach((input) => {
        input.addEventListener("blur", function () {
            if (this.value.trim() === "") {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });
    });

    // Inicializar valores
    atualizarEstoque();
    calcularTotal();
});
