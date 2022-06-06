<?php
/**
 * Description of add
 *
 * @var string Content of filter
 * @var string List of form
 */
?>
<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?= $filter_content; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <?= $tabs_content; ?>
                </div>
            </div>
        </div>
    </div>
</main>
