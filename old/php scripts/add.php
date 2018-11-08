<?php
    session_start();
    if($_SESSION['user']){
    }
    else{ 
       header("location:index.php");
    }

    $details = mysql_real_escape_string($_POST['details']);
    $time = strftime("%X"); //time
    $date = strftime("%B %d, %Y"); //date

    Print "$time - $date - $details";
?>