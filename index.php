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
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
        <script src="lib/jquery/jquery-3.2.1.min.js"></script>
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
<!-- Execute jquery -->
<!-- <script src="./jquery/jquery.min.js"></script> -->

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header active">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand active" href="/index.php">Web tool home <span class="sr-only">(current)</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                    <!--  <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li > -->
            <li><a href="src/about.php">About this tool</a></li>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li ><a href="src/finalorder.php">Final Order Amount </a></li>
                    <li ><a href="src/deliveryplans.php">Delivery Plans </a></li>
                     <li><a href="src/forecasterror.php">Forecast Error</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Error Measures</li>                            
                    <li><a href="src/mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
                    <li> <a href="src/mse_graph.php">Mean Square Error (MSE)</a></li>
                    <li><a href="src/rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                    <li><a href="src/mpe.php">Mean Percentage Error (MPE) </a></li>
                    <li><a href="src/mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                    <li><a href="src/meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Matrices</li>
                    <li><a href="src/matrix.php">Delivery Plans Matrix</a></li>
                    <li><a href="src/matrixvariance.php">Delivery Plans Matrix - With Variance </a></li>
                            <!-- <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="./boxplot.php">Box Plot</a>
                            </li> -->
                </ul>
            </li>
          <!-- </ul> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="src/cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                </li>
        </ul>  
                <ul class="nav navbar-nav navbar-right">
                <li>
<!-- GTranslate: https://gtranslate.io/ -->
<a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl" style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png" height="12" width="12" alt="English" /></a><a href="#" onclick="doGTranslate('en|de');return false;" title="German" class="gflag nturl" style="background-position:-300px -100px;"><img src="//gtranslate.net/flags/blank.png" height="12" width="12" alt="German" /></a>

<style type="text/css">

a.gflag {vertical-align:middle;font-size:16px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/16.png);}
a.gflag img {border:0;}
a.gflag:hover {background-image:url(//gtranslate.net/flags/16a.png);}
#goog-gt-tt {display:none !important;}
.goog-te-banner-frame {display:none !important;}
.goog-te-menu-value:hover {text-decoration:none !important;}
body {top:0 !important;}
#google_translate_element2 {display:none!important;}

</style>

<div id="google_translate_element2"></div>
<script type="text/javascript">
function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
</script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


<script type="text/javascript">
/* <![CDATA[ */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
/* ]]> */
</script>
                </li>
                    <li><a href="/includes/logout.php">Logout</a></li>

            </ul>
        </div> <!--/.nav-collapse -->
    </div> <!--/.container-fluid -->
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
 

<br> <b> NOTE: Please upload the data in .csv format in the data structure described below
</b><br>

<br>Happy exploring!</p>
</div>
<span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Open scenarios</span>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">Scenario 1: Weekly visualization</a>
  <a href="#">Scenario 2: Monthly visualization</a>
  <!-- <a href="#">Scenario 3</a>   -->
</div>
<script src="http://d3js.org/d3.v4.min.js"></script>
<!-- <script src="https://cdn.rawgit.com/mozilla/localForage/master/dist/localforage.js"></script> -->
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
        
        var stringData = JSON.stringify (data);
        var newData = Number(data);
            console.log("data:", newData, stringData, data);

            let calcDeviation = function (orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
             } 
         let finalOrder = data.filter((el) => {
             console.log('element: ', el);
            //  return el.PeriodsBeforeDelivery==0;
            return el.PeriodsBeforeDelivery == "0";
            });
         console.log("final Orders:", finalOrder);

         let valueMap = new Map();

         finalOrder.forEach((val) => {
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
    $result = mysqli_query($conn, 'SELECT * from newOrders');    
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");


        

        while (($column = fgetcsv($file, 0, ",")) !== FALSE) {
            
            

            if ($i>0){
                $actualWeek = date("W", strtotime("$column[1]"));
                $forecastWeek = date("W", strtotime("$column[2]"));
                //$forecastWeek = "SELECT WEEK ($column[2])";
                $pbd = $forecastWeek - $actualWeek;
              //  $pbd = "SELECT WEEKOFYEAR ('$column[2]') - SELECT WEEKOFYEAR ('$column[1]')";
                $actualDay = date("d", strtotime("$column[1]"));
                $forecastDay = date("d", strtotime("$column[2]"));
                

           //$session_username = mysql_real_escape_string($_SESSION["session_username"]);
            $sqlInsert = "INSERT into newOrders (Product, ActualDate, ForecastDate, OrderAmount, ActualDay, ActualPeriod, ForecastDay, ForecastPeriod, PeriodsBeforeDelivery, username, Date )
            values ('$column[0]','$column[1]','$column[2]','$column[3]', $actualDay, $actualWeek, $forecastDay, $forecastWeek, $pbd, '{$_SESSION['session_username']}', NOW())";

            // $sqlInsert = "INSERT into `newOrders` (Product, ActualPeriod, ForecastPeriod, OrderAmount, PeriodsBeforeDelivery, username, Date)
            // values ('$column[0]','$column[1]','$column[2]','$column[3]', $pbd, SELECT WEEKOFYEAR ('$column[1]') AS 'ActualWeek', $pbd, SELECT WEEKOFYEAR ('$column[2]') AS 'ForecastWeek', '$pbd', '{$_SESSION['session_username']}',NOW())";
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
    

    <div class="outer-scontainer">
        You can remove all your data from the database by clicking on the button below.
    <div class="input-row">
    <form action="includes/delete.php" method="get" onsubmit="return confirm('Are you sure you want to remove all data?');">
    <input type="hidden" name="act" value="run">
    <input type="submit" value="Delete All Data">
    </form>
    <?php
    }
    ?>
</div>    </div>
<br><br>
<div style="background-color:lavender;padding-left:39px">
    <i><img src = "/data/ico/icon.png" alt = "Information Icon" height="15" width="15"><b> Instructions to upload data in CSV format:</i></b> <br>
    <u>Step 1:</u> Create a new Excel file and add the data, so that values of each column (Product, ActualDate, ForecastDate, OrderAmount) are in a separate column.
    <br> Please keep the date in the following format: <b>YYYY-MM-DD</b>.<br>
    <u>Step 2:</u> For MS Office in German, please add a new line in the beginning of the file: <b><br>sep=;<br></b>
    This will create a delimiter so that the file format can be used for both English and German-based MS Office documents.<br>
    <u>Step 3:</u> Save the file as "CSV (Comma delimited) (*.csv)"
    <br>
    An example of data in the suitable format:<br><br> <img src = "/data/img/newExampleData.jpg" alt = "Data Format Example" height="210" width="420"><br>
<br></div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>