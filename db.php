<?php
    $db_host = 'localhost';
    $db_user ='root';
    $db_password='root';
    $database = 'test';
    $topsecret = 'Vh1MTV100';

    $db = mysql_connect($db_host,$db_user,$db_password);
    if (!$db){
        echo 'Ошибка подключения';
        exit();
    }
    $link=  mysql_select_db($database);
    if(!$link){
        echo 'Ошибка базы данных';
        exit();
    }
    
    function createUsresTable(){
        $query = "drop table if exists users;
          create table users(
	  user_id integer not null primary key auto_increment,
          login varchar(25) not null unique,
          email varchar(50) not null unique,
          pwd varchar(50) not null,
          last_name varchar(25),
          first_name varchar(25)
         );";
        if (mysql_query($query)){
            echo 'База успешно создана';
        } ;
    }
?>
