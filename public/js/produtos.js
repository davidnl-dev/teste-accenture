/**
 * Produtos JavaScript
 * Gerencia upload de imagens, pré-visualização e interações dos formulários de produtos
 */

document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const currentImage = document.getElementById('currentImage');

    // Clique na área de upload
    if (uploadArea) {
        uploadArea.addEventListener('click', () => {
            imageInput.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });
    }

    // Mudança no input de arquivo
    if (imageInput) {
        imageInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        });
    }

    function handleFile(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('d-none');
                if (currentImage) {
                    currentImage.style.display = 'none';
                }
                if (uploadArea) {
                    uploadArea.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        } else {
            alert('Por favor, selecione apenas arquivos de imagem.');
        }
    }

    // Funções globais para botões onclick
    window.changeImage = function() {
        if (imageInput) {
            imageInput.click();
        }
    };

    window.removeNewImage = function() {
        if (imageInput) {
            imageInput.value = '';
        }
        if (imagePreview) {
            imagePreview.classList.add('d-none');
        }
        if (currentImage) {
            currentImage.style.display = 'block';
        }
        if (uploadArea) {
            uploadArea.style.display = 'block';
        }
    };

    window.removeImage = function() {
        if (imageInput) {
            imageInput.value = '';
        }
        if (imagePreview) {
            imagePreview.classList.add('d-none');
        }
        if (uploadArea) {
            uploadArea.style.display = 'block';
        }
    };
});
