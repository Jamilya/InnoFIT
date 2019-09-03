<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>

<?php
    $DB_USERNAME = "jnurgazina"; 
    $DB_PASSWORD = "fuSdebNbZDX+";   
    $DB_SERVER = "mysql5";
    $DB_NAME="db_jnurgazina_1";
    
    $server = mysql_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD);
    $connection = mysql_select_db($DB_NAME, $server);
    
    //$username = $_SESSION[`session_username`];

    $myquery = "SELECT  Product, ActualDate, ForecastDate, OrderAmount, ActualDay, ActualPeriod, ForecastDay, ForecastPeriod, ActualYear, ForecastYear, PeriodsBeforeDelivery 
    FROM newOrders WHERE username = '" . $_SESSION['session_username'] . "'";
    $query = mysql_query($myquery);
    
    if ( ! $query ) {
        echo mysql_error();
        die;
    }
    
    $data = array();
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
    }
    
    echo json_encode($data);     
     
    mysql_close($server);
?>