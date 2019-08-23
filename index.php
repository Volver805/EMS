<?php
    include 'connect.php';
    include 'views/header.php';
    include 'actions.php';
    include 'views/background.html';
    if($_SESSION['type'] == "teachers") {
        include 'views/teachers.php';
    }

    else if ($_SESSION['type'] == "students") {
        include 'views/students.php';
    }
    else {
    include 'views/login.php';
    }

    include 'views/footer.php'

?>