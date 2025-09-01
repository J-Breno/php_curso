<?php

use dao\PostDaoMysql;
use dao\UserDaoMysql;
use dao\UserRelationDaoMysql;
use models\Auth;

require_once('../config.php');
require_once('../models/Auth.php');
require_once('../dao/PostDaoMysql.php');
require_once('../dao/UserRelationDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'profile';

$publicId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);

if ($publicId === $userInfo->publicId) {
    header("Location: $base/perfil.php");
    exit;
}

if ($publicId === null) {
    $publicId = $userInfo->publicId;
}

if ($publicId !== $userInfo->publicId) {
    $activeMenu = '';
}

if ($page === null || $page < 1) {
    $page = 1;
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);
$userRelationDao = new UserRelationDaoMysql($pdo);

$user = $userDao->findById($publicId, true);

if (!$user) {
    header("Location: $base");
    exit;
}

$datefrom = new DateTime($user->birthdate);
$dateTo = new DateTime('today');

$user->ageYears = $datefrom->diff($dateTo)->y;

$info = $postDao->getUserFeed($publicId, $userInfo->publicId, $page);
$feed = $info['feed'];
$pages = $info['pages'];
$currentPage = $info['currentPage'];

$isFollowing = $userRelationDao->isFollowing($userInfo->publicId, $publicId);

require_once('../partials/header.php');
require_once('../partials/menu.php');
?>

    <section class="feed">
        <div class="row">
            <div class="box flex-1 border-top-flat">
                <div class="box-body">
                    <div class="profile-cover" style="background-image: url('<?= $base ?>/media/covers/<?= $user->cover ?>');">
                    </div>
                    <div class="profile-info m-20 row">
                        <div class="profile-info-avatar">
                            <img src="<?= $base ?>/media/avatars/<?= $user->avatar ?>" />
                        </div>
                        <div class="profile-info-name">
                            <div class="profile-info-name-text"><?= $user->name ?></div>
                            <?php if (empty($user->city) === false) : ?>
                                <div class="profile-info-location"><?= $user->city ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="profile-info-data row">
                            <?php if ($publicId !== $userInfo->publicId) : ?>
                                <div class="profile-info-item m-width-20">
                                    <a href="<?= $base ?>/follow_action.php?id=<?= $publicId ?>" class="button">
                                        <?= $isFollowing ? 'Seguindo' : 'Seguir' ?>
                                    </a>
                                </div>
                            <?php endif ?>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($user->followers) ?></div>
                                <div class="profile-info-item-s">Seguidores</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($user->following) ?></div>
                                <div class="profile-info-item-s">Seguindo</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?= count($user->photos) ?></div>
                                <div class="profile-info-item-s">Fotos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
