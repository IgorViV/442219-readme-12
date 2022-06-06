<?php
/**
 * Displays the fields of the photo addition form
 *
 * @var string Value input field
 * @var array Form validation errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url" placeholder="Введите ссылку" value="<?= $val_input; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error; ?>
        <!-- End error text -->
    </div>
</div>
