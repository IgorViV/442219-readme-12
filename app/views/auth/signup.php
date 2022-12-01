<?php
/**
 * View registration page
 *
 * @var string $input_block Block input field
 * @var string $block_file Block input file
 * @var string $block_invalid Main block errors
 */
?>
<main class="page__main page__main--registration">
    <div class="container">
        <h1 class="page__title page__title--registration">Регистрация</h1>
    </div>
    <section class="registration container">
        <h2 class="visually-hidden">Форма регистрации</h2>
        <!-- FORM -->
        <form class="registration__form form" action="signup" method="post" enctype="multipart/form-data">
            <div class="form__text-inputs-wrapper">
                <div class="form__text-inputs">
                    <!-- INPUT BLOCK -->
                    <?= $input_block ?? ''; ?>
                    <!-- END INPUT BLOCK -->
                </div>
                <!-- MAIN BLOCK ERRORS -->
                <?= $block_invalid ?? ''; ?>
                <!-- END MAIN BLOCK ERRORS -->
            </div>
            <!-- FILE -->
            <?= $block_file ?? ''; ?>
            <!-- END FILE -->
            <button class="registration__submit button button--main" type="submit">
                Отправить
            </button>
        </form>
    </section>
</main>
