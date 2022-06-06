<?php
/**
 * View Quote post
 *
 * @var string Text content
 */
?>
<blockquote>
    <p>
        <?= htmlspecialchars($post['text_content']); ?>
    </p>
    <cite><?= htmlspecialchars($post['author_quote']); ?></cite>
</blockquote>
