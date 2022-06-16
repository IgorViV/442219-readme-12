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
    <div class="form__input-section <?= !empty($form_errors['quote']) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="quote" placeholder="Текст цитаты">
        <?= !empty($post_data['quote']) ? $post_data['quote'] : ''; ?>
        </textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['quote'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($form_errors['quote-author']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" placeholder="Автор" value="<?= !empty($post_data['quote-author']) ? $post_data['quote-author'] : ''; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <!-- Error text -->
        <?= $block_error['quote-author'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
