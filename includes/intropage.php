<?php 
session_start();
if(!isset($_SESSION["session_username"])) {
//	header("location:index.php");
} else {
?>


<div id="welcome">	
	<h2>Welcome, <span><?php echo $_SESSION['session_username'];?>! </span></h2>
	<p><a href="/includes/logout.php">Logout</a> Here</p>
</div>



<?php
}
?>
