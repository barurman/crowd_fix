<? // Всплывающая форма логина/регистрации/восстановления пароля ?>
<form id="login" class="ajax-auth" action="login" method="post">
    <h3>New to site? <a id="pop_signup" href="">Create an Account</a></h3>
    <hr />
    <h1>Login</h1>
    <p class="status"></p>  
    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
    <label for="username">Username</label>
    <input id="username" type="text" class="required" name="username">
    <label for="password">Password</label>
    <input id="password" type="password" class="required" name="password">
    <a id="pop_forgot" class="text-link" href="<?php
echo wp_lostpassword_url(); ?>">Lost password?</a>
    <input class="submit_button" type="submit" value="LOGIN">
    <a class="close" href="">x</a>
</form>

<form id="register" class="ajax-auth"  action="register" method="post">
<!--	<h3>Already have an account? <a id="pop_login"  href="">Login</a></h3>-->
<!--    <hr />-->
    <h1>Регистрация</h1>
    <p class="status"></p>
    <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
    <label for="signonname">Логин</label>
    <input id="signonname" type="text" name="signonname" class="required">
    <label for="email">Email</label>
    <input id="email" type="text" class="required email" name="email">
    <label for="signonpassword">Пароль</label>
    <input id="signonpassword" type="password" class="required" name="signonpassword" >
    <label for="password2">Подтверждение пароля</label>
    <input type="password" id="password2" class="required" name="password2">
    <input class="submit_button" type="submit" value="Зарегестрироваться">
    <a class="close" href="">x</a>
</form>

<form id="forgot_password" class="ajax-auth" action="forgot_password" method="post">    
    <h1>Forgot Password</h1>
    <p class="status"></p>  
    <?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>  
    <label for="user_login">Username or E-mail</label>
    <input id="user_login" type="text" class="required" name="user_login">
     <input class="submit_button" type="submit" value="SUBMIT">
	<a class="close" href="">x</a>
</form>