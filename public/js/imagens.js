/**
 * Imagens JavaScript
 * Gerencia ampliação de imagens e animações de cards
 */

// Função global para ampliar imagem
function toggleImageSize() {
    const modal = new bootstrap.Modal(document.getElementById("imageModal"));
    modal.show();
}

document.addEventListener("DOMContentLoaded", function () {
    // Animar cards de estatísticas
    const cards = document.querySelectorAll(".row-cards .card");
    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "all 0.5s ease";

        setTimeout(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 100);
    });
});
