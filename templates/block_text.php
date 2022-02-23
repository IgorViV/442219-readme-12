<?php
/**
 * View Text post
 * @var string Text content
 */
?>
<p><?= htmlspecialchars(cut_text($content)); ?></p>
<?php if (strlen(cut_text($content)) !== strlen($content)): ?>
    <a class="post-text__more-link" href="#">Читать далее</a>
<?php endif; ?>