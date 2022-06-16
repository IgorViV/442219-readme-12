<?php
/**
 * Displays the fields of the file addition form
 */
?>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="file-photo">Файл изображения</label>
    <div class="form__input-section <?= !empty($form_errors['file-photo']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="file-photo" type="file" name="file-photo">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['file-photo'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
