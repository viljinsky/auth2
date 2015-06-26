<?php
    session_start();
    include_once './db.php';
    
    
    function getUserName($login,$password){
        $pwd = md5($password.'Vh1MTV100');
        $query = "select user_id,first_name,last_name from users where login='$login' and pwd='$pwd'";
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
    
    
    $login = filter_input(INPUT_POST, 'login');
    $password = filter_input(INPUT_POST, 'password');
    $err = getUserName($login, $password);
    if (!empty($err)){
        $_SESSION['message']=$err;
    } else {
        unset($_SESSION['message']);
    }
     header('Location: ./');        

?>
