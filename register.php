<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>

	<?php
if(isset($_POST["username"])){
    

 if(!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
	$full_name=$_POST['full_name'];
	$email=$_POST['email'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	
		
	$query=mysqli_query($conn, "SELECT * FROM users WHERE username='".$username."'");
	$numrows=mysqli_num_rows($query);
	
	if($numrows==0)
    { 
        
	$sql="INSERT INTO users
			(full_name, email, username, password) 
			VALUES ('".$_POST["full_name"]."','".$_POST["email"]."','".$_POST["username"]."','".$_POST["password"]."')";

if ($conn->query($sql) === TRUE) {
    echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
    } else {
    echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $conn->error."');</script>";
    }

  /*  else {
        $message = "All fields are required";
    } */         
    $conn->close();
}    
?>


<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>
	
<div class="container mregister">
			<div id="login">
	<h1>Register</h1>
<form name="registerform" id="registerform" action="register.php" method="post">
	<p>
		<label for="user_login">Full Name<br />
		<input type="text" name="full_name" id="full_name" class="input" size="32" value=""  /></label>
	</p>
	
	
	<p>
		<label for="user_pass">Email<br />
		<input type="email" name="email" id="email" class="input" value="" size="32" /></label>
	</p>
	
	<p>
		<label for="user_pass">Username<br />
		<input type="text" name="username" id="username" class="input" value="" size="20" /></label>
	</p>
	
	<p>
		<label for="user_pass">Password<br />
		<input type="password" name="password" id="password" class="input" value="" size="32" /></label>
	</p>	
	

		<p class="submit">
		<input type="submit" name="register" id="register" class="button" value="Register" />
	</p>
	
	<p class="regtext">Already have an account? <a href="login.php" >Login Here</a></p>
</form>
	
	</div>
	</div>
	
	
