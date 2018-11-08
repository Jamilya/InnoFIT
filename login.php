   
<?php
//phpinfo();
session_start();
?>
<?php require_once("includes/connection.php"); ?>
<?php
print_r($_SESSION);
if(isset($_SESSION["session_username"])){
 echo "Your Log in Session has been set"; // show a message for the logged in user
//header("Location: index.php")
;}

if (isset($_POST['login'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query =mysqli_query($conn, "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'");

        $numrows=mysqli_num_rows($query);
        if($numrows!=0)
    
        {
        while($row=mysqli_fetch_assoc($query))
        {
        $dbusername=$row['username'];
        $dbpassword=$row['password'];
        }

        if($username == $dbusername && $password == $dbpassword)

        {
    
    
        $_SESSION['session_username']=$username;
    
        /* Redirect browser */
        header("Location: index.php");
        }
        } else {
    
     $message =  "Invalid username or password!";
        }
    
    } else {
        $message = "All fields are required!";
    }
    }
    ?>

    <div class="container mlogin">
            <div id="login">
    <h1>LOGIN</h1>
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
        <p class="regtext">No account yet: <a href="register.php" >Please register here</a></p>
</form>

    </div>

    </div>
	
	
	<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>
	