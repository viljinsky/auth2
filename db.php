<?php
    $db_host = 'localhost';
    $db_user ='root';
    $db_password='root';
    $database = 'test';

    $db = mysql_connect($db_host,$db_user,$db_password);
    if (!$db){
        echo 'Ошибка подключения'. mysql_error();
    }
    $link=  mysql_select_db($database);
    if(!$link){
        echo 'Ошибка базы данных'.  mysql_error();
    }
?>
