<?php 
session_start();
unset($_SESSION['session_username']);
session_destroy();
header("location: /includes/login.php");
?>
<script>
  $.ajax({
    type: 'GET',
    url: 'logout.php',
    success: function(response) {
      localStorage.clear();
    },
    error: function() {

    }
  }
</script>