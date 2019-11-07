<?php 
session_start();
unset($_SESSION['session_username']);
session_destroy();
header("location: /includes/login.php");
?>
<script src="../lib/js/localforage.js"></script>
<script>
  $.ajax({
    type: 'GET',
    url: 'logout.php',
    success: function(response) {
      localforage.clear();
    },
    error: function() {

    }
  }
</script>