<?php
    session_start();
    include_once './db.php';
    
    $last_name =  filter_input(INPUT_POST, 'last_name');
    $first_name =  filter_input(INPUT_POST, 'first_name');
    $login =  filter_input(INPUT_POST, 'login');
    $email =  filter_input(INPUT_POST, 'email');
    $password1 =  filter_input(INPUT_POST, 'password1');
    $password2 =  filter_input(INPUT_POST, 'password2');

    function checkUserName(){
        global $first_name,$last_name;
        $p = '/^[a-zA-Zа-яА-ЯёЁ]+$/';
        if (!preg_match($p,$first_name)){
                return "Имя и фамилия могут состоять только из букв";
        }    
    }
    
    function checkLogin(){
        global $login;
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)){
            return 'Логин должен состоять только из букв латинского алфавиа цыфр и подчерка';
        }
        
    }
    
    function userExists(){
        global $login,$email;
        $query="select user_id from users where login='$login' or email='$email'";
        $result=  mysql_query($query);
        if (mysql_num_rows($result)>0){
            return 'Такой логин или email уже существует.';
        }
    }
    
    function checkPassword(){
        global $password1,$password2;
        if ($password1<>$password2){
            return 'Пароль на совпадает';
        }
        
    }
    
    function checkEmail(){
        global $email;
        if (!preg_match('/\w[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-zA-Z]{2,3}/', $email)){
            return 'Адрес неверный ->'.$email;
        };
    }
    
    function checkForm(){
        global $first_name,$last_name,$login,$password1,$password2,$email;
        
        if (filter_input(INPUT_POST,'secret')<>$_SESSION['secret']){
            return 'Неверно указано число с картинки';
        }
        
        if (empty($last_name) 
                || empty($first_name) 
                || empty($login) 
                || empty($password1) 
                || empty($password2) 
                || empty($email)){
            return 'Нужно заполнить  все поля';
        }
        
        $err = checkUserName();
        if (!empty($err)){
            return $err;
        }
        
        $err=  checkLogin();
        if (!empty($err)){
            return $err;
        }
        
        $err = checkEmail();
        if (!empty($err)){
            return $err;
        }
        
        $err = userExists();
        if (!empty($err)){
            return $err;
        }
        
        
    }

    function createUser(){
        global $last_name,$first_name,$login,$password1,$email;
        $pwd = md5($password1.'Vh1MTV100');
        $query="insert into users (last_name,first_name,login,pwd,email)"
                ."values('$last_name','$first_name','$login','$pwd','$email')";
        $result = mysql_query($query);

        if (!empty($err)){
            return $err;
        }


        if (!$result || mysql_affected_rows()<1){
            return 'Ошибка при записи'.mysql_error();
        }
    }
    
    unset($_SESSION['message']);
    $err = checkForm();
    if (empty($err)){
        $err=  createUser();
    };
    if (!empty($err)){
        $_SESSION['message']=$err;
    }
    header('Location: ./');
    
    

//    $err = createUser($last_name, $first_name, $login, $password1, $email);
//    if (!empty($err)){
//        $_SESSION['message']=$err;
//    } else {
//        unset($_SESSION['message']);
//    }
    
?>
