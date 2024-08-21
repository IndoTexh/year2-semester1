<?php
   $server = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'btbase';


   try{
    $connect = mysqli_connect($server, $user, $password, $database);
   }
   catch(mysqli_sql_exception){
       echo "Could not connected";
   }
   
?>