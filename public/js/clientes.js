/**
 * Clientes JavaScript
 * Gerencia validações e interações dos formulários de clientes
 */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("clienteForm");
    if (!form) return;

    const submitBtn = form.querySelector('button[type="submit"]');

    if (submitBtn) {
        form.addEventListener("submit", function () {
            const isEdit = form.action.includes("update");
            submitBtn.innerHTML = `<i class="bx bx-loader-alt bx-spin me-1"></i>${
                isEdit ? "Atualizando..." : "Salvando..."
            }`;
            submitBtn.disabled = true;
        });
    }

    // Auto-focus no primeiro campo
    const firstInput = document.querySelector('input[name="nome"]');
    if (firstInput) {
        firstInput.focus();
    }

    // Validação em tempo real
    const inputs = form.querySelectorAll("input[required]");
    inputs.forEach((input) => {
        input.addEventListener("blur", function () {
            if (this.value.trim() === "") {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });
    });
});
