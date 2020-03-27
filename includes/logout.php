<?php session_start(); ?>

<script src="../lib/js/localforage.js"></script>
</script>
<script>
    localforage.clear();
    location.replace("/includes/login.php");
</script>

<?php 
unset($_SESSION['session_username']);
session_destroy();
// header("location: /includes/login.php");
?>