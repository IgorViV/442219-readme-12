<?php
/**
 * Displays the fields of the photo addition form
 *
 * @var string $post_data Value input field photo-url
 * @var string $block_error HTML block error message
 * @var array $form_errors Form validation errors
 */
?>
<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?= !empty($form_errors['photo-url']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url" placeholder="Введите ссылку" value="<?= !empty($post_data['photo-url']) ? $post_data['photo-url'] : ''; ?>">
        <button class="form__error-button button" type="button">
            !<span class="visually-hidden">Информация об ошибке</span>
        </button>
        <!-- Error text -->
        <?= $block_error['photo-url'] ?? ''; ?>
        <!-- End error text -->
    </div>
</div>
