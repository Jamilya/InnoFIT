<?php ob_start();
?>
<?php
session_start(); ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'; ?>



<?php
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
         header ("Location: /index.php");
        } } else {
         $message =  "Invalid username or password!";
        }
    } else {
        $message = "All fields are required!";
    }
    } ?>



    <?php
    $profpic = "/data/img/background2.jpg";
    ?>
<html>
<head>

<style type="text/css">

body {
background-image: url('<?php echo $profpic;?>');
background-attachment: fixed; 

overflow: scroll;
}
div::after {
  content: "";
  opacity:0.5;
} 
.container {
  padding: 16px;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login page</title>
</head>
<body>
<script type="text/javascript">
    localStorage.clear();
</script>   
<div id="id01" class="modal" style="width:800px; margin:0 auto ">
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
        <p class="regtext">No account yet: <a href="./register.php" >Please register here</a></p>
</form>

    </div>

    </div>
</div>


</body>
</html>
	
<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>
	