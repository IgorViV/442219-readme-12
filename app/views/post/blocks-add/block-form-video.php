<?php
/**
 * Displays the fields of the video addition form
 *
 * @var string Value input field
 * @var array Form validation errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($form_errors['video-url']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-url" placeholder="Введите ссылку" value="<?= !empty($post_data['video-url']) ? $post_data['video-url'] : ''; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['video-url'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
