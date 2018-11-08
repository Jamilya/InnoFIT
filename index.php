
<?php
$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "db_jnurgazina_1";

// Create connection
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error()); 
	}
echo "Connected successfully <br>";

?>
<?php
session_start();
print_r($_SESSION["session_username"]);
echo "<p align='right'> <font color=blue  size='1ptx'><a href='logout.php' align='right' font color=blue  size='1ptx'>Log Out</a></font> </p>";
?>


<?php
if(isset($_SESSION["session_username"])){
 echo "Your Log in Session has been set"; // show a message for the logged in user
//header("Location: index.php")
;}

if (isset($_POST["import"])) {
    $i=0; //the first row is skipped
    $fileName = $_FILES["file"]["tmp_name"];
    $result = mysqli_query($conn, 'SELECT * from orders1');    
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        

        while (($column = fgetcsv($file, 0, ",")) !== FALSE) {
           // echo '<pre>';
           // var_dump ($column[0]);
           // echo '</pre>';
            if ($i>0){
            $sqlInsert = "INSERT into orders1 (Product, ActualWeek, ForecastWeek, OrderAmount, WeeksBeforeDelivery)
            values ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]')";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
              //  echo "Import was successful";
            } else {
                printf( "Error: %s\n", mysqli_error( $conn ) );
                $type = "error";
                $message = "Problem in Importing CSV Data";
               // echo "Import was unsuccessful";
            }
        }
        $i++;
        }
        
    }
   
}
?>
<!DOCTYPE html>
<html>
<head>
<!-- Execute jquery -->
<script src="./jquery/jquery.min.js"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-compatible" content="IE=edge">
<link rel="stylesheet" href="css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/main.css">


<!--  Bootstrap CSS  -->
<meta http-equiv="X-UA-compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<title>Forecast Quality Visualization Tool - Overview </title>		
    
<style>
body { font: 12px Arial;}
		path { 
			 stroke: rgb(52, 53, 54);
			 stroke-width: 1;
			 fill: none;
		}
		.axis path,
		.axis line {
			 fill: none;
			 stroke: grey;
			 stroke-width: 1;
			 shape-rendering: crispEdges;
		}
.outer-scontainer {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 20px;
	border-radius: 2px;
}

.input-row {
	margin-top: 0px;
	margin-bottom: 20px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	
	width: 100px;
	border-radius: 2px;
	cursor: pointer;
}

.outer-scontainer table {
	border-collapse: collapse;
	width: 100%;
}

.outer-scontainer th {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.outer-scontainer td {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}


li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
    background-color: lightblue;
}

li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
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
}
</style>

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
 
<div class="container">
<div class="row">
<section class="col-12">
<ul class="nav nav-tabs">
<li class="nav-item"><a class="nav-link active" href="index.php">Overview</a>
<li class="nav-item"><a class="nav-link" href="about.html">About This Tool</a>
<li class="nav-item">
<li class="nav dropdown"><a href="javascript:void(0)" class = "dropbtn"> Visualization</a>
<div class = "dropdown-content"> 
    <a href="finalorder.html">Final Order Amount</a>
    <a href="deliveryplans.html">Delivery Plans</a>
    <a href="forecastbias.html">Forecast Bias Analysis</a>
    <a href="mad_graph.html">Mean Absolute Deviation (MAD)</a>
    <a href="mse_graph.html">Mean Square Error (MSE)</a>
    <a href="rmse_graph.html">Root Mean Square Error (RMSE)</a>
    <a href="matrix.html">Delivery Plans Matrix</a>
    <a href="matrixvariance.html">Delivery Plans Matrix - With Variance</a>
    <a href="customerorders.html">Customer Orders</a>
<!-- <li class="nav-item"><a class="nav-link" href="finalorder.html">Final Order Amount</a>
<li class="nav-item"><a class="nav-link" href="deliveryplans.html">Delivery Plans</a>
<li class="nav-item"><a class="nav-link" href="forecastbias.html">Forecast Bias Analysis</a>
<li class="nav-item"> <a class="nav-link" href="mad_graph.html">Mean Absolute Deviation (MAD) graph</a>
<li class="nav-item"> <a class="nav-link" href="mse_graph.html">Mean Square Error (MSE)</a>
<li class="nav-item"> <a class="nav-link" href="rmse_graph.html">Root Mean Square Error (RMSE)</a>

<li class="nav-item"><a class="nav-link" href="matrix.html">Delivery Plans Matrix</a>
<li class="nav-item"><a class="nav-link" href="matrixvariance.html">Delivery Plans Matrix - With Variance</a>
<li class="nav-item"><a class="nav-link" href="customerorders.html">Customer Orders</a>
<li class="nav-item"><a class="nav-link" href="correlationmatrix.html">Correlation Matrix</a>
 -->

</ul></div></div>


<span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Open scenarios</span>
<br><br>

<div style="padding-left:39px">
  <h3>Forecast Quality Visualization</h3>
  <p>
  <?php echo "Hello " ;
  print_r($_SESSION["session_username"]); ?>
 <br> Here you can see your personalised Forecast Quality Visualization Tool Overview</p>
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">Scenario 1</a>
  <a href="#">Scenario 2</a>
  <a href="#">Scenario 3</a>
  
</div>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

        </div>
        <?php
            $sqlSelect = "SELECT * FROM orders1";
            $result = mysqli_query($conn, $sqlSelect);
            
            if (!$result || mysqli_num_rows($result) == 0) {
                return true
                ?>
            <table id='orders'>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Actual Week</th>
                    <th>Forecast Week</th>
                    <th>Order Amount</th>
                    <th>Weeks Before Delivery</th>
                    

                </tr>
            </thead>
<?php
                
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    
                <tbody>
                <tr>
                    <td><?php  echo $row['Product']; ?></td>
                    <td><?php  echo $row['ActualWeek']; ?></td>
                    <td><?php  echo $row['ForecastWeek']; ?></td>
                    <td><?php  echo $row['OrderAmount']; ?></td>
                    <td><?php  echo $row['WeeksBeforeDelivery']; ?></td>
                    
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } 
        
        return false; ?>
    </div>
<!-- Optional JavaScript, jQuery first, then Popper.js, then Bootstrap.js  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
 
    
               

</body>

</html>