<?php
/**
 * Displays the general part of the form tabs
 *
 * @var string Content form
 * @var string Type of form
 * @var bool Tab is selected
 * @var array Form validation errors
 */
?>
<section class="adding-post__photo tabs__content <?php if($is_selected): ?>tabs__content--active <?php endif; ?>">
    <h2 class="visually-hidden">Форма добавления <?= lcfirst($type['title']); ?></h2>
    <form class="adding-post__form form" action="add" method="post" enctype="multipart/form-data">
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                    <!-- TODO Add: form__input-section--error -->
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="photo-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= $val_input; ?>">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <!-- Error text -->
                        <?= $block_error; ?>
                        <!-- End error text -->
                        <input class="adding-post__input form__input visually-hidden" type="text" name="type-post" value="<?= $type_id; ?>">
                    </div>
                </div>
                <!-- Block type form -->
                <?= $form_content; ?>
                <!-- End block type form -->
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                    <div class="form__input-section">
                        <input class="adding-post__input form__input" id="photo-tags" type="text" name="tags" placeholder="Введите теги" value="<?= $val_input; ?>">
                        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                        <!-- Error text -->
                        <?= $block_error; ?>
                        <!-- End error text -->
                    </div>
                </div>
            </div>
            <?php if(count($form_errors)): ?>
            <div class="form__invalid-block">
                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                    <?php foreach($form_errors as $field => $message): ?>
                    <li class="form__invalid-item">
                        <?= $labels[$field]; ?>. <?= implode(", ", $message); ?>.
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <!-- Block input file -->
        <?= $form_file; ?>
        <!-- End block input file -->
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <!-- TODO URL return -->
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </form>
</section>