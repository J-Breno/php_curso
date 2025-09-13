<div class="card-light dark:card-dark p-6 mb-6 animate-fade-in">
    <div class="flex items-start space-x-4">
        <div class="w-12 h-12 rounded-full overflow-hidden avatar-ring flex-shrink-0">
            <img src="<?= $base ?>/media/avatars/<?= $userInfo->avatar ?>" class="w-full h-full object-cover" />
        </div>

        <div class="flex-1">
            <!-- Placeholder visível quando o campo de comentário está escondido -->
            <div id="feed-new-input-placeholder"
                 class="feed-new-input-placeholder bg-gray-100 dark:bg-dark-700 text-gray-500 dark:text-gray-400 rounded-2xl px-4 py-3 cursor-pointer transition-all duration-300 hover:bg-gray-200 dark:hover:bg-dark-600"
                 style="display: block;">
                O que você está pensando, <?= $firstName ?>?
            </div>

            <!-- Campo de comentário, inicialmente invisível -->
            <div id="feed-new-input"
                 class="feed-new-input bg-white dark:bg-dark-800 border border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-3 min-h-[48px] focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400"
                 contenteditable="true"
                 style="display: none;">
            </div>

            <!-- Preview da imagem -->
            <div id="feed-image-preview" class="mt-3 hidden">
                <img id="feed-preview-image" class="max-w-full max-h-48 rounded-lg" />
                <button type="button" id="feed-remove-image" class="mt-2 text-red-500 text-sm">
                    <i class="fas fa-times"></i> Remover imagem
                </button>
            </div>

            <!-- Barra de ações com botões para enviar -->
            <div class="flex items-center justify-between mt-3">
                <div class="flex items-center space-x-3">
                    <div class="feed-new-photo cursor-pointer p-2 rounded-xl bg-gray-100 dark:bg-dark-700 hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors duration-200 group relative">
                        <i class="fas fa-image text-gray-500 dark:text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-400 text-lg"></i>
                        <input type="file" name="photo" id="photo" class="feed-new-file absolute inset-0 opacity-0 cursor-pointer" accept="image/png, image/jpeg, image/jpg">
                        <span class="absolute -top-8 -left-2 bg-gray-800 dark:bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                            Adicionar foto
                        </span>
                    </div>
                </div>

                <button id="feed-new-send"
                        class="feed-new-send bg-primary-500 hover:bg-primary-600 dark:bg-primary-600 dark:hover:bg-primary-700 text-white px-6 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Publicar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== Variáveis Globais ==========
    const commentInputField = document.getElementById('feed-new-input');
    const commentPlaceholder = document.getElementById('feed-new-input-placeholder');
    const commentSendButton = document.getElementById('feed-new-send');
    const photoInput = document.getElementById('photo');
    const imagePreview = document.getElementById('feed-image-preview');
    const previewImage = document.getElementById('feed-preview-image');
    const removeImageButton = document.getElementById('feed-remove-image');
    let selectedFile = null;

    // ========== Toggling Comment Input ==========
    commentPlaceholder.addEventListener('click', function() {
        commentPlaceholder.style.display = 'none';
        commentInputField.style.display = 'block';
        commentInputField.focus();
    });

    // ========== Upload de Imagem ==========
    photoInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            selectedFile = e.target.files[0];

            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(selectedFile);
        }
    });

    // Remover imagem selecionada
    removeImageButton.addEventListener('click', function() {
        selectedFile = null;
        photoInput.value = '';
        imagePreview.classList.add('hidden');
    });

    // ========== Enviar Post ==========
    async function sendPost() {
        const postText = commentInputField.textContent.trim();
        const hasImage = selectedFile !== null;

        if (postText || hasImage) {
            commentSendButton.disabled = true;
            commentSendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Publicando...</span>';

            try {
                const formData = new FormData();

                if (postText) {
                    formData.append('txt', postText);
                }

                if (hasImage) {
                    formData.append('photo', selectedFile);
                }

                // Determinar a URL correta baseada no tipo de conteúdo
                const url = hasImage ? '<?= $base ?>/ajax_upload.php' : '<?= $base ?>/ajax_post.php';

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (!data.error) {
                    // Limpar campos
                    commentInputField.textContent = '';
                    commentInputField.style.display = 'none';
                    commentPlaceholder.style.display = 'block';

                    if (hasImage) {
                        selectedFile = null;
                        photoInput.value = '';
                        imagePreview.classList.add('hidden');
                    }

                    // Recarregar a página para mostrar o novo post
                    window.location.reload();
                } else {
                    alert('Erro: ' + data.error);
                    console.error('Erro ao postar:', data.error);
                }
            } catch (error) {
                console.error('Erro ao postar:', error);
                alert('Erro ao publicar. Tente novamente.');
            } finally {
                commentSendButton.disabled = false;
                commentSendButton.innerHTML = '<i class="fas fa-paper-plane"></i><span>Publicar</span>';
            }
        } else {
            alert('Digite algo ou selecione uma imagem para publicar.');
        }
    }

    // Event listeners
    commentSendButton.addEventListener('click', sendPost);

    commentInputField.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendPost();
        }
    });

    // Permitir que o campo de texto cresça com o conteúdo
    commentInputField.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
</script>