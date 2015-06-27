<?php

session_start();
    include_once './db.php';
    
    $user_name=  filter_input (INPUT_POST,'user_name');
    $subject=filter_input (INPUT_POST,'subject');
    $email=filter_input (INPUT_POST,'email');
    $message=filter_input (INPUT_POST,'message');
    $secret = filter_input(INPUT_POST, 'secret');
    
    $to = 'timetabler@narod.ru';
    $message ='От '.$user_name.' сообщение : '.$message;
    $headers ='Content-type: text; charset="utf-8"'."\r\n"
                    .'From: '.$user_name.'<'.$email.'>';
    
    function checkEmail($email){
        return preg_match('/\w[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-zA-Z]{2,3}/', $email);
    }
    
    function checkUserName($user_name){
        return preg_match('/[a-zA-Zа-яА-ЯёЁ_]+/', $user_name);
    }


    try {
        
        if (empty($user_name) || !checkUserName($user_name)){
            throw new Exception('Не указано (Не верно указано) имя'.$user_name );
        }
        
        if (!checkEmail($email)){
            throw new Exception('Неверный адрес эл.почты',1);
        }
        
        if ($secret<>$_SESSION['secret']){
            throw new Exception('Неверно введено число');
        }        
        
//        if(!mail($to,$subject,$message,$headers)){
//            throw new Exception('Упс. Почту не удалось отправить');
//        }
        
        $_SESSION['message']='Соощение успешно оправлено';
        
    } catch (Exception $exc) {
        $_SESSION['message'] = $exc->getMessage();
    }
    header('Location: ./');


?>


