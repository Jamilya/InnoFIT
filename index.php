<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>
<?php 
require_once("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="data/ico/innofit.ico">
    <title>Forecast Quality Visualization</title>
    <link href="lib/css/bootstrap.min.css" rel="stylesheet">	
    
<style>


        body {
            min-height: 2000px;
            padding-top: 70px;
        }

         path {
            stroke: steelblue;
            stroke-width: 2;
            fill: none;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
        } 
/* .row {
    text-align: center;
    position: absolute;
    background-color: #adc8e6;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #adc8e6;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
color: black;
padding: 12px 16px;
text-decoration: none;
display: block;
text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
display: block;
} */
</style>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
<script type="text/javascript" src="lib/js/bootstrap.min.js"></script> 

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
<script type="text/javascript" src="js/bootstrap.min.js"></script>  -->

<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Chosen File is Invalid. Please Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>


</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand active" href="index.php">Web tool home</a>
            </div>
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">

                    <li>
                        <a class="nav-link" href="src/about.php">About this tool</a>
                    </li>
                    <div class="nav-link dropdown">
								<a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations
									<span class="caret"></span>
								</a>
                        <ul class=" dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li>
                                <a class="dropdown-item" href="src/finalorder.php">Final Order Amount</a>
                            </li>
                            <li>
                                <a class="dropdown-item"  href="src/deliveryplans.php">Delivery Plans</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/forecastbias.php">Forecast Bias Analysis</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/mad_graph.php">Mean Absolute Deviation (MAD)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/mse_graph.php">Mean Square Error (MSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/rmse_graph.php">Root Mean Square Error (RMSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="src/mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/customerorders.php">Customer Orders</a>
                            </li>

                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li>
                                <a class="dropdown-item" href="src/matrix.html">Delivery Plans Matrix</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/matrixvariance.html">Delivery Plans Matrix - With Variance</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="src/boxplot.html">Box Plot</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                </div>
                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a class = "nav-link" href="includes/logout.php">Logout
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
    </nav>
    <!--/.nav-collapse -->
    </div>
    </nav>
    

<!-- <span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Open scenarios</span>
<br><br> -->

<div style="padding-left:39px">
  <h3>Forecast Quality Visualization</h3>
  
  <?php
  echo "Dear ";
print_r($_SESSION["session_username"]);
echo ",";
//if(isset($_SESSION["session_username"])){
// echo "Your Log in Session has been set"; // show a message for the logged in user
//header("Location: index.php")
//;}
?>

 <br> Here you can find the overview of the Forecast Quality Visualization tool. 
 
<br>Final Order Amount, Delivery Plans, Forecast Bias Analysis, MAD, MSE, RMSE and MAPE graphs are already connected to a database.<br>
<br> <b> NOTE: Please upload the data in csv format in the following structure: <br>Product	 ActualPeriod	 ForecastPeriod	 OrderAmount	 PeriodsBeforeDelivery
</b><br>

<br>Happy exploring!</p>
</div>

<!-- <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">Scenario 1</a>
  <a href="#">Scenario 2</a>
  <a href="#">Scenario 3</a>
  
</div>
 -->
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
<?php


if (isset($_POST["import"])) {
    
    $i=0; //the first row is skipped
    $fileName = $_FILES["file"]["tmp_name"];
    $result = mysqli_query($conn, 'SELECT * from orders');    
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        

        while (($column = fgetcsv($file, 0, ",")) !== FALSE) {
           // echo '<pre>';
           // var_dump ($column[0]);
           // echo '</pre>';
            if ($i>0){
           //$session_username = mysql_real_escape_string($_SESSION["session_username"]);
            $sqlInsert = "INSERT into orders (Product, ActualPeriod, ForecastPeriod, OrderAmount, PeriodsBeforeDelivery, username, Date)
            values ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]','{$_SESSION['session_username']}',NOW())";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            //    echo "Import was successful";
            } else {
                printf( "Error: %s\n", mysqli_error( $conn ) );
                $type = "error";
                $message = "Problem in Importing CSV Data";
                echo "Import was unsuccessful";
            }
        }
        $i++;
        }
        
    }
   
}
?>
    <div class="outer-scontainer">
        <div class="row2">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data"><br>
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                        <button type = "submit" id= "submit" name ="import" class="w3-button w3-light-blue">Import</button><br>
                    <!-- <button type="submit" id="submit" name="import" class="btn-submit btn-blue">Import</button> -->
                    <br />

                </div>

            </form>

        </div>
      
    </div>

    <script src="lib/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="lib/jquery/jquery.min.js"><\/script>')</script>
    <script src="lib/js/bootstrap.min.js"></script>

</body>

</html>