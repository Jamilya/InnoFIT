<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/data/ico/innofit.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="../lib/js/localforage.js"></script>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="../lib/js/crossfilter.js"></script>
    <script src="../lib/js/dc.js"></script>
    <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script>
    <script>
    localforage.config({
        driver: localforage.WEBSQL, // Force WebSQL; same as using setDriver()
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a class="specialLine" href="./configuration.php">Configuration</a></li>
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Visualizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li class="active"><a href="./finalorder.php">Final Order Amount <span
                                        class="sr-only">(current)</span></a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix with Percentage Error </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Forecast Error Measures</li>
                            <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE) </a></li>
                            <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
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
                    <li><a id="btnLogout" href="/includes/logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            Logout</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

    <div class="customContainer">
        <!-- Page Features -->
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h2>Forecast Error Measures - Dashboard</h2>
                    <small>
                        <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
                </div>
                <p style="margin-top: 15px;">
                    On this page you find a overview about the available error measures this tool provides. Each error
                    measure has a dedicated page itself with a bigger view and
                    the possiblity to adjust some further elements or view specific items and compare them. This view is
                    mainly for a quick comparison and has only the main filters
                    applied from the <a href="./configuration.php"><strong>Configuration</strong></a> page.
                </p>
            </div>
        </div>

        <div class="row text-center" style="margin-top: 4%;">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter4">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mean Forecast Bias (MFB)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a
                                href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter5">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mean Percentage Error (MPE)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a href="./mpe.php">Mean
                                Percentage Error (MPE)</a>.</p>

                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center" style="margin-top: 4%;">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter2">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Root Mean Square Error (RMSE)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a
                                href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter6">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mean Square Error (MSE)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a
                                href="./mse_graph.php">Mean Square Error (MSE)</a>.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center" style="margin-top: 4%;">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter3">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mean Absolute Percentage Error (MAPE)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a href="./mape.php">Mean
                                Absolute Percentage Error (MAPE)</a>.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-img-top chartBox drop-shadow">
                        <div id="scatter">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mean Absolute Deviation (MAD)</h4>
                        <p class="card-text">To view the full graph please see the graph page: <a
                                href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>.</p>
                    </div>
                </div>
            </div>
        </div>


        <div id="footer" class="text-center" style="margin-top: 20px;">
            <!-- Copyright -->
            <br>
            <p> Copyright © 2020 St. Pölten University of Applied Sciences <u>
                    <ul><a href="https://projekte.ffg.at/projekt/3042801">InnoFIT Research Project </a></ul>
                </u></p>
            <!-- Copyright -->
        </div>


        <script>
        $(document).ready(function() {
            if (localStorage.getItem('checkFiltersActive') === 'true') {
                $('#filterInfo').show();
            } else {
                $('#filterInfo').hide();
            }
        });
        // const margin = {
        //     top: 5,
        //     right: 5,
        //     bottom: 5,
        //     left: 5
        // };

        localforage.getItem("viz_data", function(error, data) {
            data = JSON.parse(data);

            var RMSEchart = dc.scatterPlot("#scatter2"),
                MAPEchart = dc.scatterPlot("#scatter3"),
                MFBchart = dc.scatterPlot("#scatter4"),
                MPEchart = dc.scatterPlot("#scatter5"),
                MSEchart = dc.scatterPlot("#scatter6"),
                MADchart = dc.scatterPlot("#scatter");

            let width = 520;

            // Define function of absolute difference of forecast and final orders (needed for MAD graph)
            let absDiff = function(orignalEl, finalOrder) {
                return Math.abs(orignalEl.OrderAmount - finalOrder);
            }

            // Define function of power of difference of forecast and final orders (needed for RMSE graph)
            let powerDiff = function(orignalEl, finalOrder) {
                return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
            }
            // Define final orders: PBD = 0 means Final Orders
            let finalOrder = data.filter((el) => {
                return el.PeriodsBeforeDelivery == 0;
            });
            // Define forecast orders (which are not final orders)
            let uniqueArray = data.filter(function(obj) {
                return finalOrder.indexOf(obj) == -1;
            });
            // Define valid final orders (for MAPE calculation)
            let finalOrdersForecastPeriods = new Map();
            finalOrder.map(e => {
                finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
            });
            //Order All data by PBD (for MAPE calculation)
            // Order the Final Orders
            let dataByPBD = d3.nest()
                .key(function(d) {
                    return d.ActualPeriod;
                })
                .entries(data);

            //Find the max number of Actual periods in Final orders array -- Needed for MAPE calculation
            let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function(o) {
                return o.ActualPeriod;
            }))

            // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders -- Needed for MAPE calculation
            let orderByPBD = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery;
                })
                .entries(uniqueArray);

            // Calculate the sum for the Forecasts for each pbd != 0 ---------Calculation of MAPE
            let calculationsOrderByPBD = orderByPBD.map((el) => {
                const uniqueNames = [...new Set(el.values.map(i => i.Product))];

                // Forecast Sums
                let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);
                // console.log('validForecasts: ', validForecasts);

                let forecastOrdersForecastPeriods = new Map();
                validForecasts.map(e => {
                    forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
                });

                let invalidForecasts = el.values.filter(function(obj) {
                    return validForecasts.indexOf(obj) == -1;
                });
                let sumOfForecasts = validForecasts.reduce((a, b) => +a + +b.OrderAmount, 0);

                // FinalOrder Sums
                let items = el.values;
                let forecastItems = items.map(el => el.ForecastPeriod);
                let sumFinalOrders = 0;
                let difference = [];
                let MPEdifference = [];
                forecastItems.forEach(e => {
                    if (finalOrdersForecastPeriods.get(e) !== undefined) {
                        sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                        difference.push(Math.abs(finalOrdersForecastPeriods.get(e) -
                            forecastOrdersForecastPeriods.get(e)));
                        MPEdifference.push(forecastOrdersForecastPeriods.get(e) -
                            finalOrdersForecastPeriods.get(e));
                    }
                });
                let sumOfDifferences = difference.reduce((a, b) => +a + +b, 0);
                let MPEsumOfDifferences = MPEdifference.reduce((a, b) => +a + +b, 0);

                // MFB & MAPE
                let mfbValue = sumOfForecasts / sumFinalOrders;
                let mapeValue = sumOfDifferences / sumFinalOrders;
                let mpeValue = MPEsumOfDifferences / sumFinalOrders;

                return {
                    PeriodsBeforeDelivery: el.key,
                    Product: uniqueNames,
                    ActualPeriod: el.values[0].ActualPeriod,
                    ForecastPeriod: el.values[0].ForecastPeriod,
                    ActualDate: el.values[0].ActualDate,
                    sumOfForecasts: sumOfForecasts,
                    sumOfFinalOrders: sumFinalOrders,
                    difference: difference,
                    MFB: mfbValue.toFixed(3),
                    MPE: mpeValue.toFixed(3),
                    MAPE: mapeValue.toFixed(3)
                }
            });
            newFinalArray3 = calculationsOrderByPBD.filter((el) => {
                return !isNaN(el.MAPE);
            })

            newFinalArray3.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });

            newFinalArray4 = calculationsOrderByPBD.filter((el) => {
                return !isNaN(el.MFB);
            })
            let periodsBD3 = newFinalArray3.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax3 = Math.max(...periodsBD3);

            newFinalArray4.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });
            let periodsBD4 = newFinalArray4.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax4 = Math.max(...periodsBD4);

            newFinalArray5 = calculationsOrderByPBD.filter((el) => {
                return !isNaN(el.MPE);
            })
            newFinalArray5.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });
            let periodsBD5 = newFinalArray5.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax5 = Math.max(...periodsBD5);

            //Define mean value of Order Amount, i.e. Avg. Order Amount -- For MAPE calculation
            var dataMean = d3.mean(newFinalArray4, function(
                d) {
                return d.MAPE;
            });

            let valueMap = new Map();
            finalOrder.forEach((val) => {
                let keyString = val.ActualPeriod;
                let valueString = val.OrderAmount;
                valueMap.set(keyString, valueString);
            });
            //Absolute values array (needed for MAD calculation)
            let absValuesArray = uniqueArray.map((el) => {
                let value = absDiff(el, valueMap.get(el.ForecastPeriod));
                return {
                    ActualDate: el.ActualDate,
                    ForecastDate: el.ForecastDate,
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    Product: el.Product,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    AbsoluteDiff: value
                };
            });
            let seperatedByPeriods = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery
                })
                .entries(absValuesArray);

            let bubu = seperatedByPeriods.map((el) => {
                for (i = 0; i < seperatedByPeriods.length; i++) {
                    let meanValue = d3.mean(el.values, function(d) {
                        return d.AbsoluteDiff;
                    });
                    return {
                        ActualDate: el.values[i].ActualDate,
                        ForecastDate: el.values[i].ForecastDate,
                        Product: el.values[i].Product,
                        ActualPeriod: el.values[i].ActualPeriod,
                        ForecastPeriod: el.values[i].ForecastPeriod,
                        OrderAmount: el.values[i].OrderAmount,
                        PeriodsBeforeDelivery: el.key,
                        MAD: meanValue
                    };
                }
            });
            //Powered difference values array (needed for RMSE & MSE calculation)
            let squaredAbsValuesArray = uniqueArray.map((el) => {
                let value = powerDiff(el, valueMap.get(el.ForecastPeriod));
                return {
                    ActualDate: el.ActualDate,
                    ForecastDate: el.ForecastDate,
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    Product: el.Product,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    SquaredAbsoluteDiff: value
                };
            });
            //Nested array needed for RMSE & MSE calculation
            let seperatedByPeriods2 = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery
                })
                .entries(squaredAbsValuesArray);

            let bubu2 = seperatedByPeriods2.map((el) => {
                for (i = 0; i < seperatedByPeriods2.length; i++) {
                    let meanValue2 = Math.sqrt(d3.mean(el.values, function(d) {
                        return d.SquaredAbsoluteDiff;
                    }), 2);
                    let meanValue3 = d3.mean(el.values, function(d) {
                        return d.SquaredAbsoluteDiff;
                    });
                    return {
                        ActualDate: el.values[i].ActualDate,
                        ForecastDate: el.values[i].ForecastDate,
                        Product: el.values[i].Product,
                        ActualPeriod: el.values[i].ActualPeriod,
                        ForecastPeriod: el.values[i].ForecastPeriod,
                        OrderAmount: el.values[i].OrderAmount,
                        PeriodsBeforeDelivery: el.key,
                        MSE: meanValue3,
                        RMSE: meanValue2.toFixed(3)
                    };
                }
            });
            newFinalArray2 = bubu2.filter((el) => {
                return !isNaN(el.RMSE);
            })
            newFinalArray2.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });

            newFinalArray6 = bubu2.filter((el) => {
                return !isNaN(el.MSE);
            })
            newFinalArray6.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });
            let periodsBD6 = newFinalArray6.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax6 = Math.max(...periodsBD6);

            newFinalArray = bubu.filter((el) => {
                return !isNaN(el.MAD);
            })
            newFinalArray.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });
            let periodsBD = newFinalArray.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax = Math.max(...periodsBD);

            let periodsBD2 = newFinalArray2.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax2 = Math.max(...periodsBD2);

            //MAD graph crossfilter
            var ndx = crossfilter(newFinalArray);
            var all = ndx.groupAll();
            var productDim = ndx.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim = ndx.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxDim = ndx.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MAD, +d.Product];
            });
            var ndxGroup = ndxDim.group();

            //RMSE graph crossfilter
            var ndx2 = crossfilter(newFinalArray2);
            var all2 = ndx2.groupAll();
            var ndxDim2 = ndx2.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.RMSE, +d.Product];
            });
            var productDim2 = ndx2.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim2 = ndx2.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxGroup2 = ndxDim2.group();
            console.log("ndxDim2: ", ndxGroup2.top(Infinity));

            //MAPE graph crossfilter
            var ndx3 = crossfilter(newFinalArray3);
            var all3 = ndx3.groupAll();
            var ndxDim3 = ndx3.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MAPE, +d.Product];
            });
            var productDim3 = ndx3.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim3 = ndx3.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxGroup3 = ndxDim3.group();

            //MFB graph crossfilter
            var ndx4 = crossfilter(newFinalArray4);
            var all4 = ndx4.groupAll();
            var ndxDim4 = ndx4.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MFB, d.Product];
            });
            var productDim4 = ndx4.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim4 = ndx4.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxGroup4 = ndxDim4.group();

            //MPE graph crossfilter
            var ndx5 = crossfilter(newFinalArray5);
            var all5 = ndx5.groupAll();
            var ndxDim5 = ndx5.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MPE, d.Product];
            });
            var productDim5 = ndx5.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim5 = ndx5.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxGroup5 = ndxDim5.group();

            //MSE graph crossfilter
            var ndx6 = crossfilter(newFinalArray6);
            var all6 = ndx6.groupAll();
            var ndxDim6 = ndx6.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MSE, d.Product];
            });
            var productDim6 = ndx6.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim6 = ndx6.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var ndxGroup6 = ndxDim6.group();

            MADchart
                .width(520)
                .height(350)
                .dimension(ndxDim)
                .symbolSize(10)
                .group(ndxGroup)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== NaN;
                        });
                })
                // .excludedSize(3)
                // .excludedOpacity(0.5)
                .x(d3.scaleLinear().domain([0, periodsMax]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MAD")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MAD: ' + d.key[1]
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));

            RMSEchart
                .width(520)
                .height(350)
                .dimension(ndxDim2)
                .symbolSize(10)
                .group(ndxGroup2)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== NaN || d.key !== "NaN" || d.key !==
                                Infinity;
                        });
                })
                .x(d3.scaleLinear().domain([0, periodsMax2]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("RMSE")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'RMSE: ' + d.key[1],
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));

            MAPEchart
                .width(520)
                .height(350)
                .dimension(ndxDim3)
                .symbolSize(10)
                .group(ndxGroup3)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== undefined || d.key !== NaN;
                        });
                })
                .x(d3.scaleLinear().domain([0, periodsMax3]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MAPE")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MAPE: ' + d.key[1]
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));

            MFBchart
                .width(520)
                .height(350)
                .dimension(ndxDim4)
                .symbolSize(10)
                .group(ndxGroup4)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== Infinity;
                        });
                })
                .excludedSize(2)
                .excludedOpacity(0.5)
                .x(d3.scaleLinear().domain([0, periodsMax4]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MFB")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MFB: ' + d.key[1]
                    ].join('\n');
                })
                .on('renderlet', function(MFBchart) {
                    var x_vert = width;
                    var extra_data = [{
                            x: 47,
                            y: MFBchart.y()(dataMean)
                        },
                        {
                            x: MFBchart.x()(x_vert),
                            y: MFBchart.y()(dataMean)
                        }
                    ];

                    var line = d3.line()
                        .x(function(d) {
                            return d.x;
                        })
                        .y(function(d) {
                            return d.y;
                        })
                        .curve(d3.curveLinear);
                    var chartBody = MFBchart.select('g');
                    var path = chartBody.selectAll('path.extra').data([extra_data]);
                    path = path.enter()
                        .append('path')
                        .attr('class', 'oeExtra')
                        .attr('stroke', 'orange')
                        .attr('id', 'oeLine')
                        .attr("stroke-width", 1)
                        .style("stroke-dasharray", ("10,3"))
                        .merge(path);
                    path.attr('d', line);
                })
                .xAxis().tickFormat(d3.format('d'));

            MFBchart.symbol(d3.symbolCircle);

            MPEchart
                .width(520)
                .height(350)
                .dimension(ndxDim5)
                .symbolSize(10)
                .group(ndxGroup5)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== undefined || d.key !== NaN;
                        });
                })
                .x(d3.scaleLinear().domain([0, periodsMax5]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MPE")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MPE: ' + d.key[1]
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));

            MSEchart
                .width(520)
                .height(350)
                .dimension(ndxDim6)
                .symbolSize(10)
                .group(ndxGroup6)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== NaN;
                        });
                })
                .excludedSize(2)
                .excludedOpacity(0.5)
                .x(d3.scaleLinear().domain([0, periodsMax6]))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MSE")
                // .mouseZoomable(true)
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MSE: ' + d.key[1]
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));

            MSEchart.yAxis().tickFormat(d3.format(".2s"));

            dc.renderAll();


        });
        </script>


        <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"
                integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
                crossorigin="anonymous"> -->
        </script>
        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>
</body>

</html>