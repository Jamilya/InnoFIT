<?php
ob_start(); ?>
<?php
session_start();

// if(session_id() !== '' || !isset($_SESSION["session_username"])) {
    if(!isset($_SESSION["session_username"])) {
    header("Location:includes/login.php");
}
 
 ?>
<?php require_once("includes/connection.php"); ?>

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- <script src="lib/jquery/jquery-3.2.1.min.js"></script> -->
    <link rel="stylesheet" href="./src/css/index.css">
    
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

    <script src="./lib/js/localforage.js"></script>

    <script type="text/javascript">
    localforage.config({
        driver: localforage.WEBSQL, // Force WebSQL; same as using setDriver()
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });

    $(document).ready(function() {
        $("#frmCSVImport").on("submit", function() {

            $("#response").attr("class", "");
            $("#response").html("");
            var fileType = ".csv";
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
            if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
                $("#response").html("Chosen File is Invalid. Please Upload : <b>" + fileType +
                    "</b> Files.");
                return false;
            }
            return true;
        });
    });
    </script>
        <style>
    body {
        margin: 0 auto;
    }

    a.gflag {
        vertical-align: middle;
        font-size: 16px;
        padding: 1px 0;
        background-repeat: no-repeat;
        background-image: url(//gtranslate.net/flags/16.png);
    }

    a.gflag img {
        border: 0;
    }

    a.gflag:hover {
        background-image: url(//gtranslate.net/flags/16a.png);
    }

    #goog-gt-tt {
        display: none !important;
    }

    .goog-te-banner-frame {
        display: none !important;
    }

    .goog-te-menu-value:hover {
        text-decoration: none !important;
    }

    body {
        top: 0 !important;
    }

    #google_translate_element2 {
        display: none !important;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header active">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand active" href="/index.php">Home<span class="sr-only">(current)</span></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="src/configuration.php">Configuration</a></li>
                    <li><a href="src/about.php">About</a></li>
                    <li class><a href="src/howto.php">How to Interpret Error Measures </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="src/finalorder.php">Final Order Amount </a></li>
                            <li><a href="src/deliveryplans.php">Delivery Plans </a></li>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="src/cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <!-- GTranslate: https://gtranslate.io/ -->
                        <a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl"
                            style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="English" /></a><a href="#"
                            onclick="doGTranslate('en|de');return false;" title="German" class="gflag nturl"
                            style="background-position:-300px -100px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="German" /></a>

                        <div id="google_translate_element2"></div>
                        <script type="text/javascript">
                        function googleTranslateElementInit2() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                autoDisplay: false
                            }, 'google_translate_element2');
                        }
                        </script>
                        <script type="text/javascript"
                            src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
                        </script>


                        <script type="text/javascript">
                        /* <![CDATA[ */
                        eval(function(p, a, c, k, e, r) {
                            e = function(c) {
                                return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String
                                    .fromCharCode(c + 29) : c.toString(36))
                            };
                            if (!''.replace(/^/, String)) {
                                while (c--) r[e(c)] = k[c] || e(c);
                                k = [function(e) {
                                    return r[e]
                                }];
                                e = function() {
                                    return '\\w+'
                                };
                                c = 1
                            };
                            while (c--)
                                if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
                            return p
                        }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',
                            43, 43,
                            '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'
                            .split('|'), 0, {}))
                        /* ]]> */
                        </script>
                    </li>
                    <li><a href="/includes/logout.php">Logout</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>


    <div class="container">
        <div class="row">
            <!-- <div class="col-8">
                <h3></h3>
            </div> -->
            <div class="col-md-12 text-center">
                <img src="/data/img/logo2.png" alt="ForeQuVis Logo" height="110" width="370">
            </div>
        </div>
        <div class="row">
        <div class="col-md-12 text-center"><br><br><br>
                <h4><?php   echo "Dear ";
                    print_r($_SESSION["session_username"]);
                    echo ",";?></h4>

                <p> Welcome to the Forecast Quality Visualization (ForeQuVis / InnoFitVis) Web-tool.
                <b>Please upload the data in .csv format in the correct data structure</b></p>
                <p>For instructions please follow the<mark> Configuration page.</mark> Happy exploring!</p>
                <hr>
            </div>
        </div>
    </div>

    <br />

    <!-- |||||||||||||||||||||||||||||||||||||||||||||| SEPERATOR |||||||||||||||||||||||||||||||||||||||||||||||||| -->
    <!-- <span style="font-size:15px;cursor:pointer" onclick="openNav()">&#9776; Open scenarios</span>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Scenario 1: Weekly visualization</a>
        <a href="#">Scenario 2: Monthly visualization</a>
    </div>

    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "200px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script> -->

    <script>
    d3.json("/includes/getdata.php", function(error, data) {
        if (error) throw error;

        var stringData = JSON.stringify(data);
        var newData = Number(data);

        let calcDeviation = function(orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
        }
        let finalOrder = data.filter((el) => {
            //  return el.PeriodsBeforeDelivery==0;
            return el.PeriodsBeforeDelivery == "0";
        });

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
        });

        // Save the data in localforage
        localforage.setItem('all_data', JSON.stringify(data));
        localforage.setItem('viz_data', JSON.stringify(data));
        localforage.setItem('finalOrder', JSON.stringify(finalOrder));
        localforage.setItem('deviation', JSON.stringify(finalArray));
        console.log('SAVING: ', data, finalOrder, finalArray);

        // TODO: REMOVE LATER - will be replaced with localforage
        localStorage.setItem('finalOrder', JSON.stringify(finalOrder));
        localStorage.setItem('deviation', JSON.stringify(finalArray));
        localStorage.setItem('data', JSON.stringify(data));
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

                $actualDate = DateTime::createFromFormat("Y-m-d H:i:s", "$column[1]");
                $forecastDate = DateTime::createFromFormat("Y-m-d H:i:s", "$column[2]");
                $actualDate = date("Y-m-d H:i:s",strtotime('-20 minutes',strtotime("$column[1]")));
                $forecastDate = date("Y-m-d H:i:s",strtotime('-16 minute',strtotime("$column[2]")));
                $newactualDate = date("Y-m-d H:i:s",strtotime($actualDate));
                $newforecastDate = date("Y-m-d H:i:s",strtotime($forecastDate));
                $pbdSubtr = 52;
                $forecastYear = date("Y",strtotime($forecastDate));
                $actualYear = date("Y",strtotime($newactualDate));
                $actualWeek = date("W", strtotime($newactualDate));
                $forecastWeek = date("W", strtotime($forecastDate));

                if ($actualYear == $forecastYear){
                    $pbd = $forecastWeek - $actualWeek;
                } elseif  ($actualYear < $forecastYear){
                    $pbd = $pbdSubtr  + $forecastWeek - $actualWeek;
                }else {
                    $pbd = $forecastWeek + $actualWeek; //assume only one year behind
                }
                $actualDay = date("d", strtotime("$column[1]"));
                $forecastDay = date("d", strtotime("$column[2]"));                

           //$session_username = mysql_real_escape_string($_SESSION["session_username"]);
            $sqlInsert = "INSERT into `newOrders` (Product, ActualDate, ForecastDate, OrderAmount, ActualDay, ActualPeriod, ForecastDay, ForecastPeriod, ActualYear, ForecastYear, PeriodsBeforeDelivery, username, Date )
            values ('$column[0]', '$column[1]', '$column[2]','$column[3]', $actualDay, $actualWeek, $forecastDay, $forecastWeek, $actualYear, $forecastYear, $pbd, '{$_SESSION['session_username']}', NOW())";
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data"><br><br>
                <div class="input-row">
                    <label class="col-md-6 control-label">Choose CSV File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import" class="btn btn-primary">Import</button><br>
                    <!-- <button type="submit" id="submit" name="import" class="btn-submit btn-blue">Import</button> -->
                    <br />
                </div>
            </form>
        </div>
        

    <?php
      if (!empty($_GET['act'])) {
        //echo "to remove the data in my table"; 
    } else {
    ?>
    <br /><br>
    <br /><br> <br><br>
    <hr>
    <div class="col-md-12 text-center">
        <p>If you'd like to remove all your data from the database - please click on the button "Delete All Data" below. <br></p>
        <p> <mark> Please note that the action is irreversible.</mark></p>
            <form action="includes/delete.php" method="get"
                onsubmit="return confirm('Are you sure you want to remove all data?');">
                <input type="hidden" name="act" value="run">
                <input type="submit" value="Delete All Data">
            </form>
        </div>
        </div>
    </div>
    <?php } ?>

    <br><br>
    <!-- <div style="background-color:lavender;padding-left:39px">
        <i><img src="/data/ico/icon.png" alt="Information Icon" height="15" width="15"><b> Instructions to upload data
                in CSV format:</i></b> <br>
        <u>Step 1:</u> Create a new Excel file and add the data, so that values of each column (Product, ActualDate,
        ForecastDate, OrderAmount) are in a separate column.
        <br> Please keep the date in the following format: <b>YYYY-MM-DD</b>.<br>
        <u>Step 2:</u> For MS Office in German, please add a new line in the beginning of the file: <b><br>sep=;<br></b>
        This will create a delimiter so that the file format can be used for both English and German-based MS Office
        documents.<br>
        <u>Step 3:</u> Save the file as "CSV (Comma delimited) (*.csv)"
        <br>
        An example of data in the suitable format:<br><br> <img src="/data/img/newExampleData.jpg"
            alt="Data Format Example" height="210" width="420"><br>
        <br></div> -->
</body>

</html>