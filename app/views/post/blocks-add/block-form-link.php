<?php
/**
 * Displays the fields of the link addition form
 *
 * @var string $post_data Value input field link
 * @var array $block_error HTML block error message
 * @var array $form_errors Form validation errors
 */
?>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="post-link">
        Ссылка <span class="form__input-required">*</span>
    </label>
    <div class="form__input-section <?= !empty($form_errors['link']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="post-link" type="text" name="link"
               placeholder="Введите ссылку" value="<?= !empty($post_data['link']) ? $post_data['link'] : ''; ?>">
        <button class="form__error-button button" type="button">!<span
                class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['link'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
