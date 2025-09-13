<?php

$actionPhrase = '';
$body = '';

switch ($item->type) {
    case 'text':
        $actionPhrase = 'fez um post';
        $body = str_replace('&#13;&#10;', '<br>', $item->body);
        break;
    case 'photo':
        $actionPhrase = 'postou uma foto';
        $body = '<div class="rounded-2xl overflow-hidden shadow-lg"><img src="' . $base . '/media/uploads/' . $item->body . '" alt="' . $item->body . '" class="w-full h-auto max-h-96 object-contain"></div>';
        break;
}

$createdAt = date('d/m/Y H:i', strtotime($item->createdAt));
?>

<div class="card-light dark:card-dark p-6 mb-6 animate-fade-in" data-id="<?= $item->publicId ?>">
    <!-- Cabeçalho do Post -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
            <a href="<?= $base ?>/perfil.php?id=<?= $item->user->publicId ?>" class="w-12 h-12 rounded-full overflow-hidden avatar-ring flex-shrink-0">
                <img src="<?= $base ?>/media/avatars/<?= $item->user->avatar ?>" class="w-full h-full object-cover" />
            </a>
            <div>
                <a href="<?= $base ?>/perfil.php?id=<?= $item->user->publicId ?>" class="font-semibold text-gray-900 dark:text-dark hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                    <?= $item->user->name ?>
                </a>
                <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-dark">
                    <span><?= $actionPhrase ?></span>
                    <span>•</span>
                    <span class="text-xs"><?= $createdAt ?></span>
                </div>
            </div>
        </div>

        <?php if ($item->mine) : ?>
            <div class="relative group">
                <button class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors duration-200">
                    <i class="fas fa-ellipsis-h text-gray-500 dark:text-gray-400"></i>
                </button>
                <div class="absolute right-0 top-full mt-1 bg-white dark:bg-dark-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg py-2 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 min-w-[120px]">
                    <a href="<?= $base ?>/excluir_post_action.php?id=<?= $item->publicId ?>" class="px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center space-x-2">
                        <i class="fas fa-trash text-xs"></i>
                        <span>Excluir</span>
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- Conteúdo do Post -->
    <div class="mb-4 text-gray-800 dark:text-dark leading-relaxed">
        <?= $body ?>
    </div>

    <!-- Estatísticas e Ações -->
    <div class="flex items-center justify-between border-t border-b border-gray-100 dark:border-gray-800 py-3 mb-4">
        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
            <span class="like-count"><?= $item->likeCount ?> curtida<?= $item->likeCount != 1 ? 's' : '' ?></span>
            <span>•</span>
            <span class="comment-count"><?= count($item->comments) ?> comentário<?= count($item->comments) != 1 ? 's' : '' ?></span>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex items-center justify-around mb-4">
        <button class="like-btn flex items-center space-x-2 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors duration-200 <?= $item->liked ? 'text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' ?>">
            <i class="fas fa-heart <?= $item->liked ? 'fas' : 'far' ?>"></i>
            <span>Curtir</span>
        </button>
        <button class="comment-trigger flex items-center space-x-2 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors duration-200 text-gray-500 dark:text-gray-400">
            <i class="far fa-comment"></i>
            <span>Comentar</span>
        </button>
    </div>

    <!-- Comentários -->
    <div class="feed-item-comments">
        <div class="feed-item-comments-area space-y-3 mb-4">
            <?php foreach ($item->comments as $comment) : ?>
                <div class="flex items-start space-x-3">
                    <a href="<?= $base ?>/perfil.php?id=<?= $comment->user->publicId ?>" class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                        <img src="<?= $base ?>/media/avatars/<?= $comment->user->avatar ?>" class="w-full h-full object-cover" />
                    </a>
                    <div class="flex-1 bg-gray-50 dark:bg-dark-700 rounded-2xl px-4 py-2">
                        <a href="<?= $base ?>/perfil.php?id=<?= $comment->user->publicId ?>" class="font-semibold text-sm text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">
                            <?= $comment->user->name ?>
                        </a>
                        <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $comment->body ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Campo de Comentário -->
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                <img src="<?= $base ?>/media/avatars/<?= $userInfo->avatar ?>" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 relative">
                <input type="text" class="fic-item-field w-full bg-gray-100 dark:bg-dark-700 border-none rounded-2xl px-4 py-2 pr-12 text-gray-900 dark:text-dark placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:outline-none" placeholder="Escreva um comentário..." />
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== LIKE FUNCTIONALITY ==========
    function setupLikeFunctionality() {
        // Remover e recriar todos os botões de like para evitar event listeners duplicados
        document.querySelectorAll('.like-btn').forEach(btn => {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', async function() {
                const postElement = this.closest('[data-id]');
                const postId = postElement.getAttribute('data-id');
                const likeCountElement = postElement.querySelector('.like-count');
                const likeIcon = this.querySelector('i');
                const likeText = this.querySelector('span');

                try {
                    const response = await fetch(`<?= $base ?>/ajax_like.php?id=${postId}`);

                    if (response.ok) {
                        const data = await response.json();

                        if (data.error) {
                            console.error('Erro:', data.error);
                            return;
                        }

                        // Atualizar com base na resposta do servidor
                        if (data.liked) {
                            this.classList.add('text-primary-600', 'dark:text-primary-400');
                            this.classList.remove('text-gray-500', 'dark:text-gray-400');
                            likeIcon.classList.add('fas');
                            likeIcon.classList.remove('far');
                            if (likeText) likeText.textContent = 'Descurtir';
                        } else {
                            this.classList.remove('text-primary-600', 'dark:text-primary-400');
                            this.classList.add('text-gray-500', 'dark:text-gray-400');
                            likeIcon.classList.remove('fas');
                            likeIcon.classList.add('far');
                            if (likeText) likeText.textContent = 'Curtir';
                        }

                        // Atualizar contador
                        likeCountElement.textContent = `${data.likeCount} curtida${data.likeCount !== 1 ? 's' : ''}`;
                    }
                } catch (error) {
                    console.error('Erro ao curtir:', error);

                    // Fallback visual em caso de erro
                    const isCurrentlyLiked = this.classList.contains('text-primary-600');

                    if (isCurrentlyLiked) {
                        this.classList.remove('text-primary-600', 'dark:text-primary-400');
                        this.classList.add('text-gray-500', 'dark:text-gray-400');
                        likeIcon.classList.remove('fas');
                        likeIcon.classList.add('far');
                        if (likeText) likeText.textContent = 'Curtir';

                        // Decrementar contador visualmente
                        let currentCount = parseInt(likeCountElement.textContent.match(/\d+/)[0]);
                        likeCountElement.textContent = `${Math.max(0, currentCount - 1)} curtida${currentCount - 1 !== 1 ? 's' : ''}`;
                    } else {
                        this.classList.add('text-primary-600', 'dark:text-primary-400');
                        this.classList.remove('text-gray-500', 'dark:text-gray-400');
                        likeIcon.classList.add('fas');
                        likeIcon.classList.remove('far');
                        if (likeText) likeText.textContent = 'Descurtir';

                        // Incrementar contador visualmente
                        let currentCount = parseInt(likeCountElement.textContent.match(/\d+/)[0]);
                        likeCountElement.textContent = `${currentCount + 1} curtida${currentCount + 1 !== 1 ? 's' : ''}`;
                    }
                }
            });
        });
    }

    // ========== COMMENT FUNCTIONALITY ==========
    function setupCommentFunctionality() {
        let isSending = false;

        // Event delegation para o botão de enviar comentário
        document.addEventListener('click', function(e) {
            const sendButton = e.target.closest('.fic-item-field + button');
            if (sendButton && !isSending) {
                e.preventDefault();
                const input = sendButton.previousElementSibling;
                if (input && input.classList.contains('fic-item-field')) {
                    sendComment(input);
                }
            }
        });

        // Event listener para tecla Enter
        document.addEventListener('keypress', function(e) {
            if (e.target.classList.contains('fic-item-field') && e.key === 'Enter' && !isSending) {
                e.preventDefault();
                sendComment(e.target);
            }
        });

        // Event listener para toggle de comentários
        document.querySelectorAll('.comment-trigger').forEach(btn => {
            btn.addEventListener('click', function() {
                const commentsArea = this.closest('.card-light, .card-dark').querySelector('.feed-item-comments');
                commentsArea.style.display = commentsArea.style.display === 'none' ? 'block' : 'none';
            });
        });

        async function sendComment(input) {
            if (isSending) return;
            isSending = true;

            const postElement = input.closest('[data-id]');
            const postId = postElement.getAttribute('data-id');
            const comment = input.value.trim();

            if (comment) {
                try {
                    const formData = new FormData();
                    formData.append('id', postId);
                    formData.append('txt', comment);

                    const response = await fetch('<?= $base ?>/ajax_comment.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (!data.error) {
                        input.value = '';

                        // Adicionar comentário dinamicamente, verificando se já existe
                        if (!document.getElementById(`comment-${data.id}`)) {
                            const commentHtml = `
                            <div id="comment-${data.id}" class="flex items-start space-x-3">
                                <a href="${data.link}" class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                                    <img src="${data.avatar}" class="w-full h-full object-cover" />
                                </a>
                                <div class="flex-1 bg-gray-50 dark:bg-dark-700 rounded-2xl px-4 py-2">
                                    <a href="${data.link}" class="font-semibold text-sm text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">
                                        ${data.name}
                                    </a>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm">${data.body}</p>
                                </div>
                            </div>
                        `;

                            const commentsArea = postElement.querySelector('.feed-item-comments-area');
                            commentsArea.insertAdjacentHTML('beforeend', commentHtml);

                            // Atualizar contador de comentários
                            const commentCountElement = postElement.querySelector('.comment-count');
                            let currentCommentCount = parseInt(commentCountElement.textContent.match(/\d+/)[0]);
                            currentCommentCount++;
                            commentCountElement.textContent = `${currentCommentCount} comentário${currentCommentCount !== 1 ? 's' : ''}`;
                        }
                    }
                } catch (error) {
                    console.error('Erro ao comentar:', error);
                } finally {
                    isSending = false;
                }
            } else {
                isSending = false;
            }
        }
    }

    // ========== INITIALIZE EVERYTHING ==========
    document.addEventListener('DOMContentLoaded', function() {
        setupLikeFunctionality();
        setupCommentFunctionality();
    });

    // Função global para re-inicializar se novos posts forem carregados
    if (typeof window.initializeFeedItems === 'undefined') {
        window.initializeFeedItems = function() {
            setupLikeFunctionality();
            setupCommentFunctionality();
        };
    }

</script>