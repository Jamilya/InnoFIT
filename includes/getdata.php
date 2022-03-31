<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>

<?php
    // phpinfo();
    
    $DB_USERNAME = "jnurgazina"; 
    $DB_PASSWORD = "fuSdebNbZDX+";   
    $DB_SERVER = "mysql5";
    $DB_NAME="db_jnurgazina_1";
    
    global $mysqli_connect, $server, $data, $connection, $query, $myquery;
    
    $server = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD);
    // $server = mysqli_connect("mysql5","jnurgazina","fuSdebNbZDX");
    $connection = mysqli_select_db($server, $DB_NAME);

    $myquery = "SELECT  Product, ActualDate, ForecastDate, OrderAmount, ActualDay, ActualPeriod, ForecastDay, ForecastPeriod, ActualYear, ForecastYear, PeriodsBeforeDelivery 
    FROM newOrders WHERE username = '" . $_SESSION['session_username'] . "'";
    $query = mysqli_query($server, $myquery);
    
    // if ( ! $query ) {
    //     echo mysqli_error($err);
    //     die;
    // }
    
    $data = array();
    
    for ($x = 0; $x < mysqli_num_rows($query); $x++) {
        $data[] = mysqli_fetch_assoc($query);
    }
    
    echo json_encode($data);     

?>