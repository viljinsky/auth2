<?php
    session_start();
    include_once './db.php';
    
    $secret = filter_input(INPUT_POST, 'secret');
    if ($secret==$_SESSION['secret']){
    
        $user_name=  filter_input (INPUT_POST,'user_name');
        $subject=filter_input (INPUT_POST,'subject');
        $email=filter_input (INPUT_POST,'email');
        $message=filter_input (INPUT_POST,'message');
        $_SESSION['message']= 'Сообщение отпралено';
    } else {
        $_SESSION['message']= 'Неверно введено число';
    }
    header('Location: ./');
?>
