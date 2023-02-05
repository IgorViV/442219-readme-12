<?php
/**
 * Displays input block in form
 *
 * @var string $name_form Name form: registration
 * @var string $label Label: Электронная почта
 * @var string $id_input Id: registration-email
 * @var string $type_input Type: email
 * @var string $name_input Name: email
 * @var string $placeholder Placeholder: Укажите эл.почту
 * @var string $value_input Value input
 * @var bool $is_required Is required
 * @var string $block_errors Block errors
 * @var string $error_field Error input field
 */
?>
<div class="<?= $name_form; ?>__input-wrapper form__input-wrapper">
    <label class="registration__label form__label" for="<?= $id_input; ?>">
        <?= $label; ?>
        <?php if ($is_required): ?>
        <span class="form__input-required">*</span>
        <?php endif; ?>
    </label>
    <div class="form__input-section <?= !empty($error_field) ? 'form__input-section--error' : ''; ?>">
<!--    !empty($form_errors[$name_input]) ? 'form__input-section--error' : ''    -->
        <input class="<?= $name_form; ?>__input form__input" id="<?= $id_input; ?>" type="<?= $type_input; ?>"
               name="<?= $name_input; ?>" placeholder="<?= $placeholder; ?>" value="<?= $value_input ?? ''; ?>">
        <button class="form__error-button button" type="button">
            !<span class="visually-hidden">Информация об ошибке</span>
        </button>
        <!-- ERROR EMAIL -->
        <!-- TODO paste block-form-error-text.php -->
        <?= $block_errors ?? ''; ?>
        <!-- END ERROR EMAIL -->
    </div>
</div>
