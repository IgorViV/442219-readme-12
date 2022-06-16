<?php
/**
 * View page details of post by id
 *
 * @var array $post
 * @var string Typed site content (block template)
 * @var string Title post
 * @var int Number of likes
 * @var int Number of comments
 * @var int Number of repost
 * @var array Hashtags
 * @var string URL avatar current user for form new comments
 * @var string URL avatar of the author of the comment
 * @var string Name of the comment author
 * @var string Datatime of writing the comment
 * @var string Comment text
 * @var string URL avatar of the author current post
 * @var string Name of the current post author
 * @var string Datetime registration author of the current post
 * @var string Number of subscribers of the author current post
 * @var string Number of publications of the author current post
 */
?>

<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= !empty($post['title']) ? htmlspecialchars($post['title']) : ''; ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-photo">
                <div class="post-details__main-block post post--details">
                    <!-- Post type content -->
                    <?= $post_content; ?>
                    <!-- end type content -->
                    <!-- TODO width="760" height="507" for image -->
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <!-- TODO Number of likes -->
                                <span>250</span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?= count($comments); ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-repost"></use>
                                </svg>
                                <!-- TODO Number of repost -->
                                <span>5</span>
                                <span class="visually-hidden">количество репостов</span>
                            </a>
                        </div>
                        <span class="post__view">500 просмотров</span>
                    </div>
                    <ul class="post__tags">
                        <!-- TODO Hashtags -->
                        <li><a href="#">#nature</a></li>
                        <li><a href="#">#globe</a></li>
                        <li><a href="#">#photooftheday</a></li>
                        <li><a href="#">#canon</a></li>
                        <li><a href="#">#landscape</a></li>
                        <li><a href="#">#щикарныйвид</a></li>
                    </ul>
                    <div class="comments">
                        <form class="comments__form form" action="#" method="post">
                            <div class="comments__my-avatar">
                                <!-- TODO URL avatar current user for form new comments -->
                                <img class="comments__picture" src="../img/userpic-medium.jpg" alt="Аватар пользователя">
                            </div>
                            <div class="form__input-section form__input-section--error">
                                <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                <h3 class="form__error-title">Ошибка валидации</h3>
                                <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                </div>
                            </div>
                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                        <?php if(count($comments)): ?>
                            <ul class="comments__list">
                                <?php foreach($comments as $comment): ?>
                                <li class="comments__item user">
                                    <div class="comments__avatar">
                                        <a class="user__avatar-link" href="#">
                                            <!-- TODO URL avatar of the author of the comment -->
                                            <img class="comments__picture" src="../img/userpic-larisa.jpg" alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="comments__info">
                                        <div class="comments__name-wrapper">
                                            <a class="comments__user-name" href="#">
                                                <!-- TODO Name of the comment author -->
                                                <span>Лариса Роговая</span>
                                            </a>
                                            <!-- TODO Datatime of writing the comment -->
                                            <time class="comments__time" datetime="2019-03-20">1 ч назад</time>
                                        </div>
                                        <!-- TODO Comment text -->
                                        <p class="comments__text">
                                            <?= $comment['content']; ?>
                                        </p>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                                <?php if (count($comments) > MAX_COMM): ?>
                                <!-- TODO Link to all comments -->
                                <a class="comments__more-link" href="#">
                                    <span>Показать все комментарии</span>
                                    <sup class="comments__amount"><?= count($comments); ?></sup>
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="post-details__user user">
                    <div class="post-details__user-info user__info">
                        <div class="post-details__avatar user__avatar">
                            <a class="post-details__avatar-link user__avatar-link" href="#">
                                <!-- TODO URL avatar of the author current post -->
                                <img class="post-details__picture user__picture" src="../img/userpic-elvira.jpg" alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="post-details__name-wrapper user__name-wrapper">
                            <a class="post-details__name user__name" href="#">
                                <!-- TODO Name of the current post author -->
                                <span>Эльвира Хайпулинова</span>
                            </a>
                                <!-- TODO Datetime registration author of the current post -->
                            <time class="post-details__time user__time" datetime="2014-03-20">5 лет на сайте</time>
                        </div>
                    </div>
                    <div class="post-details__rating user__rating">
                        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                            <!-- TODO Number of subscribers of the author current post -->
                            <span class="post-details__rating-amount user__rating-amount">1856</span>
                            <span class="post-details__rating-text user__rating-text">подписчиков</span>
                        </p>
                        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                            <!-- TODO Number of publications of the author current post -->
                            <span class="post-details__rating-amount user__rating-amount">556</span>
                            <span class="post-details__rating-text user__rating-text">публикаций</span>
                        </p>
                    </div>
                    <div class="post-details__user-buttons user__buttons">
                        <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
                        <!-- TODO URL to write a email message of the author current post -->
                        <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
