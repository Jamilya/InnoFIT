<?php
    session_start(); //starts the session
    if($_SESSION['user']){ //checks if user is logged in
    }
    else {
       header("location:index.php"); //redirects if user is not logged in.
    }

    if($_SERVER['REQUEST_METHOD'] == "GET")
    {
       mysql_connect("localhost", "root", "") or die(mysql_error()); //connect to server
       mysql_select_db("db_nurgazina_1") or die("cannot connect to database"); //Connect to database
       $id = $_GET['id'];
       mysql_query("DELETE FROM list WHERE id='$id'");
       header("location:home.php");
    }
?>