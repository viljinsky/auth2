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
    
//    echo $to.''.$subject.''.$message.''.$headers;
    
    if ($secret==$_SESSION['secret']){
        if (mail($to,$subject,$message,$headers)){
            $_SESSION['message']= 'Сообщение отпралено';
        } else {
            $_SESSION['message']='Уппс.Проблема с почтой.Сообщение не отправлено';
        }
    } else {
        $_SESSION['message']= 'Неверно введено число';
    }
    header('Location: ./');
?>


