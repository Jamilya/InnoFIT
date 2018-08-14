<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>

<?php
session_start();
if(isset($_SESSION["login"])){
 echo "Your Log in Session has been set"; // show a message for the logged in user, for testing purposes
header("Location: index.html");
}
if(isset($_POST["username"])){
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $username=$_POST['username'];
    $password=$_POST['password'];

    $query = "SELECT * FROM 'users' WHERE username='$username' and password='$password';
    -- $result = mysqli_query($conn,$query) or die(connect_error());

    $numrows=mysqli_num_rows($query);
    if($numrows!=0)
    {
        while($row=mysqli_fetch_assoc($result))
        {
            $dbusername=$row['username'];
            $dbpassword=$row['password'];
        }
        if($username == $dbusername && $password == $dbpassword)
        {
            $_SESSION['login']=$username;
            /* Redirect browser */
            header("Location: index.html");
        }
        } else {
            $message =  'Invalid username or password!';
        }
    } else {
            $message = 'All fields are required!';
        }
}
?>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
</head>
<body>
    <div class="container mlogin">
            <div id="login">
	 <h1>LOGIN</h1>
	 <?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>
<form name="loginform" id="loginform" action="" method="POST">
    <p>
        <label for="user_login">Username<br />
        <input type="text" name="username" id="username" class="input" value="" size="20" /></label>
    </p>
    <p>
        <label for="user_pass">Password<br />
        <input type="password" name="password" id="password" class="input" value="" size="20" /></label>
    </p>
        <p class="submit">
        <input type="submit" name="login" class="button" value="Log In" />
    </p>
        <p class="regtext">No account yet? <a href="register.php" >Register Here</a>!</p>
</form>

    </div>

	 </div>
</body>
</html>
	
	
	