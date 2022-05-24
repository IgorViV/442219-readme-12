<?php
/**
 * View Post for populal posts page
 *
 * @var array Post content
 */
?>
<article class="popular__post post post--<?= $post['type_alias']; ?>">
    <header class="post__header">
        <h2><a href="./post.php?id=<?= $post['posts_id'] ?>"><?= $post['title']; ?></a></h2>
    </header>
    <div class="post__main">
        <?= $post_content; ?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="img/<?= $post['avatar_url']; ?>" alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name"><?= $post['author']; ?></b>
                    <time class="post__time" datetime="<?= $post['created_at']; ?>"><?= $post['diff_time']; ?></time>
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
                    <span><?= $post['like_count']; ?></span>
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
