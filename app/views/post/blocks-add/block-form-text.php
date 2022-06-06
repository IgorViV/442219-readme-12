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
    <!-- TODO Add: form__input-section--error -->
    <div class="form__input-section">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="text" placeholder="Введите текст публикации" value="">
        </textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error; ?>
        <!-- End error text -->
    </div>
</div>
