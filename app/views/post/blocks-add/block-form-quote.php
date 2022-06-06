<?php
/**
 * Displays the fields of the quote addition form
 *
 * @var string Value input field
 * @var array Form validation errors
 */
?>
<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
    <!-- TODO Add: form__input-section--error -->
    <div class="form__input-section">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="quote" placeholder="Текст цитаты" value="">
        </textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error; ?>
        <!-- End error text -->
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <!-- TODO Add: form__input-section--error -->
    <div class="form__input-section">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" value="<?= $val_input; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error; ?>
        <!-- End error text -->
    </div>
</div>
