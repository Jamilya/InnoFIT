<?php

$DB_SERVER = "mysql5";
$DB_USERNAME = "jnurgazina";
$DB_PASSWORD = "fuSdebNbZDX+";
$DB_NAME = "db_jnurgazina_1";

// Create connection
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error() ); 
    }

?>