sadfadf
        <div class="row">

            <div class="column side pr-5">

                <div class="box">
                    <div class="box-body">

                        <div class="user-info-mini">
                            <img src="<?= $base ?>/assets/images/calendar.png" />
                            <?= date('d/m/Y', strtotime($user->birthdate)) ?> (<?= $user->ageYears ?> anos)
                        </div>

                        <?php if (empty($user->city) === false) : ?>
                            <div class="user-info-mini">
                                <img src="<?= $base ?>/assets/images/pin.png" />
                                <?= $user->city ?>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($user->work) === false) : ?>
                            <div class="user-info-mini">
                                <img src="<?= $base ?>/assets/images/work.png" />
                                <?= $user->work ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <?php if (count($user->following) > 0) : ?>
                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?= count($user->following) ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?= $base ?>/amigos.php?id=<?= $user->publicId ?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">
                            <?php if (count($user->following) > 0) : ?>
                                <?php foreach ($user->following as $item) : ?>
                                    <?php $friendFirstName = explode(' ', $item->name)[0]; ?>
                                    <div class="friend-icon">
                                        <a href="<?= $base ?>/perfil.php?id=<?= $item->publicId ?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?= $base ?>/media/avatars/<?= $item->avatar ?>" />
                                            </div>
                                            <div class="friend-icon-name">
                                                <?= $friendFirstName ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endif ?>

            </div>

            <div class="column pl-5">
                <?php if (count($user->photos) > 0) : ?>
                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?= count($user->photos) ?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?= $base ?>/fotos.php?id=<?= $publicId ?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">

                            <?php foreach ($user->photos as $key => $item) : ?>
                                <?php if ($key < 4) : ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?= $key ?>" rel="modal:open">
                                            <img  src="<?= $base ?>/media/uploads/<?= $item->body ?>" />
                                        </a>
                                        <div id="modal-<?= $key ?>" style="display:none; position:relative;">
                                            <img src="<?= $base ?>/media/uploads/<?= $item->body ?>" style="max-width:100%; height:auto;" />
                                            <a href="#" rel="modal:close" class="modal-close-btn">×</a>
                                        </div>

                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>

                        </div>
                    </div>
                <?php endif ?>

                <?php if ($publicId === $userInfo->publicId) : ?>
                    <?php require('../partials/feed-editor.php') ?>
                <?php endif ?>

                <?php if (count($feed) > 0) : ?>
                    <?php foreach ($feed as $item) : ?>
                        <?php require('../partials/feed-item.php') ?>
                    <?php endforeach ?>
                <?php endif ?>

                <?php if ($pages > 1) : ?>
                    <div class="feed-pagination">
                        <?php for ($q = 1; $q <= $pages; $q++) : ?>
                            <?php
                            $pageString = '';
                            if ($publicId === $userInfo->publicId) {
                                $pageString = "$base/perfil";

                                if ($q > 1) {
                                    $pageString .= "?p=$q";
                                }
                            } else {
                                $pageString = "$base/perfil?id=$publicId";

                                if ($q > 1) {
                                    $pageString .= "&p=$q";
                                }
                            }
                            ?>
                            <a class="<?= $q == $currentPage ? 'active' : '' ?>" href="<?= $pageString ?>">
                                <?= $q ?>
                            </a>
                        <?php endfor ?>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const photoLinks = document.querySelectorAll('.user-photo-item a[rel="modal:open"]');

            photoLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalId = this.getAttribute('href');
                    const modal = document.querySelector(modalId);

                    if (modal) {
                        modal.style.display = 'block';

                        const overlay = document.createElement('div');
                        overlay.style.position = 'fixed';
                        overlay.style.top = '0';
                        overlay.style.left = '0';
                        overlay.style.width = '100%';
                        overlay.style.height = '100%';
                        overlay.style.backgroundColor = 'rgba(0,0,0,0.7)';
                        overlay.style.zIndex = '1000';
                        overlay.id = 'custom-modal-overlay';
                        document.body.appendChild(overlay);

                        modal.style.position = 'fixed';
                        modal.style.top = '50%';
                        modal.style.left = '50%';
                        modal.style.transform = 'translate(-50%, -50%)';
                        modal.style.zIndex = '1001';
                        modal.style.backgroundColor = '#fff';
                        modal.style.padding = '20px';
                        modal.style.borderRadius = '5px';

                        const closeBtn = modal.querySelector('.modal-close-btn');
                        if (closeBtn) {
                            closeBtn.onclick = function(e) {
                                e.preventDefault();
                                modal.style.display = 'none';
                                document.getElementById('custom-modal-overlay')?.remove();
                            };
                        }

                        overlay.onclick = function() {
                            modal.style.display = 'none';
                            overlay.remove();
                        };

                        const escHandler = function(e) {
                            if (e.key === 'Escape') {
                                modal.style.display = 'none';
                                document.getElementById('custom-modal-overlay')?.remove();
                                document.removeEventListener('keydown', escHandler);
                            }
                        };
                        document.addEventListener('keydown', escHandler);
                    }
                });
            });

            document.querySelectorAll('a').forEach(link => {
                if (!link.getAttribute('rel') || !link.getAttribute('rel').includes('modal:')) {
                    link.addEventListener('click', function(e) {
                        return true;
                    });
                }
            });
        });
    </script>

<?php require_once('../partials/footer.php'); ?>