<?php
/**
 * Displays the fields of the link addition form
 *
 * @var string Value input field
 * @var array Form validation errors
 */
?>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
    <!-- TODO Add: form__input-section--error -->
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="post-link" type="text" name="link" placeholder="Введите ссылку" value="<?= $val_input; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error; ?>
        <!-- End error text -->
    </div>
</div>
