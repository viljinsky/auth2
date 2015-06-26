<?php
    session_start();
    include_once './db.php';
    $login = filter_input(INPUT_POST,'login');
    $email = filter_input(INPUT_POST, 'email');
    
    // Найти пользователя user_id по логину или паролю
    
    $query = "select user_id,first_name,last_name,email from users where login='$login' or email='$email'";
    $query1 = $query;
    $result = mysql_query($query);
    if (mysql_num_rows($result)<1){
        $err='Не найден пользователь или емайл';
        $msg='Не найден пользователь или емайл';
        echo $err;
        exit();
    }
    
    $row = mysql_fetch_array($result);
    $user_id = $row['user_id'];
    $user_name = $row['first_name'].' '.$row['last_name'];
    $email = $row['email'];
    // изменить пароль
    $newpassword = '123';
    $newpwd=md5($newpassword.'Vh1MTV100');
    $query2 = "update users set pwd='$newpwd' where user_id='$user_id'";
    mysql_query($query2);
    
    $msg = 'Пароль изменён для пользователя '.$user_name.'Отправлен по адресу '.$email;
    
    $_SESSION['message'] = $msg;
    header('Location: ./')
?>
