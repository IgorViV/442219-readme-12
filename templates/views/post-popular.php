<?php
/**
 * View Post for populal posts page
 * @var array Post content
 */
?>
<article class="popular__post post post--<?=$post['type']; ?>">
    <header class="post__header">
        <h2><?=$post['title']; ?></h2>
    </header>
    <div class="post__main">
        <?= include_template('views/block-' . $post['type'] . '.php', [
            'content' => $post['content'],
        ]);?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="img/<?=$post['avatar']; ?>" alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name"><?=$post['name']; ?></b>
                    <time class="post__time" datetime="<?= $post['date']; ?>"><?= $post['diff_time']; ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-comment"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество комментариев</span>
                </a>
            </div>
        </div>
    </footer>
</article>
