<?php
/**
 * Description of block template
 *
 * @var array $type Post content types
 * @var bool $is_selected Tab is selected
 */
?>
<li class="adding-post__tabs-item filters__item">
    <a class="adding-post__tabs-link filters__button filters__button--<?= $type['alias']; ?>
        <?php if ($is_selected): ?>
            filters__button--active tabs__item tabs__item--active
        <?php endif; ?>
        button" href="?type=<?= $type['id']; ?>">
        <svg class="filters__icon" width="22" height="18">
            <use xlink:href="#icon-filter-photo"></use>
        </svg>
        <span><?= $type['title']; ?></span>
    </a>
</li>
