<!DOCTYPE html>
<html lang="ru">
<head>
	<style>
		.login_form {
			display:none;
			background:#f0f0f0;
			position:relative;
			width:400px;
			margin:0 auto;
			border:1px solid black;
			padding:20px;
			z-index:1002;
		}

	    .message_form {
			display:none;
			position:relative;margin:0 auto;max-width:500px;
			border:1px solid black;padding:10px;
			background:#f0f0f0;
			z-index:1002;
		}
		.message_form table input,.message_form table textarea {width:100%;}

		.fade_overlay {
			display: none;
			position: absolute;
			left: 0;top:0;width:100%;height: 100%;
			background: #000;
			opacity: 0.3;
			z-index: 1001;
		}
		
			
			
	</style>
	<script >
		function showLoginForm(){
			document.getElementById('login_form').style.display='block';
			document.getElementById('fade').style.display='block';
			
			
		}
		
		function hideLoginForm(){
			document.getElementById('login_form').style.display='none';
			document.getElementById('fade').style.display='none';
		
		}
		
		function showMessageForm(){
			document.getElementById('message_form').style.display='block';
			document.getElementById('fade').style.display='block';
		}
		
		function hideMessageForm(){
			document.getElementById('message_form').style.display='none';
			document.getElementById('fade').style.display='none';
		}
	</script>
</head>
<body>
	<h1>Форма аутентификации</h1>
	
	<nav>
		<a href="#" onclick="showLoginForm();">Зарегистрироваться</a>
		<a href="#" onclick="showMessageForm();">Написать</a>
	</nav>
	
	<form class="login_form" id="login_form" method="post">
		<table>
			<tr>
				<td>Фамилия</td>
				<td><input type="text" name="last_name"></td>
			</tr><tr>
				<td>Имя</td>
				<td><input type="text" name="first_name"></td>
			</tr><tr>
				<td>Логин</td>
				<td><input type="text" name="login"></td>
			</tr><tr>
				<td>E-mail</td>
				<td><input type="text" name="email"></td>
			</tr><tr>
				<td>Пароль</td>
				<td><input type="password" name="password1"></td>
			</tr><tr>
				<td>Пароль(ещё раз)</td>
				<td><input type="password" name="password2"></td>
			</tr>
		</table>
		<div style="position:relative;height:30px;">
		<div style="display:block;position:absolute;right:0;bottom:0;">
			<input type="submit" value="Зарегистрировать">
			<input type="button" value="Закрыть" onclick="hideLoginForm();">
		</div>
		</div>
	</form>
	
	<!---                              -->
	
		<form id="message_form" class="message_form">
		<table align="center" width="100%">
			<tr>
				<td colspan="2">Тема сообщения </td>
			</tr><tr>
				<td colspan="2"><input type="text" name="subject"></td>
			</tr><tr>
				<td>Текст сообщения</td>
			</tr><tr>
				<td colspan="2"><textarea cols="50" rows="12" ></textarea></td>
			</tr><tr>
				<td>Ваше имя </td><td><input type="text" name="user_name"></td>
			</tr><tr>
				<td>Эл.почта</td><td><input type="text" name="email"></td>
			</tr><tr>
				<td>&nbsp;</td><td><img source="captchu.png" alt="captchu"  height="30px"><td>
			</tr><tr>
				<td>Введите число</td><td><input type="text" name="captchu"></td>
			</tr>
		</table>
		<div style="position:relative;height:30px;">
			<div style="display:block; position:absolute;right:0;bottom:0;">
				<input type="submit" value="Отпрваить">
				<input type="button" value="Закрыть" onclick="hideMessageForm();">
			</div>
		</div>
	</form>

	<div id="fade" class="fade_overlay"></div>
	
	
</body>
</html>