<?php
/**
 * View main page
 */
?>
<h1 class="visually-hidden">Главная страница сайта по созданию микроблога readme</h1>
<div class="page__main-wrapper page__main-wrapper--intro container">
    <section class="intro">
        <h2 class="visually-hidden">Наши преимущества</h2>
        <b class="intro__slogan">Блог, каким<br> он должен быть</b>
        <ul class="intro__advantages-list">
        <li class="intro__advantage intro__advantage--ease">
            <p class="intro__advantage-text">
            Есть все необходимое для&nbsp;простоты публикации
            </p>
        </li>
        <li class="intro__advantage intro__advantage--no-excess">
            <p class="intro__advantage-text">
            Нет ничего лишнего, отвлекающего от сути
            </p>
        </li>
        </ul>
    </section>
    <section class="authorization">
        <h2 class="visually-hidden">Авторизация</h2>
        <form class="authorization__form form" action="main" method="post">
            <div class="authorization__input-wrapper form__input-wrapper">
                <!-- form__input-section--error -->
                <div class="form__input-section <?= !empty($form_errors['email'][0]) ? 'form__input-section--error' : ''; ?>">
                    <input class="authorization__input authorization__input--email form__input" id="authorization-email" type="email" name="email" placeholder="Укажите эл.почту" value="<?= $form_data['email'] ?? ''; ?>">
                    <svg class="form__input-icon" width="19" height="18">
                        <use xlink:href="#icon-input-user"></use>
                    </svg>
                    <label class="visually-hidden" for="authorization-email">Электронная почта</label>
                </div>
                <span class="form__error-label form__error-label--login"><?= $form_errors['email'][0] ?? ''; ?></span>
            </div>

            <div class="authorization__input-wrapper form__input-wrapper">
                <!-- form__input-section--error -->
                <div class="form__input-section <?= !empty($form_errors['password'][0]) ? 'form__input-section--error' : ''; ?>">
                    <input class="authorization__input authorization__input--password form__input" id="authorization-password" type="password" name="password" placeholder="Укажите пароль" value="<?= $form_data['password'] ?? ''; ?>">
                    <svg class="form__input-icon" width="16" height="20">
                        <use xlink:href="#icon-input-password"></use>
                    </svg>
                    <label class="visually-hidden" for="authorization-password">Пароль</label>
                </div>
                <span class="form__error-label"><?= $form_errors['password'][0] ?? ''; ?></span>
            </div>
            <a class="authorization__recovery" href="#">Восстановить пароль</a> <!-- TODO To realize-->
            <button class="authorization__submit button button--main" type="submit">Войти</button>
        </form>
    </section>
</div>
