<?php
    session_start();
    include_once './db.php';
    
    function checkEmail($email){
        if (!preg_match('/\w[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-zA-Z]{2,3}/', $email)){
            return 'Адрес неверный';
        };
    }

    function createUser($last_name,$first_name,$login,$password,$email){
        $query="insert into users (last_name,first_name,login,pwd,email)"
                ."values('$last_name','$first_name','$login','$password','$email')";
        $result = mysql_query($query);
        $err = checkEmail($email);

        if (!empty($err)){
            return $err;
        }


        if (!$result || mysql_affected_rows()<1){
            return 'Ошибка при записи'.mysql_error();
        }
    }
    

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
        $_SESSION['message']=$err;
    } else {
        unset($_SESSION['message']);
    }
    header('Location: ./');
    
?>
