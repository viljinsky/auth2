<?php
   include_once './db.php'; 
   session_start();
   
   $user_id = filter_input(INPUT_POST, 'user_id');
   $password1 = filter_input(INPUT_POST, 'password1');
   $password2 = filter_input(INPUT_POST, 'password2');
   
   $query = "update users set pwd='".md5($password1.$topsecret)."' where user_id=".$user_id;
   mysql_query($query);
   
   $query1 ="select user_id,last_name,first_name from users where user_id=".$user_id;
   echo $query1;
   $result1 = mysql_query($query1);
   if (mysql_num_rows($result1)==1){
       $row=  mysql_fetch_array($result1);
       $_SESSION['user_id']=$row['user_id'];
       $_SESSION['user_name']=$row['last_name'].' '.$row['first_name'];
       header('Location: ./');
   }

?>
