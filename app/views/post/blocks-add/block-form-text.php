<?php
/**
 * Displays the fields of the text addition form
 *
 * @var string Value input field
 * @var array Form validation errors
 */
?>
<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($form_errors['text']) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="text" placeholder="Введите текст публикации">
        <?= !empty($post_data['text']) ? $post_data['text'] : ''; ?>
        </textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['text'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
