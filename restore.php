<?php
    session_start();
    include_once './db.php';
    unset($_SESSION['message']);
    $word = filter_input(INPUT_POST,'word');
    
    // Найти пользователя user_id по логину или паролю
    
    $query1 = "select user_id,login,first_name,last_name,email from users where login='$word' or email='$word'";
    $result = mysql_query($query1);
    if (mysql_num_rows($result)<1){
        $_SESSION['message']='Не найден пользователь или емайл';
    } else {
    
        $row = mysql_fetch_array($result);
        $user_id = $row['user_id'];
        $user_name = $row['first_name'].' '.$row['last_name'];
        $email = $row['email'];
        $login=$row['login'];

        // изменить пароль
        $newpassword = '123';
        $newpwd=md5($newpassword.$topsecret);
        $query2 = "update users set pwd='$newpwd' where user_id='$user_id'";
        mysql_query($query2);

        $msg = 'Пароль изменён  для пользователя '.$user_name.'Отправлен по адресу '.$email
                .'логин '.$login.' пароль'.$newpassword;

        $_SESSION['message'] = $msg;
    }
    header('Location: ./')
?>
