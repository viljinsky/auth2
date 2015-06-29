<?php
    session_start();
    include_once './db.php';
    unset($_SESSION['message']);
    $word = filter_input(INPUT_POST,'word');
    
    // Найти пользователя user_id по логину или паролю
    
    $query1 = "select user_id,pwd,login,first_name,last_name,email from users where login='$word' or email='$word'";
    $result = mysql_query($query1);
    if (mysql_num_rows($result)<1){
        $_SESSION['message']='Не найден пользователь или емайл';
    } else {
    
        $row = mysql_fetch_array($result);
        $pwd = $row['pwd'];
        $user_id = $row['user_id'];
        $user_name = $row['first_name'].' '.$row['last_name'];
        $email = $row['email'];
        $login=$row['login'];

        // изменить пароль
//        $newpassword = '123';
//        $newpwd=md5($newpassword.$topsecret);
//        $query2 = "update users set pwd='$newpwd' where user_id='$user_id'";
//        mysql_query($query2);

        $msg1 = 'На адрес '.$email.' выслано письмо с инструкцией. Проверьте почту'."n";
        $msg2 = 'Для изменения пароля перейдие по ссылке '.$db_host.'/auth2/?user_id='.$user_id.'&pwd='.$pwd;
        
        $_SESSION['message'] = $msg1."\n".$msg2;
    }
    header('Location: ./')
?>
