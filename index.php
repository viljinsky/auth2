<!DOCTYPE html>
<?php session_start(); ?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Аутентификация</title>
    <style>
        body{margin: 0;}
        header,footer{background: #6699cc;padding: 10px;}
        article{background: #fff;margin: 30px auto;width:70%;padding: 20px;  box-shadow: 0 0 10px rgba(0,0,0,0.5);}
        nav a{text-decoration: none;color:#fff;}
        nav a:hover{text-decoration: underline;}
        
        
        
    .dialog_form{
        display: none;
        border: 1px solid black;
        background: #f0f0f0;
        position:fixed;
        width:400px;
        margin: 0 auto;
        padding:20px;
        z-index: 1002;
    }
        
    #message_form input{width:100%;}
    #message_form textArea{width:100%;}
    .message_form table input,.message_form table textarea {width:100%;}

    .fade_overlay {
        display: none;
        position: fixed;
        left: 0;top:0;width:100%;height: 100%;
        background: #000;
        opacity: 0.3;
        z-index: 1001;
    }
    .btn_close{
        display:block;
        position: absolute;
        right: 5px;
        top: 5px;
    }
    
    .btn_group{
        height:30px;
    }
    
    .btn_group .buttons {
        display: inline;position: absolute;right: 10px;bottom: 10px;        
    }

    </style>
    
    <script >
        function showForm(form_name){
            var form =  document.getElementById(form_name);
            form.style.display='block';
            var html = document.documentElement;
            var w = html.clientWidth;
            form.style.left=(w-form.clientWidth)/2+'px';
            var h = html.clientHeight;
            form.style.top=(h-form.clientHeight)/2+'px';
            document.getElementById('fade').style.display='block';
        }

        function hideForm(form_name){
            document.getElementById(form_name).style.display='none';
            document.getElementById('fade').style.display='none';
        }
        
        function setUserID(user_id){
            var f = document.getElementById('confirm_restore_form');
            f.user_id.value=user_id;
        }
        function checkLink(link){
            <?php if (isset($_SESSION['user_id'])) { ?>
                window.location.href = link;    
            <?php } else { ?>
                alert('Необходимо авторизоваться');
            <?php }?>
        }

    </script>
</head>
<body>
   
    <?php 
        include_once './db.php';
        
        if (isset($_SESSION['message'])){
            $info_message = $_SESSION['message'];
        }
        
        if (isset($_SESSION['error'])){    
            $error_message = $_SESSION['error'];
        }
        
        if (isset($_SESSION['message'])){
        $str='<form class="dialog_form" id="sysmessage">'
            .'<a href="#" class="btn_close" onclick="hideForm(\'sysmessage\');">Закрыть</a>'    
            .'<p>Ошибка</p>'
            .$_SESSION['message']
            .'</form>';
        echo $str;
        ?><script> showForm("sysmessage")</script><?php
    }
    ?>
    
    
    <header>

    
        <div style="height:30px;" >
            <nav style="position:absolute;right: 10px;">
            <?php
                if (isset($_SESSION['user_id'])){
                    echo 'Здравствуйте, '.$_SESSION['user_name'].' '.$_SESSION['user_id'];
                    ?> <a href="logout.php">Выход</a>   <?php
            }  else { ?>
                    <a href="#" onclick="showForm('login_form');">Вход</a>
                    <a href="#" onclick="showForm('register_form');">Регистрация</a>
             <?php } ?>


                <a href="#" onclick="showForm('message_form');">Сообщение</a>
            </nav>
        </div>    
        
        <h1>Аутентификации</h1>
        
        <nav>
            <a href="#">Главная</a>
            <a href="#" onclick="checkLink('http://www.yandex.ru');">Загрузить</a>
            <a href="#">Примеры</a>
        </nav>
    
    </header>
    
    <article>
        <section>
        <h1>Бла бла бла бла бла</h1>
        Бла бла бла бла бла бла бла бла бла бла бла бла бла
         бла бла бла бла бла бла бла бла
        </section>
        <section>
        <h1>Бла бла бла бла бла</h1>
        Бла бла бла бла бла бла бла бла бла бла бла бла бла
         бла бла бла бла бла бла бла бла
        </section>
        <section>
        <h1>Бла бла бла бла бла</h1>
        Бла бла бла бла бла бла бла бла бла бла бла бла бла
         бла бла бла бла бла бла бла бла
        </section>
    </article>

    <footer>
        &copy; 2015, Ильинский В.В.
    </footer>
    
    <!--            Вход в систему                                       -->

    <form class="dialog_form" id="login_form" method="post" action="login.php">
        <a class="btn_close" href="#" onclick="hideForm('login_form');">Закрыть</a>
        Вход:<br>
        <input type="text" name="login" placeholder="логин">
        <input type="password" name="password" placeholder="пароль"><br>

        <a href="#" onclick="hideForm('login_form'); showForm('restore_form');" >Напомнить пароль</a><br>
        <div class="btn_group">
            <div class="buttons">
                <input type="submit" value="войти">            
            </div>
        </div>    
    </form>

    <!--              Форма регистрации                                  -->

    <?php 
        $alpha ="0123456789";
        $secret = ""; 
        $old_user_id;
        for($i=0;$i<5;$i++) {
            $secret.= $alpha[rand(0,strlen($alpha)-1)]; 
        }
        session_id(md5(microtime()*rand())); 
        $_SESSION['secret']=$secret;
        

    ?>
    
                
    <form class = "dialog_form" id = "register_form" method = "post" action = "register.php">
        <a class="btn_close" href="#" onclick="hideForm('register_form');">Закрыть</a>
        <b>Регистрация:</b> <br>
        <table>
            <tr>
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
            </tr><tr>
                <td>Фамилия</td>
                <td><input type="text" name="last_name"></td>
            </tr><tr>
                <td>Имя</td>
                <td><input type="text" name="first_name"></td>
            </tr><tr>
                <td>Введите число</td><td>&nbsp;</td>
            </tr><tr>
                <td><img src="captcha.php?sid=<?= session_id(); ?>" alt="captcha"></td>
                <td><input type="text" name="secret"></td>
            </tr>
        </table>
        <div class="btn_group">
            <div class="buttons">
                <input type="submit" value="Зарегистрировать">            
            </div>
        </div>    
    </form>

    <!---      Форма отправки сообщения                                 -->

    <form class = "dialog_form" id = "message_form" action = "message.php" method="post">
        <a class="btn_close" href="#" onclick="hideForm('message_form');">Закрыть</a>
        <table  width="100%">
                <tr>
                        <td colspan="2">Тема</td>
                </tr><tr>
                    <td colspan="2"><input type="text" name="subject" 
                                           placeholder="Укажите тему (вопрос,пожелание, предложение и т.п.)">
                    </td>
                </tr><tr>
                    <td colspan="2">Текст сообщения</td>
                </tr><tr>
                    <td colspan="2"><textarea cols="50" rows="5" name="message" 
                                              placeholder="Кратко изложите суть сообщения"></textarea>
                    </td>
                </tr><tr>
                        <td>Ваше имя </td><td><input type="text" name="user_name"></td>
                </tr><tr>
                        <td>Эл.почта</td><td><input type="text" name="email"></td>
                </tr><tr>
                        <td colspan="2">&nbsp;</td>
                </tr><tr >
                    <td>Введите число</td>
                    <td>&nbsp;</td>
                </tr><tr>
                    <td><img src="captcha.php?sid=<?= session_id(); ?>"
                            alt="captcha">            </td>
                    <td><input type="text" name="secret"></td>
                </tr>
        </table>

        <div class="btn_group">
            <div class="buttons">
                <input type="submit" value="Отправить" >            
            </div>
        </div>    
    </form>
    
    <!-- Восстановление пароля -->
    
    <form class="dialog_form" id="restore_form" action="restore.php" method="post">
        <a class="btn_close" href="#" onclick="hideForm('restore_form');">Закрыть</a>
        <b>Восстановление входа </b>
        <p>
        <input type="text" name="word" placeholder="логин или email">
        </p>
        <div class="btn_group">
            <div class="buttons">
                <input type="submit" value="восстановить">
            </div>
        </div>
    </form>
    
    <!-- Подтверждение восстановления пароля -->
    <form class="dialog_form" id="confirm_restore_form" action="confirm_restore.php" method="post">
        <a class="btn_close" href="#" onclick="hideForm('confirm_restore_form')">Закрыть</a>
        <table>
           <tr> 
               <td>Ид пользователя</td><td><input type="text" name="user_id" ></td>
            </tr><tr>
                <td>Новый пароль</td><td><input type="text" name="password1"></td>
            </tr><tr>
                <td>Новый пароль(ещё раз)</td><td><input type="text" name="password2"></td>
            </tr>
        </table>
        <input type="submit" value="Изменить">
    </form>

    <div id="fade" class="fade_overlay"></div>
    
    <?php
        $old_user_id = filter_input(INPUT_GET,'user_id');
        $old_pwd = filter_input(INPUT_GET, 'pwd');
        if (!empty($old_user_id) && !empty($old_pwd)){
            $query = 'select user_id from users where user_id=\''.$old_user_id.'\' and pwd=\''.$old_pwd.'\'';
            $result = mysql_query($query);
            if (mysql_num_rows($result)==1){
                ?> <script>
                    showForm('confirm_restore_form');
                    setUserID(<?= $old_user_id; ?>)
                                    </script> 
                                    <?php
            }
        }
    ?>
    
</body>
</html>