<?php 
session_start();
if(!isset($_SESSION["login"])) { //user is specified?
	header("location:login.php");
} else {
?>


<div id="welcome">	
	<h2>Welcome, <span><?php echo $_SESSION['login'];?>! </span></h2>
	<p><a href="logout.php">Logout</a> Here!</p>
</div>



<?php
}
?>
