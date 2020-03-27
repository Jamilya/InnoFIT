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
    html,
    body {
        padding: 0px;
        margin: 0px;
        background: #F8F8F8;
        font-family: 'Raleway', sans-serif;
        color: black;
        height: 100%;
    }

    .container {
        min-height: 350px;
        max-width: 450px;
        margin: 40px auto;
        background: #F8F8F8;
        border-radius: 2px;
        box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: hi 0.5s;
        -webkit-transform: translateZ(0px);

        * {
            box-sizing: border-box;
        }
    }

    .pages {
        flex: 1;
        white-space: nowrap;
        position: relative;
        transition: all 0.4s;
        display: flex;

    }
    }

    /* .tabs {
        max-height: 100px;
        height: 100px;
        display: flex;
        background: #FFF;

        .tab {
            flex: 1;
            color: #4f71a1;
            text-align: center;
            line-height: 50px;
            transition: all 0.2s;

            .text {
                font-size: 14px;
                transform: scale(1);
                transition: all 0.2s;
            }
        }
    } */

    input[type=submit] {
        color: #d5e7f7;
        font-size: 70%;
        position: static;
        padding: 10px;
        margin: 0px;
        height: 150%;
        /* background: url(overlay.png) repeat-x center #3a8bd6; */
        background-color: #d5e7f7;
        font-family: 'Raleway', sans-serif;
        border-bottom: 1px solid #3a8bd6;
        box-shadow: inset 0 1px 0 #3a8bd6;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #3a8bd6;
        color: #F8F8F8;
    }

    .center {
        text-align: center;
        border: 1px #3a8bd6;
    }
    .button {
        color: #636673;
        font: 2.4em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
        font-size: 90%;
        padding: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 1px;
    }

    @for $i from 0 through 1 {
        input[type=radio]:nth-of-type(#{$i + 1}):checked {
            ~.tabs .tab:nth-of-type(#{$i + 1}) {
                box-shadow: inset (6 * $i) + -3px 2px 5px rgba(0, 0, 0, 0.25);
                color: #3F4C7F;

                .text {
                    transform: scale(0.9);
                }
            }

            ~.pages {
                transform: translateX(-100% * $i);

                .page:nth-of-type(#{$i + 1}) {
                    .input {
                        opacity: 1;
                        transform: translateX(0%);
                        transition: all 0.5s;

                        @for $i from 1 through 5 {
                            &:nth-child(#{$i}) {
                                transition-delay: 0.2s*$i
                            }
                        }
                    }
                }
            }
        }
    }

    @keyframes hi {
        from {
            transform: translateY(50%) scale(0, 0);
            opacity: 0;
        }
    }

    input {

        background: #cce7ff;
        color: rgba(0, 0, 0, 0.5);
        height: 40px;
        line-height: 40px;
        width: 100%;
        border: none;
        border-radius: 4px;
        font-weight: 600;
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
                            <input type="text" name="username" id="username" class="input" value=""
                                placeholder="" /></label>
                    </p>
                    <p>
                        <label for="user_pass">Password<br />
                            <input type="password" name="password" id="password" class="input" value=""
                                placeholder="" /></label>
                    </p>
                    <p class="submit">
                        <input type="submit" name="login" class="button" value="Log In" />
                    </p>
                    <!-- <p class="regtext">No account yet: <a href="./register.php" >Please register here</a></p> -->
                </form>

            </div>

        </div>
    </div>


</body>

</html>
<div class="center">
    <?php if (!empty($message)) {echo "<p class=\"error\">" . "HINT: ". $message . "</p>";} ?>
</div>