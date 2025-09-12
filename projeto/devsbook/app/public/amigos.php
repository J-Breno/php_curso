<?php

use dao\PostDaoMysql;
use dao\UserDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'friends';

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
            <!-- Cabeçalho do perfil -->
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
                            <?php if (empty($user->city) === false) : ?>
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

            <!-- Abas de seguidores/seguindo -->
            <div class="card-light dark:card-dark rounded-2xl p-6 animate-fade-in">
                <div class="flex border-b border-gray-200 dark:border-gray-700 mb-6">
                    <?php if (count($user->followers) > 0) : ?>
                        <div class="tab-item mr-6 pb-4 cursor-pointer <?= (count($user->following) === 0) ? 'active' : '' ?>" data-for="followers">
                            <span class="text-lg font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Seguidores</span>
                            <div class="h-1 w-0 bg-primary-500 mt-2 transition-all duration-300"></div>
                        </div>
                    <?php endif ?>
                    <?php if (count($user->following) > 0) : ?>
                        <div class="tab-item pb-4 cursor-pointer <?= (count($user->followers) > 0) ? 'active' : '' ?>" data-for="following">
                            <span class="text-lg font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Seguindo</span>
                            <div class="h-1 w-0 bg-primary-500 mt-2 transition-all duration-300"></div>
                        </div>
                    <?php endif ?>
                </div>

                <div class="tab-content">
                    <!-- Seguidores -->
                    <div class="tab-body" data-item="followers" style="<?= (count($user->following) === 0) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (count($user->followers) > 0) : ?>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                                <?php foreach ($user->followers as $item) : ?>
                                    <?php $friendFirstName = explode(' ', $item->name)[0]; ?>
                                    <div class="friend-card bg-gray-50 dark:bg-dark-700 rounded-xl p-4 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg animate-slide-up">
                                        <a href="<?= $base ?>/perfil.php?id=<?= $item->publicId ?>" class="block">
                                            <div class="friend-avatar mx-auto mb-3 w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border-2 border-white dark:border-dark-600 shadow-md">
                                                <img src="<?= $base ?>/media/avatars/<?= $item->avatar ?>?v=<?= $_SESSION['avatar_version'] ?? time() ?>" class="w-full h-full object-cover" />
                                            </div>
                                            <div class="friend-name font-medium text-gray-800 dark:text-white truncate"><?= $friendFirstName ?></div>
                                            <div class="text-xs text-primary-500 mt-1">Ver perfil</div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-10">
                                <div class="text-gray-400 dark:text-gray-500 text-6xl mb-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">Nenhum seguidor ainda</p>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Seguindo -->
                    <div class="tab-body" data-item="following" style="<?= (count($user->followers) > 0) ? 'display: none;' : 'display: block;' ?>">
                        <?php if (count($user->following) > 0) : ?>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                                <?php foreach ($user->following as $item) : ?>
                                    <?php $friendFirstName = explode(' ', $item->name)[0]; ?>
                                    <div class="friend-card bg-gray-50 dark:bg-dark-700 rounded-xl p-4 text-center transition-all duration-300 hover:scale-105 hover:shadow-lg animate-slide-up">
                                        <a href="<?= $base ?>/perfil.php?id=<?= $item->publicId ?>" class="block">
                                            <div class="friend-avatar mx-auto mb-3 w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden border-2 border-white dark:border-dark-600 shadow-md">
                                                <img src="<?= $base ?>/media/avatars/<?= $item->avatar ?>?v=<?= $_SESSION['avatar_version'] ?? time() ?>" class="w-full h-full object-cover" />
                                            </div>
                                            <div class="friend-name font-medium text-gray-800 dark:text-white truncate"><?= $friendFirstName ?></div>
                                            <div class="text-xs text-primary-500 mt-1">Ver perfil</div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-10">
                                <div class="text-gray-400 dark:text-gray-500 text-6xl mb-4">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">Não segue ninguém ainda</p>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .profile-cover {
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .tab-item.active span {
            color: #ff2e2e;
            font-weight: 600;
        }

        .tab-item.active div {
            width: 100%;
        }

        .friend-card {
            transition: all 0.3s ease;
        }

        .friend-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .friend-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .friend-avatar {
            transition: all 0.3s ease;
        }

        .friend-card:hover .friend-avatar {
            transform: scale(1.1);
        }
    </style>

    <script>
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-item').forEach(t => {
                    t.classList.remove('active');
                });

                this.classList.add('active');

                const tabName = this.getAttribute('data-for');
                document.querySelectorAll('.tab-body').forEach(body => {
                    body.style.display = 'none';
                });
                document.querySelector(`.tab-body[data-item="${tabName}"]`).style.display = 'block';
            });
        });

        const friendCards = document.querySelectorAll('.friend-card');
        friendCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    </script>

<?php require_once('../partials/footer.php'); ?>