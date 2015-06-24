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
    
	<?php 
        
            $db_host = 'localhost';
            $db_user ='root';
            $db_password='root';
            $database = 'test';
            
            $db = mysql_connect($db_host,$db_user,$db_password);
            if (!$db){
                echo 'Ошибка подключения'. mysql_error();
            }
            $link=  mysql_select_db($database);
            if(!$link){
                echo 'Ошибка базы данных'.  mysql_error();
            }
            
            
            function createUser($last_name,$first_name,$login,$password,$email){
                $query="insert into users (last_name,first_name,login,pwd,email)"
                        ."values('$last_name','$first_name','$login','$password','$email')";
                $result = mysql_query($query);
                if (!$result || mysql_affected_rows()<1){
                    return 'Ошибка при записи'.mysql_error();
                }
            }
            
            function getUserName($login,$password){
                $query = "select user_id,first_name,last_name from users where login='$login' and pwd='$password'";
                $result=  mysql_query($query);
                if (!$result or mysql_num_rows($result)<>1){
                    return 'Пользователь не найден или неверный пароль';
                }
                $data = mysql_fetch_array($result);
                $first_name=$data['first_name'];
                $last_name=$data['last_name'];
                $user_id=$data['user_id'];
                $_SESSION['user_id']=$user_id;
                $_SESSION['user_name']=$first_name.' '.$last_name;
            }


            function checkLoginForm(){
                
            }
            
            function checkRegisterForm(){
                
            }
            
            function checkMessageForm(){
                
            }
            
            $login_form = filter_input(INPUT_POST, 'login_form');
            if (!empty($login_form)){
                $login = filter_input(INPUT_POST, 'login');
                $password = filter_input(INPUT_POST, 'password');
                $err = getUserName($login, $password);
                if (!empty($err)){
                    echo $err;
                }
            }
            
            $refister_form = filter_input(INPUT_POST, 'register_form');
            if (!empty($refister_form)){
                $last_name =  filter_input(INPUT_POST, 'last_name');
                $first_name =  filter_input(INPUT_POST, 'first_name');
                $login =  filter_input(INPUT_POST, 'login');
                $email =  filter_input(INPUT_POST, 'email');
                $password1 =  filter_input(INPUT_POST, 'password1');
                $password2 =  filter_input(INPUT_POST, 'password2');
                if (empty($last_name) || empty($first_name) || empty($login) || empty($password1) || empty($password2) || empty($email)){
                    echo 'Нужно заполнить  все поля';
                }
                $err = createUser($last_name, $first_name, $login, $password1, $email);
                if (!empty($err)){
                    echo $err;
                }
                
            }  
            
            $message_form =filter_input(INPUT_POST,'message_form');
            if (!empty($message_form)){
                $user_name=input_filter(INPUT_POST,'user_name');
                $subject=input_filter(INPUT_POST,'subject');
                $email=input_filter(INPUT_POST,'email');
                $message=input_filter(INPUT_POST,'message');
                
            }
            
            $exit_form = filter_input(INPUT_POST, 'exit');
            if (!empty($exit_form)){
                session_unset();
                header('Location: ./');
            }
            
        
        ?>
    
    
    
    
	<h1>Форма аутентификации</h1>
	
	<nav>
        <?php
            if (isset($_SESSION['user_id'])){
                $user_name=$_SESSION['user_name'];
                $str = "<form method='post'>$user_name<input type='submit' name='exit' value='выход'></form>";
                echo $str;
            } else { ?>
                 <a href="#" onclick="showLoginForm('login_form');">Войти</a>
                <a href="#" onclick="showLoginForm('register_form');">Регистрация</a>
            
         <?php } ?>
            
            
            <a href="#" onclick="showLoginForm('message_form');">Сообщение</a>
	</nav>
        
        <!--            Вход в систему                                       -->
        
        <form class="login_form" id="login_form" method="post">
            Вход:<br>
            <input type="text" name="login" placeholder="логин">
            <input type="password" name="password" placeholder="пароль"><br>
            
            <a href="#">Напомнить пароль</a><br>
            <div style="position:relative;height:40px">
                <div style="position:absolute;right: 0;bottom: 0;">
                <input type="submit" name="login_form" value="войти">
                </div>
            </div>
        </form>
	
        <!--              Форма регистрации                                  -->
        
	<form class="register_form" id="register_form" method="post">
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
                        <input type="submit" value="Зарегистрировать" name="register_form">
                        <input type="button" value="Закрыть" onclick="hideLoginForm('register_form');">
                </div>
            </div>
	</form>
	
	<!---      Форма отправки сообщения                                 -->
	
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
                            <input type="submit" value="Отпрваить" name="message_form">
                            <input type="button" value="Закрыть" onclick="hideLoginForm('message_form');">
                    </div>
            </div>
	</form>

	<div id="fade" class="fade_overlay"></div>
	
</body>
</html>