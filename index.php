<?php
ob_start(); ?>
<?php
// if(!isset($_SESSION["session_username"])){
//     header("Location: includes/login.php");
// }

if(session_id() == '' || !isset($_SESSION["session_username"])) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
 };
 ?>
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
        margin: 0px;
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

        .sidenav {
            height: 60%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 60px;
            left: 0;
            background-color: #143b85;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 21px;
            color: #cce4d7;
            display: block;
            transition: 0.3s
        }

        .sidenav a:hover, .offcanvas a:focus{
            color: #f1f1f1;
        }

        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 30px !important;
            margin-left: 50px;
        }

        @media screen and (max-height: 250px) {
        .sidenav {padding-top: 35px;}
        .sidenav a {font-size: 18px;}
        }
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
                                <a class="dropdown-item" href="src/forecasterror.php">Forecast Error</a>
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
                                <a class="dropdown-item" href="src/mpe.php">Mean Percentage Error (MPE)</a>
                            </li>                            
                            <li>
                                <a class="dropdown-item " href="src/mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="src/meanforecastbias.php">Mean Forecast Bias (MFB)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/cor_rmse.php">Corrected Root Mean Square Error (CRMSE)</a>
                            </li>
 
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li>
                                <a class="dropdown-item" href="src/matrix.php">Delivery Plans Matrix</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="src/matrixvariance.php">Delivery Plans Matrix - With Variance</a>
                            </li>
                            <!-- <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="src/boxplot.php">Box Plot</a>
                            </li> -->
                        </ul>
                        </div>
                <div class="nav-link dropdown">
                        <a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Corrections
                            <span class="caret"></span> </a>
                            <ul class="nav-link dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li>
                                <a class="dropdown-item " href="src/cor_rmse.php">Corrected Root Mean Square Error (CRMSE)</a>
                            </li>
                            </ul>
                </div>
                </ul>
                           
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="nav-link" href="includes/logout.php">Logout
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>

                </ul>
            </div>
    <!--/.nav-collapse -->

    </div>
    </nav>
    



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
 

<br> <b> NOTE: Please upload the data in .csv format in the data structure defined below
</b><br>

<br>Happy exploring!</p>
</div>
<span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Open scenarios</span>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">Scenario 1</a>
  <a href="#">Scenario 2</a>
  <a href="#">Scenario 3</a>  
</div>
<script src="http://d3js.org/d3.v4.min.js"></script>
<script src="https://cdn.rawgit.com/mozilla/localForage/master/dist/localforage.js"></script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
<script>
        
        d3.json("/includes/getdata.php", function (error, data) {
            if (error) throw error;
            //console.log(data);
            let calcDeviation = function (orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
             } 
             let filterValues = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
         });
         let finalOrder = data.filter((el) => { return el.PeriodsBeforeDelivery==0; });

         let valueMap = new Map();

         filterValues.forEach((val) => {
            let keyString = val.ActualPeriod;
            let valueString = val.OrderAmount;
            valueMap.set(keyString, valueString);
         });
             let finalArray = data.map((el) => {
            let deviation = calcDeviation(el, valueMap.get(el.ForecastPeriod));
            return {
               ActualPeriod: el.ActualPeriod,
               ForecastPeriod: el.ForecastPeriod,
               OrderAmount: el.OrderAmount,
               Product: el.Product,
               FinalOrder: valueMap.get(el.ForecastPeriod),
               PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
               Deviation: deviation.toFixed(2)
            };
         })

         localStorage.setItem('finalOrder', JSON.stringify(finalOrder));
         localStorage.setItem('deviation', JSON.stringify(finalArray));
         localStorage.setItem('data', JSON.stringify(data));

        //  localforage.config({
        //     driver      : localforage.WEBSQL, // Force WebSQL; same as using setDriver()
        //     name        : 'myApp',
        //     version     : 1.0,
        //     size        : 4980736, // Size of database, in bytes. WebSQL-only for now.
        //     storeName   : 'keyvaluepairs', // Should be alphanumeric, with underscores.
        //     description : 'some description'
        // });

        //  localforage.setItem ('deviation', finalArray, function(result){
        //      console.log(result);
        //  });

        //  localforage.setItem ('finalOrder', finalOrder).then(console.log);
        //     localforage.getItem('finalOrder', function (err, finalOrder) {
        //     });             
    
        
             
        //  localforage.getItem('deviation', function(err, val) { alert(finalArray) });

        //  localforage.setItem ('data', data, function(){     })

        });

</script>
<?php


if (isset($_POST["import"])) {
    
    $i=0; //the first row is skipped
    $fileName = $_FILES["file"]["tmp_name"];
    $result = mysqli_query($conn, 'SELECT * from orders');    
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        

        while (($column = fgetcsv($file, 0, ",")) !== FALSE) {
            

            if ($i>0){
                $pbd = $column[2] - $column[1];
           //$session_username = mysql_real_escape_string($_SESSION["session_username"]);
            $sqlInsert = "INSERT into orders (Product, ActualPeriod, ForecastPeriod, OrderAmount, PeriodsBeforeDelivery, username, Date)
            values ('$column[0]','$column[1]','$column[2]','$column[3]','$pbd','{$_SESSION['session_username']}',NOW())";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data was imported into the database";
                //echo "Import was successful";
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
                    <label class="col-md-4 control-label">Choose CSV File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                        <button type = "submit" id= "submit" name ="import" class="w3-button w3-light-blue">Import</button><br>
                    <!-- <button type="submit" id="submit" name="import" class="btn-submit btn-blue">Import</button> -->
                    <br />
                </div>
            </form>
        </div>
    </div>

    <?php
      if (!empty($_GET['act'])) {
        //echo "to remove the data in my table"; 
    } else {
    ?>
    <br/><br>
    <div style="padding-left:39px">
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script>
    d3.json("includes/getdata.php", function(error, data) {
    if (error) throw error;
    //console.log(data);

    });
    </script>





    <div class="outer-scontainer">
        You can remove all your order data from the database by clicking on the button below.
    <div class="input-row">
    <form action="includes/delete.php" method="get" onsubmit="return confirm('Are you sure you want to remove all data?');">
    <input type="hidden" name="act" value="run">
    <input type="submit" value="Delete All Data">
    </form>
    <?php
    }
    ?>
    </div>
</div>    </div>
<br><br>
<div style="background-color:lavender;padding-left:39px">
    <i><img src = "/data/ico/icon.png" alt = "Information Icon" height="15" width="15"><b> Instructions to upload data in CSV format:</i></b> <br>
    Step 1: Create a new Excel file and add the data, so that values of each column (Product, ActualPeriod, ForecastPeriod, OrderAmount) are in a separate column.
    <br> Please keep all numbers in <b>Integer</b> format.<br>
    Step 2: For MS Office in German, please add a new line in the beginning of the file: <b><br>sep=;<br></b>
    This will create a delimiter so that the file format can be used for both English and German-based MS Office documents.<br>
    Step 3: Save the file as "CSV (Comma delimited) (*.csv)"<br>
    Step 4: Close the file.<br>
    Step 5: Please open the newly-created CSV file. The data in the file should stay in the table/column structure. <br>
    An example of data in the suitable format:<br> <img src = "/data/img/example_2.jpg" alt = "Data Format Example" height="250" width="420"><br>
<br></div>


</body>

</html>