<?php
/**
 * View search page content
 */
?>
<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
                <span>Вы искали:</span>
                <span class="search__query-text"><?= !empty($search) ? $search : ''; ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <?php if (!empty($posts)): ?>
            <div class="container">
                <div class="search__content">
                    <!-- found posts -->
                    <?= $found_posts ?? ''; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (empty($posts)): ?>
                <div class="search__no-results container">
                    <p class="search__no-results-info">К сожалению, ничего не найдено.</p>
                    <p class="search__no-results-desc">
                        Попробуйте изменить поисковый запрос или просто зайти в раздел &laquo;Популярное&raquo;, там живет самый крутой контент.
                    </p>
                    <div class="search__links">
                        <a class="search__popular-link button button--main" href="/post">Популярное</a>
                        <a class="search__back-link" href="/post/search">Вернуться назад</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
