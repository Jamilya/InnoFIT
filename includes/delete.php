<?php
ob_start(); ?>
<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>
<?php
$DB_SERVER = "mysql5";
$DB_USERNAME = "jnurgazina";
$DB_PASSWORD = "fuSdebNbZDX+";
$DB_NAME = "db_jnurgazina_1";

// Create connection
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt delete query execution
$sql = "DELETE FROM newOrders WHERE username='{$_SESSION['session_username']}' ";
if(mysqli_query($conn, $sql)){
    echo "Records were deleted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
  /* Redirect browser */
  header ("Location: /index.php");
  echo "Your records were deleted successfully.";
// Close connection
//mysqli_close($conn);
?>