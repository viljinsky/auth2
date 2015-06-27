<?php
    session_start();
    include_once './db.php';
    
    $last_name =  filter_input(INPUT_POST, 'last_name');
    $first_name =  filter_input(INPUT_POST, 'first_name');
    $login =  filter_input(INPUT_POST, 'login');
    $email =  filter_input(INPUT_POST, 'email');
    $password1 =  filter_input(INPUT_POST, 'password1');
    $password2 =  filter_input(INPUT_POST, 'password2');

    function validUserName($first_name,$last_name){
        $p = '/[a-zA-Zа-яА-ЯёЁ]+/';
        return (preg_match($p,$first_name) && preg_match($p, $last_name));
    }
    
    function validLogin($login){
        return preg_match('/^[a-zA-Z0-9_]{3,25}$/', $login);
    }
    
    function userExists($login,$email){
        $query="select user_id from users where login='$login' or email='$email'";
        $result=  mysql_query($query);
        return mysql_num_rows($result)>0;
    }
    
    function validEmail($email){
        return preg_match('/\w[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-zA-Z]{2,3}/', $email);
    }
    
    function checkForm(){
        global $first_name,$last_name,$login,$password1,$password2,$email;
        
        try {
            $secret = filter_input(INPUT_POST,'secret');

            if (empty($last_name) 
                    || empty($first_name) 
                    || empty($login) 
                    || empty($password1) 
                    || empty($password2) 
                    || empty($email)
                    || empty($secret)){
                throw new Exception('Нужно заполнить  все поля');
            }
            
            if (!validLogin($login)){
                throw new Exception('Логин должен состоять из не мене 3-х букв латинского алфавиа цыфр и подчерка');
            }
            
            if (!validEmail($email)){
                throw new Exception('Неправильный email');
            }
            
            if ($password1<>$password1){
                throw new Exception('Пароли не совпадают');
            }
            
            if (!validUserName($first_name,$last_name)){
                throw new Exception('Имя и фамилия могут состоять только из букв');
            }

            if (userExists($login,$email)){
                throw new Exception( 'Такой логин или email уже существует.');
            }

            if ($secret<>$_SESSION['secret']){
                throw new Exception('Неверно указано число с картинки');
            }
        
        } catch (Exception $exc){
            return $exc->getMessage();
        }
        
        
    }

    function createUser(){
        global $topsecret,$last_name,$first_name,$login,$password1,$email;
        $pwd = md5($password1.$topsecret);
        $query="insert into users (last_name,first_name,login,pwd,email)
                values('$last_name','$first_name','$login','$pwd','$email')";
        $result = mysql_query($query);

        if (!empty($err)){
            return $err;
        }

        if (!$result || mysql_affected_rows()<1){
            return 'Ошибка при записи'.mysql_error();
        }
        
        $_SESSION['user_id'] =  mysql_insert_id();
        $_SESSION['user_name'] = $last_name.' '.$first_name;
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
    
?>
