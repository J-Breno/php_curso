<?php

use dao\PostDaoMysql;
use dao\UserDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'photos';

$publicId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

if ($publicId === null) {
    $publicId = $userInfo->publicId;
}

if ($publicId !== $userInfo->publicId) {
    $activeMenu = '';
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);

$user = $userDao->findById($publicId, true);

if ($user === false) {
    header("Location: $base");
    exit;
}

$datefrom = new DateTime($user->birthdate);
$dateTo = new DateTime('today');

$user->ageYears = $datefrom->diff($dateTo)->y;

require_once('../partials/header.php');
require_once('../partials/menu.php');
?>

    <section class="feed mt-6">
        <div class="max-w-6xl mx-auto">
            <div class="card-light dark:card-dark rounded-2xl overflow-hidden mb-6 animate-fade-in">
                <div class="relative">
                    <div class="profile-cover h-48 md:h-60 w-full bg-cover bg-center" style="background-image: url('<?= $base ?>/media/covers/<?= $user->cover ?>?v=<?= $_SESSION['cover_version'] ?? time() ?>');"></div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent h-32"></div>

                    <div class="absolute -bottom-8 left-6 md:left-8">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white dark:border-dark-800 shadow-lg avatar-ring">
                            <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>?v=<?= $_SESSION['avatar_version'] ?? time() ?>" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-12 md:pt-14 md:pl-40">
                    <div class="flex flex-col md:flex-row md:items-end md:justify-between">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-dark"><?= $user->name ?></h1>
                            <?php if (!empty($user->city)) : ?>
                                <div class="flex items-center mt-1 text-gray-600 dark:text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>
                                    <span><?= $user->city ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex mt-4 md:mt-0 space-x-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400"><?= count($user->followers) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Seguidores</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400"><?= count($user->following) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Seguindo</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400"><?= count($user->photos) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Fotos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-light dark:card-dark rounded-2xl p-6 animate-fade-in">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-dark flex items-center">
                        <i class="fas fa-images mr-3 text-primary-500"></i>
                        Galeria de Fotos
                    </h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        <?= count($user->photos) ?> foto<?= count($user->photos) !== 1 ? 's' : '' ?>
                    </span>
                </div>

                <?php if (count($user->photos) > 0) : ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        <?php foreach ($user->photos as $key => $item) : ?>
                            <?php
                            $photoDate = property_exists($item, 'created_at') && !empty($item->created_at) ?
                                date('d/m/Y \à\s H:i', strtotime($item->created_at)) :
                                date('d/m/Y');

                            $photoDescription = property_exists($item, 'description') ? $item->description : '';
                            ?>
                            <div class="photo-item group relative overflow-hidden rounded-xl shadow-md transition-all duration-500 hover:shadow-xl animate-slide-up" style="animation-delay: <?= $key * 0.1 ?>s">
                                <a href="javascript:void(0)" data-image-src="<?= $base ?>/media/uploads/<?= $item->body ?>" data-user-name="<?= $user->name ?>" data-date="<?= $photoDate ?>" data-description="<?= htmlspecialchars($photoDescription, ENT_QUOTES) ?>" class="open-modal block cursor-pointer">
                                    <div class="aspect-square overflow-hidden">
                                        <img src="<?= $base ?>/media/uploads/<?= $item->body ?>"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                             alt="Foto de <?= $user->name ?>" />
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <div class="bg-white dark:bg-dark-800 rounded-full p-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                            <i class="fas fa-search-plus text-primary-500 text-lg"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php else : ?>
                    <div class="text-center py-16">
                        <div class="text-gray-300 dark:text-gray-600 text-6xl mb-4">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-500 dark:text-gray-400 mb-2">Nenhuma foto ainda</h3>
                        <p class="text-gray-400 dark:text-gray-500">
                            <?= ($user->id === $userInfo->id) ? 'Compartilhe suas primeiras fotos!' : 'Este usuário ainda não compartilhou fotos.' ?>
                        </p>
                        <?php if ($user->id === $userInfo->id) : ?>
                            <a href="<?= $base ?>/perfil.php" class="btn-primary inline-flex items-center mt-4 px-6 py-3 text-white">
                                <i class="fas fa-plus mr-2"></i>
                                Fazer uma publicação
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <div id="photoModal" class="modal fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="card-light dark:card-dark rounded-2xl p-4 max-w-4xl w-full mx-4 relative transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-hidden z-10">
            <button class="close-modal absolute top-4 right-4 z-20 bg-white dark:bg-dark-700 rounded-full p-2 shadow-lg hover:bg-gray-100 dark:hover:bg-dark-600 transition-colors duration-200">
                <i class="fas fa-times text-gray-600 dark:text-gray-300 text-lg"></i>
            </button>

            <div class="flex flex-col h-full">
                <div class="flex items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3 flex-shrink-0">
                        <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>?v=<?= $_SESSION['avatar_version'] ?? time() ?>"
                             class="w-full h-full object-cover"
                             id="modalUserAvatar" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-800 dark:text-white truncate" id="modalUserName"></div>
                        <div class="text-sm text-gray-500 dark:text-gray-400" id="modalDate"></div>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-4 flex items-center justify-center min-h-[300px]">
                    <div class="relative w-full h-full flex items-center justify-center">
                        <img id="modalImage" src="" class="max-w-full max-h-[70vh] object-contain hidden" alt=""
                             onerror="handleImageError(this)" />
                        <div id="modalLoading" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-dark-800 bg-opacity-80">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-500"></div>
                        </div>

                        <div id="modalDebug" class="absolute top-2 left-2 bg-red-100 text-red-800 text-xs p-2 rounded hidden">
                            <div id="debugInfo"></div>
                        </div>
                    </div>
                </div>

                <div id="modalDescription" class="p-4 border-t border-gray-200 dark:border-gray-700 hidden">
                    <p class="text-gray-700 dark:text-gray-300" id="modalDescriptionText"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.modalDebug = true;

        function openModal(imageSrc, userName, date, description) {
            console.log('=== DEBUG MODAL START ===');
            console.log('Image src:', imageSrc);
            console.log('User name:', userName);
            console.log('Date:', date);
            console.log('Description:', description);

            if (window.modalDebug) {
                document.getElementById('modalDebug').classList.remove('hidden');
                document.getElementById('debugInfo').innerHTML = `
                <strong>URL:</strong> ${imageSrc}<br>
                <strong>Status:</strong> Carregando...
            `;
            }

            document.getElementById('modalLoading').classList.remove('hidden');
            document.getElementById('modalImage').classList.add('hidden');
            document.getElementById('modalImage').src = '';

            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('modalDate').textContent = date;

            const descriptionElement = document.getElementById('modalDescription');
            const descriptionText = document.getElementById('modalDescriptionText');
            if (description && description.trim() !== '') {
                descriptionText.textContent = description;
                descriptionElement.classList.remove('hidden');
            } else {
                descriptionElement.classList.add('hidden');
            }

            const modalImage = document.getElementById('modalImage');
            const loadingElement = document.getElementById('modalLoading');

            const testImage = new Image();

            testImage.onload = function() {
                console.log('✅ Imagem carregada com sucesso (onload)');
                modalImage.src = imageSrc;
                modalImage.classList.remove('hidden');
                loadingElement.classList.add('hidden');

                if (window.modalDebug) {
                    document.getElementById('debugInfo').innerHTML += '<br><strong>Status:</strong> ✅ Carregada!';
                }
            };

            testImage.onerror = function() {
                console.error('❌ Erro no carregamento (onerror)');

                setTimeout(() => {
                    if (modalImage.complete && modalImage.naturalHeight === 0) {
                        console.log('❌ Imagem ainda não carregada após timeout');

                        const absoluteUrl = new URL(imageSrc, window.location.origin).href;
                        console.log('Tentando URL absoluta:', absoluteUrl);

                        modalImage.src = absoluteUrl;
                        modalImage.onload = function() {
                            console.log('✅ Imagem carregada via URL absoluta');
                            loadingElement.classList.add('hidden');
                            modalImage.classList.remove('hidden');
                        };

                        modalImage.onerror = function() {
                            console.error('❌ Falha total no carregamento');
                            handleImageError(modalImage);
                            loadingElement.classList.add('hidden');
                        };
                    }
                }, 1000);
            };

            console.log('Iniciando carregamento...');
            testImage.src = imageSrc;

            document.getElementById('photoModal').classList.add('open');
            document.body.style.overflow = 'hidden';

            console.log('=== DEBUG MODAL END ===');
        }

        function handleImageError(imgElement) {
            console.warn('Usando imagem de fallback');
            imgElement.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBkeT0iLjM1ZW0iIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtc2l6ZT0iMjAiIGZpbGw9IiM5OTkiPkVycm8gY2FycmVnYW5kbyBpbWFnZW08L3RleHQ+PC9zdmc+';
            imgElement.classList.remove('hidden');

            if (window.modalDebug) {
                document.getElementById('debugInfo').innerHTML += '<br><strong>Status:</strong> ❌ Erro ao carregar';
            }
        }

        function closeModal() {
            document.getElementById('photoModal').classList.remove('open');
            document.body.style.overflow = 'auto';
            document.getElementById('modalDebug').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔧 Modal inicializado - Modo debug ativo');

            document.querySelectorAll('.open-modal').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const imageSrc = this.getAttribute('data-image-src');
                    const userName = this.getAttribute('data-user-name');
                    const date = this.getAttribute('data-date');
                    const description = this.getAttribute('data-description');

                    openModal(imageSrc, userName, date, description);
                });
            });

            document.querySelectorAll('.close-modal').forEach(button => {
                button.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
<?php require_once('../partials/footer.php'); ?>

