<?php
    session_start();
    include_once './db.php';
    $p_login = filter_input(INPUT_POST,'login');
    $p_email = filter_input(INPUT_POST, 'email');
    
    // Найти пользователя user_id по логину или паролю
    
    $query1 = "select user_id,login,first_name,last_name,email from users where login='$p_login' or email='$p_email'";
    $result = mysql_query($query1);
    if (mysql_num_rows($result)<1){
        $msg='Не найден пользователь или емайл';
        echo $err;
        exit();
    }
    
    $row = mysql_fetch_array($result);
    $user_id = $row['user_id'];
    $user_name = $row['first_name'].' '.$row['last_name'];
    $email = $row['email'];
    $login=$row['login'];
    
    // изменить пароль
    $newpassword = '123';
    $newpwd=md5($newpassword.'Vh1MTV100');
    $query2 = "update users set pwd='$newpwd' where user_id='$user_id'";
    mysql_query($query2);
    
    $msg = 'Пароль изменён  для пользователя '.$user_name.'Отправлен по адресу '.$email
            .'логин '.$login.' пароль'.$newpassword;
    
    $_SESSION['message'] = $msg;
    header('Location: ./')
?>
