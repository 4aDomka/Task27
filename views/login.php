<form method="POST">
	Логин <input name="login" type="text" required><br>
	Пароль <input name="password" type="password" required><br>
	<input type="hidden" name="token" value="<?php $token ?>"> <br />
	<input name="submit" type="submit" value="Войти">
</form>
<form method="POST" action=<?php echo $link = 'http://oauth.vk.com/authorize' . '?' . urldecode(http_build_query($VKparams)); ?>>
	<input type="hidden" name="token" value="<?php $token ?>"> <br />
	<input name="submit" type="submit" value="Войти через ВК">
</form>