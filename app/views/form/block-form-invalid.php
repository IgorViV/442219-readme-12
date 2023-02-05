<?php
/**
 * Displays main errors block
 *
 * @var array $form_errors Errors fields
 * @var array $labels Labels fields
 */
?>
<div class="form__invalid-block">
    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
    <ul class="form__invalid-list">
        <?php foreach($form_errors as $field => $message): ?>
            <li class="form__invalid-item">
                <?= $labels[$field] ?? ''; ?>. <?= implode(", ", $message); ?>.
            </li>
        <?php endforeach; ?>
    </ul>
</div>
