<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ru">
<head>
    <style>
    .login_form{
        display: none;
        border: 1px solid black;
        background: #f0f0f0;
        position:relative;
        width:400px;
        margin: 0 auto;
        padding:20px;
        z-index: 1002;
    }
    .register_form {
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
        function showLoginForm(form_name){
            document.getElementById(form_name).style.display='block';
            document.getElementById('fade').style.display='block';
        }

        function hideLoginForm(form_name){
            document.getElementById(form_name).style.display='none';
            document.getElementById('fade').style.display='none';
        }

    </script>
</head>
<body>
    
	<h1>Форма аутентификации</h1>
	
	<nav>
        <?php
            if (isset($_SESSION['user_id'])){
                $user_name=$_SESSION['user_name'];
                $str = "<form method='post' action='logout.php'>"
                      ."$user_name<input type='submit'  value='выход'>"
                      ."</form>";
                echo $str;
            } else { ?>
                <a href="#" onclick="showLoginForm('login_form');">Войти</a>
                <a href="#" onclick="showLoginForm('register_form');">Регистрация</a>
            
         <?php } ?>
            
            
            <a href="#" onclick="showLoginForm('message_form');">Сообщение</a>
	</nav>
        
        <!--            Вход в систему                                       -->
        
        <form class="login_form" id="login_form" method="post" action="login.php">
            Вход:<br>
            <input type="text" name="login" placeholder="логин">
            <input type="password" name="password" placeholder="пароль"><br>
            
            <a href="#">Напомнить пароль</a><br>
            <div style="position:relative;height:40px">
                <div style="position:absolute;right: 0;bottom: 0;">
                <input type="submit" value="войти">
                </div>
            </div>
        </form>
	
        <!--              Форма регистрации                                  -->
        
        <form class="register_form" id="register_form" method="post" action="register.php">
            Регисрация: <br>
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
                        <input type="button" value="Закрыть" onclick="hideLoginForm('register_form');">
                </div>
            </div>
	</form>
	
	<!---      Форма отправки сообщения                                 -->
	
        <form id="message_form" class="message_form" action="massage.php">
            <?php 
//                $alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; 
                $alpha ="0123456789";
                $secret = ""; 
                for($i=0;$i<5;$i++) {
                    $secret.= $alpha[rand(0,strlen($alpha)-1)]; 
                }
                session_id(md5(microtime()*rand())); 
                $_SESSION['secret']=$secret;
            
            ?>
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
                            <td colspan="2">&nbsp;</td>
                    </tr><tr >
                        <td  valign="top">Введите число<img src="captcha.php?sid=<?= session_id(); ?>"
                                alt="captcha" align="right"></td>
                        <td><input type="text" name="secret"></td>
                    </tr>
            </table>
            <div style="position:relative;height:30px;">
                    <div style="display:block; position:absolute;right:0;bottom:0;">
                            <input type="submit" value="Отпрваить" >
                            <input type="button" value="Закрыть" onclick="hideLoginForm('message_form');">
                    </div>
            </div>
	</form>

	<div id="fade" class="fade_overlay"></div>
	
</body>
</html>