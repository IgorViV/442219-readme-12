<?php
/**
 * View Text post
 * @var string Text content
 */
?>
<p style="padding: 0 20px 0 20px;"> <!-- TODO Add to css file -->
    <?= htmlspecialchars(cut_text($post['text_content'])['text']); ?>
</p>
<?php if (cut_text($post['text_content'])['is_long']): ?>
    <div class="post-text__more-link-wrapper">
        <a class="post-text__more-link" href="#">Читать далее</a>
    </div>
<?php endif; ?>
