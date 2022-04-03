<?php
/**
 * View Photo post
 * @var string Url photo
 */
?>
<div class="post-photo__image-wrapper">
    <img src="img/<?= htmlspecialchars($post['img_url']); ?>" alt="Фото от пользователя" width="360" height="240">
</div>
