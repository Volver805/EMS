<?php
    session_start();
        $servicename = 'localhost';
        $username = 'root';
        $password = '';
        $db = "ems";
        $conn = mysqli_connect($serviceName, $username, $password,$db);
        if($conn->connect_error) {
            die("Connection Failed...");
        }      
   
?>