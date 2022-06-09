<?php
/**
 * Displays the error in fields of the form
 *
 * @var array Form validation errors
 */
?>
<div class="form__error-text">
    <h3 class="form__error-title"><?= $title ?? 'Заголовок сообщения'; ?></h3>
    <?php if(isset($errors)): ?>
        <?php foreach($errors as $error): ?>
            <p class="form__error-desc"><?= $error; ?>.</p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
