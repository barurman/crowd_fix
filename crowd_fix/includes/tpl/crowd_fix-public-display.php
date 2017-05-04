<?php

/**
 * Шаблон ajax авторизации/регистрации пользователя
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://devdigital.pro
 * @since      1.0.0
 *
 * @package    Crowd_fix
 * @subpackage Crowd_fix/public/partials
 */
get_header();
?>
<div class="container">
    <div class="wpneo-wrapper">

        <div class="wpneo-tabs">
            <ul class="wpneo-tabs-menu">
                <li class="description_tab wpneo-current">
                    <a href="#wpneo-tab-description">Вход</a>
                </li>
                <li class="reviews_tab">
                    <a href="#wpneo-tab-reviews">Регистрация</a>
                </li>
            </ul>
            <div class="wpneo-tab">
                <!--  tab 1  -->
                <div id="wpneo-tab-description" class="wpneo-tab-content" style="display: block;">
                    <form id="login" class="ajax-auth" action="login" method="post">
                        <h2>Вход</h2>
                        <p class="status"></p>
                        <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                        <label for="username">Логин</label>
                        <input id="username" type="text" class="required" name="username">
                        <label for="password">Пароль</label>
                        <input id="password" type="password" class="required" name="password">
                        <a class="text-link" href="<?php
                        echo wp_lostpassword_url(); ?>">Забыли пароль?</a>
                        <input class="submit_button" type="submit" value="Войти">

                    </form>
                </div>
                <!--  tab 2  -->
                <div id="wpneo-tab-reviews" class="wpneo-tab-content" style="display: none;">
                    <form id="register" class="ajax-auth" action="register" method="post">
                        
                        <h2>Регистрация</h2>
                        <p class="status"></p>
                        <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
                        <label for="signonname">Логин</label>
                        <input id="signonname" type="text" name="signonname" class="required">
                        <label for="email">Email</label>
                        <input id="email" type="text" class="required email" name="email">
                        <label for="signonpassword">Пароль</label>
                        <input id="signonpassword" type="password" class="required" name="signonpassword">
                        <label for="password2">Пароль еще раз</label>
                        <input type="password" id="password2" class="required" name="password2">
                        <input class="submit_button" type="submit" value="Зарегестрироваться">

                    </form>
                </div>
            </div>
            <div class="clear-float"></div>
        </div>

    </div>
</div>


<div class="container">


</div>
<?php get_footer(); ?>