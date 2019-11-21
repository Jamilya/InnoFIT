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
    <link rel="stylesheet" href="./src/css/index.css">

    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <!-- <script src="/lib/js/bootstrap.bundle.min.js"></script> -->
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

        localStorage.setItem('checkFiltersActive', false);
    });
    </script>
    <style>
    body {
        margin: 0 auto;
    }

    div {
        padding-right: 10px;
        padding-left: 10px;
    }

    #footer {
        background: #F8F8F8 !important;
    }

    #footer ul a {
        color: #b9b9b9;
    }

    #footer ul a:hover {
        color: #b9b9b9;
    }

    #footer ul {
        padding: 1px 0;
        -webkit-transition: .5s all ease;
        -moz-transition: .5s all ease;
        transition: .5s all ease;
    }

    #footer ul:hover {
        padding: 1px 0;
        margin-left: 5px;
        font-weight: 700;
    }

    .customContainer {
        padding: 0 3% 0 3%;
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
                <a class="navbar-brand" href="src/about.php">About<span class="sr-only"></span></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="src/configuration.php">Configuration</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="src/finalorder.php">Final Order Amount </a></li>
                            <li><a href="src/deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="src/matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="src/forecasterror.php">Percentage Error</a></li>
                            <li><a href="src/matrixvariance.php">Delivery Plans Matrix with Percentage Error </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Forecast Error Measures</li>
                            <li><a href="src/mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
                            <li> <a href="src/mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="src/rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="src/mpe.php">Mean Percentage Error (MPE) </a></li>
                            <li><a href="src/mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="src/meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                        </ul>
                    </li>
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
                    <li><a id="btnLogout" href="/includes/logout.php">Logout</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <div class="customContainer">
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="row align-items-center">
                        <div class="span4 align-center">
                            <div class="col-xs-8 col-sm-8">
                                <h1 class="text-right">Forecast Quality Visualization </h1>
                            </div>
                            <div class="col-xs-4 col-sm-4 ">
                                <img style="float:center" src="/data/img/Logo_transparent.png" alt="InnoFIT Logo"
                                    height="55" width="105">
                            </div>
                        </div>
                    </div><br />
                </div>
        </header>
        <!-- Page Content -->
        <section class="py-5">
            <div class="container text-center">
                <h4 class="font-weight-light"><?php   echo "Dear ";
                    print_r($_SESSION["session_username"]);
                    echo ",";?></h2>
                    <p>Welcome to the Forecast Quality Visualization tool - InnoFitVis.
                    </p>
                    <p> Happy exploring!</p>

            </div>
    </div>
    <hr>
    </section>

    <br />

    <script>
    d3.json("/includes/getdata.php", function(error, data) {
        if (error) throw error;
        console.log('Read Data: ', data);

        var stringData = JSON.stringify(data);
        var newData = Number(data);

        let calcDeviation = function(orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
        }
        let finalOrder = data.filter((el) => {
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
                $actualDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime("$column[1]")));
                $forecastDate = date("Y-m-d H:i:s",strtotime('-5 minutes',strtotime("$column[2]")));
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
                    $pbd = $forecastWeek - $actualWeek + $pbdSubtr * ($forecastYear - $actualYear);
                }
                
                $actualDay = date("d", strtotime("$column[1]"));
                $forecastDay = date("d", strtotime("$column[2]"));                

            $sqlInsert = "INSERT into `newOrders` (Product, ActualDate, ForecastDate, OrderAmount, ActualDay, ActualPeriod, ForecastDay, ForecastPeriod, ActualYear, ForecastYear, PeriodsBeforeDelivery, username, Date )
            values ('$column[0]', '$column[1]', '$column[2]','$column[3]', $actualDay, $actualWeek, $forecastDay, $forecastWeek, $actualYear, $forecastYear, $pbd, '{$_SESSION['session_username']}', NOW())";
            $result = mysqli_query($conn, $sqlInsert);
    
            if (! empty($result)) {
                $type = "success";
                $message = "Your data was successfully uploaded!";
            // <h4><i class="icon fa fa-check"></i>Data uploaded successfully!</h4>
            echo "<script type='text/javascript'>
            alert('$message');
            window.location.href = '/index.php';
            </script>";

    } else {
    printf( "Error: %s\n", mysqli_error( $conn ) );
    $type = "error";
    $message = "Problem in Importing CSV Data";
    $result='<div class="alert alert-danger">There was a problem while importing your data </div>';
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
                <h3>Upload your data here:</h3>
                <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport"
                    enctype="multipart/form-data">
                    <div class="input-row">
                        <label class="col-md-6 control-label">Choose CSV File</label> <input type="file" name="file"
                            id="file" accept=".csv">
                        <button type="submit" id="submit" name="import" class="btn btn-primary">Import</button>
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
                <p>If you'd like to remove all your data from the database - please click on the button "Delete All
                    Data" below. <br></p>
                <p> <mark> Please note that the action is irreversible.</mark></p>
                <form action="includes/delete.php" method="get"
                    onsubmit="return confirm('Are you sure you want to remove all data?');">
                    <input type="hidden" name="act" value="run">
                    <input type="submit" value="Delete All Data">
                </form>
            </div>
        </div>

        <hr>
        <?php } ?>

        <br><br>
        <div class="col-md-13">
            <h3>Data format:</h3>
            <p> Please upload your data in .csv format in the correct data structure.
                The correct data structure is shown in the table below. Set the dates (ActualDate and ForecastDate)
                format as: <b>YYYY-MM-DD
                    (year-month-day) and format as a date</b>. Please keep Order Amounts as <b>integers</b>.
                <!-- For MS Office in German language please add a new line in the beginning of the file: <b>sep=; </b>and
                save the file as .csv. -->
            </p>
            <!-- <u>Step 1:</u> Create a new Excel file and add the data, so that values of each column (Product, ActualDate,
        ForecastDate, OrderAmount) are in a separate column.
        <br> Please keep the date in the following format: <b>YYYY-MM-DD</b>.<br>
        <u>Step 2:</u> For MS Office in German, please add a new line in the beginning of the file: <b><br>sep=;<br></b>
        This will create a delimiter so that the file format can be used for both English and German-based MS Office
        documents.<br>
        <u>Step 3:</u> Save the file as "CSV (Comma delimited) (*.csv)" -->
            <br>
            <p>The format of the table headings and structure:<br><br> <img src="/data/img/newExampleData.jpg"
                    alt="Data Format Example" align="middle" height="185" width="420"><br></p>
            <br>
        </div>
        <div class="col-md-13">
            <h3>How to interpret error measures</h3>
            <p>The guidelines on how to interpret forecast error measures visualized in this tool can be found here (you
                will be redirected to another page):
                <a href="src/howto.php">How to Interpret Error Measures </a>
                <br /><br />
            </p>
        </div>
    </div>
    <section id="footer">
        <div class="container">
            <!-- Copyright -->
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center">
                <br>
                <p> Copyright © 2019 St. Pölten University of Applied Sciences <u>
                        <ul><a href="https://projekte.ffg.at/projekt/3042801">InnoFIT Research Project </a></ul>
                    </u></p>
            </div>
            <!-- Copyright -->
        </div>
    </section>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
</body>

</html>