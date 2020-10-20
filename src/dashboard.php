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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css" />
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="../lib/js/localforage.js"></script>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="../lib/js/crossfilter.js"></script>
    <script src="../lib/js/dc.js"></script>
    <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script>
    <script>
    localforage.config({
        driver: localforage.INDEXEDDB,
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
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz  <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li class="dropdown-header">Dashboard</li>
                        <li class="active"><a href="./dashboard.php">Dashboard</a></li>
                        <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount <span class="sr-only">(current)</span></a>
                            </li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix with Percentage Error </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Forecast Error Measures</li>
                            <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
                            <li><a href="./md_graph.php">Mean Deviation (MD) </a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./normalized_rmse.php">Normalized Root Mean Square Error (RMSE*)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE) </a></li>
                            <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                        </ul>
                    </li>
                    <!-- <li class="active"><a href="./dashboard.php">Dashboard</a></li> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                    </li>
                    <li><a href="./ClusterTest.php">Clustering </a> </li>
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

    <!-- Page Features -->
    <div class="customContainer text-center">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-6">
                <h2>Forecast Error Measures - Dashboard</h2>
                <small>
                    <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
                <p style="margin-top: 15px;">
                    On this page you find a overview about the available error measures this tool provides. Each error
                    measure has a dedicated page itself with a bigger view and
                    the possiblity to adjust some further elements or view specific items and compare them. This view is
                    mainly for a quick comparison and has only the main filters
                    applied from the <a href="./configuration.php"><strong>Configuration</strong></a> page. <button
                        class="btn btn-secondary" id="exportFunction"><strong>Export Data</strong></button>
                </p>
            </div>
            <div class="col-md-2">
                <div id="filterInfo" class="alert alert-info" style="text-align: center" role="info">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-info" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-info"
                                role="info">Filters are applied!</span>
                        </div>
                        <div class="row">
                            <span style="font-size: 12px; vertical-align: middle;" class="alert-info" role="info">
                                To
                                change settings please visit <a href="./configuration.php">Configuration</a>.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div id="filter2Info" class="alert alert-danger" style="text-align: center" role="alert">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-danger" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-danger"
                                role="info">Filters have not been applied!</span>
                        </div>
                        <div class="row">
                            <span style="font-size: 11px; vertical-align: middle;" class="alert-danger" role="alert">
                                Please adjust the Date Filters so that Actual Date <= Forecast Date.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div id="filter3Info" class="alert alert-danger" style="text-align: center" role="alert">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-danger" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-danger"
                                role="danger">More
                                than one product have been selected.</span>
                        </div>
                    </div>
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
                    <div id="scatter4">
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Mean Forecast Bias (MFB)</h4>
                    <p class="card-text">To view the full graph please see the graph page: <a
                            href="./meanforecastbias.php">MFB</a>.</p>
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
                    <p class="card-text">To view the full graph please see the graph page: <a href="./mpe.php">MPE</a>.</p>
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
                            href="./rmse_graph.php">RMSE</a>.</p>
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
                            href="./mse_graph.php">MSE</a>.</p>
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
                    <p class="card-text">To view the full graph please see the graph page: <a href="./mape.php">MAPE</a>.</p>
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
                            href="./mad_graph.php">MAD</a>.</p>
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
                    <div id="scatter7">
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Normalized Root Mean Square Error (RMSE*)</h4>
                    <p class="card-text">To view the full graph please see the graph page: <a
                            href="./normalized_rmse.php">RMSE*/NRMSE</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-img-top chartBox drop-shadow">
                    <div id="scatter8">
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Mean Deviation (MD)</h4>
                    <p class="card-text">To view the full graph please see the graph page: <a href="./md_graph.php">MD</a>.</p>
                </div>
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

    $(document).ready(function() {
        if (localStorage.getItem('check2FiltersActive') === 'true') {
            $('#filter2Info').show();
        } else {
            $('#filter2Info').hide();
        }
    });
    $(document).ready(function() {
        if (localStorage.getItem('check3FiltersActive') === 'true') {
            $('#filter3Info').hide();
        } else {
            $('#filter3Info').show();
        }
    });
    const margin = {
        top: 10,
        right: 10,
        bottom: 45,
        left: 55
    };
    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);

        var RMSEchart = dc.scatterPlot("#scatter2"),
            MAPEchart = dc.scatterPlot("#scatter3"),
            MFBchart = dc.scatterPlot("#scatter4"),
            MPEchart = dc.scatterPlot("#scatter5"),
            MSEchart = dc.scatterPlot("#scatter6"),
            NRMSEchart = dc.scatterPlot("#scatter7"),
            MDchart = dc.scatterPlot("#scatter8"),
            MADchart = dc.scatterPlot("#scatter");

        let width = 520;

        // Define function of absolute difference of forecast and final orders (needed for MAD graph)
        let absDiff = function(orignalEl, finalOrder) {
            return Math.abs(orignalEl.OrderAmount - finalOrder);
        }
        let mdDiff = function(orignalEl, finalOrder) {
            return orignalEl.OrderAmount - finalOrder;
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
        // Define valid final orders (for normalized RMSE calculation)
        let finalOrderForecastPeriods = finalOrder.map(e => e.ForecastPeriod);
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

            let pbdForecasts = el.values.map(e => e.ForecastPeriod);
            // ALL valid Forecast Periods for each Period before delivery -- Calculation of Normalized RMSE (RMSE*)
            let validForecasts2 = finalOrderForecastPeriods.filter(value => -1 !== pbdForecasts
                .indexOf(value));
            let noFinalOrders = validForecasts2.length;

            // FinalOrder Sums
            let items = el.values;
            let forecastItems = items.map(el => el.ForecastPeriod);
            let sumFinalOrders = 0;
            let forecastSum = 0;
            let difference = [];
            let MPEdifference = [];
            forecastItems.forEach(e => {
                if (finalOrdersForecastPeriods.get(e) !== undefined) {
                    sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                    forecastSum += parseInt(forecastOrdersForecastPeriods.get(e), 0);
                    difference.push(Math.abs(finalOrdersForecastPeriods.get(e) -
                        forecastOrdersForecastPeriods.get(e)));
                    MPEdifference.push(forecastOrdersForecastPeriods.get(e) -
                        finalOrdersForecastPeriods.get(e));
                }
            });

            let meanFinalOrders = sumFinalOrders / noFinalOrders;
            // console.log('MEAN', meanFinalOrders, ' for PBD: ', el.values[0].PeriodsBeforeDelivery);
            let sumOfDifferences = difference.reduce((a, b) => +a + +b, 0);
            let MPEsumOfDifferences = MPEdifference.reduce((a, b) => +a + +b, 0);

            // MFB & MAPE
            let mfbValue = forecastSum / sumFinalOrders;
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
                MeanFinalOrders: meanFinalOrders,
                MFB: mfbValue.toFixed(3),
                MPE: mpeValue.toFixed(3),
                MAPE: mapeValue.toFixed(3)
            }
        });

        var exportArray = calculationsOrderByPBD.map((el) => {
            return {
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MFB: el.MFB,
                MPE: el.MPE,
                MAPE: el.MAPE + ' \n'
            }
        })

        oneFinalArray = calculationsOrderByPBD.filter((el) => {
            return !isNaN(el.MAPE);
        })
        twoFinalArray = oneFinalArray.filter((el) => {
            return el.MAPE !== Infinity;
        })
        newFinalArray3 = twoFinalArray.filter((el) => {
            return el.MAPE !== 'Infinity';
        })

        newFinalArray3.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });

        oneFinalArrayMFB = calculationsOrderByPBD.filter((el) => {
            return !isNaN(el.MFB);
        })
        twoFinalArrayMFB = oneFinalArrayMFB.filter((el) => {
            return el.MFB !== Infinity;
        })
        newFinalArray4 = twoFinalArrayMFB.filter((el) => {
            return el.MFB !== 'Infinity';
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
        // console.log(periodsMax4, periodsBD4);

        oneFinalArrayMPE = calculationsOrderByPBD.filter((el) => {
            return !isNaN(el.MFB);
        })
        twoFinalArrayMPE = oneFinalArrayMPE.filter((el) => {
            return el.MFB !== Infinity;
        })
        newFinalArray5 = twoFinalArrayMPE.filter((el) => {
            return el.MPE !== 'Infinity';
        })
        newFinalArray5.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });
        let periodsBD5 = newFinalArray5.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMax5 = Math.max(...periodsBD5);

        //Define mean value of Order Amount, i.e. Avg. Order Amount -- For MFB calculation
        var dataMean = d3.mean(newFinalArray4, function(
            d) {
            return d.MFB;
        });
        console.log("dataMean", dataMean);

        let valueMap = new Map();
        finalOrder.forEach((val) => {
            let keyString = val.ActualPeriod;
            let valueString = val.OrderAmount;
            valueMap.set(keyString, valueString);
        });
        console.log("valueMap", valueMap);
        //Absolute values array (needed for MAD calculation)
        let absValuesArray = uniqueArray.map((el) => {
            let value = absDiff(el, valueMap.get(el.ForecastPeriod));
            let value2 = mdDiff(el, valueMap.get(el.ForecastPeriod));
            return {
                ActualDate: el.ActualDate,
                ForecastDate: el.ForecastDate,
                ActualPeriod: el.ActualPeriod,
                ForecastPeriod: el.ForecastPeriod,
                OrderAmount: el.OrderAmount,
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MAD: value,
                MD: value2
            };
        });
        var newSeparatedByPBD = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery;
            })
            .key(function(d) {
                return d.Product;
            })
            .entries(absValuesArray);

        let seperatedByPeriods = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery
            })
            .entries(absValuesArray);

        let periodsMAD = absValuesArray.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMaxMad = Math.max(...periodsMAD);
        let periodsMinMad = Math.min(...periodsMAD);
        // console.log(periodsMAD, periodsMinMad, periodsMaxMad);
        let productCount = [...new Set(uniqueArray.map(i => i.Product))];

        let bubu = seperatedByPeriods.map((el) => {
            for (i = 0; i < seperatedByPeriods.length; i++) {
                let meanValue = d3.mean(el.values, function(d) {
                    return d.MAD;
                });
                meanValue5 = d3.mean(el.values, function(d) {
                    return d.MD;
                });
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: el.values[i].Product,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    MAD: meanValue,
                    MD: meanValue5
                }
            }
        });
        console.log("bubu", bubu);
        var exportArray2 = bubu.map((el) => {
            return {
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MD: el.MD,
                MAD: el.MAD + "\n"
            }
        })
        let absValuesArray2 = uniqueArray.map((el) => {
            let value2 = mdDiff(el, valueMap.get(el.ForecastPeriod));
            return {
                ActualDate: el.ActualDate,
                ForecastDate: el.ForecastDate,
                ActualPeriod: el.ActualPeriod,
                ForecastPeriod: el.ForecastPeriod,
                OrderAmount: el.OrderAmount,
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MD: value2
            };
        });
        let seperatedByPeriods3 = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery
            })
            .entries(absValuesArray2);

        let mdArray = seperatedByPeriods3.map((el) => {
            for (i = 0; i < seperatedByPeriods3.length; i++) {
                let meanValue4 = d3.mean(el.values, function(d) {
                    return d.MD;
                });
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: el.values[i].Product,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    MD: meanValue4
                };
            }
        });
        var exportArray4 = mdArray.map((el) => {
            return {
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MD: el.MD + ' \n'
            }
        })
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
        //Combining two arrays to get values of normalized RMSE
        var squaredAbsValuesArray2 = squaredAbsValuesArray.reduce((arr, e) => {
            arr.push(Object.assign({}, e, calculationsOrderByPBD.find(a => a
                .PeriodsBeforeDelivery == e.PeriodsBeforeDelivery)))
            return arr;
        }, [])
        //Nested array needed for RMSE & MSE calculation
        let seperatedByPeriods2 = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery
            })
            .entries(squaredAbsValuesArray2);

        var newSeparatedByPBD2 = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery;
            })
            .key(function(d) {
                return d.Product;
            })
            .entries(squaredAbsValuesArray2);

        let bubu2 = seperatedByPeriods2.map((el) => {
            for (i = 0; i < seperatedByPeriods2.length; i++) {
                let meanValue2 = Math.sqrt(d3.mean(el.values, function(d) {
                    return d.SquaredAbsoluteDiff;
                }), 2);
                let meanValue3 = d3.mean(el.values, function(d) {
                    return d.SquaredAbsoluteDiff;
                });
                let normRMSE = meanValue2 / el.values[i].MeanFinalOrders;
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: el.values[i].Product,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    MSE: meanValue3,
                    NRMSE: normRMSE.toFixed(2),
                    RMSE: meanValue2.toFixed(2)
                };
            }
        });

        var exportArray3 = bubu2.map((el) => {
            return {
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MSE: el.MSE,
                NRMSE: el.NRMSE,
                RMSE: el.RMSE + "\n"
            }
        })

        /**Combine three export Arrays */
        // let arr3 = exportArray.map((item, i) => Object.assign({}, item, exportArray2[i]));

        let merged = [];
        for (let i = 0; i < exportArray.length; i++) {
            merged.push({
                ...exportArray[i],
                ...exportArray2[i],
                ...exportArray3[i],
                ...exportArray4[i]
            });
        }

        /**   Convert array to csv function           */
        function pivot(arr) {
            var mp = new Map();

            function setValue(a, path, val) {
                if (Object(val) !== val) { // primitive value
                    var pathStr = path.join('.');
                    var i = (mp.has(pathStr) ? mp : mp.set(pathStr, mp.size)).get(pathStr);
                    a[i] = val;
                } else {
                    for (var key in val) {
                        setValue(a, key == '0' ? path : path.concat(key), val[key]);
                    }
                }
                return a;
            }
            var result = arr.map(obj => setValue([], [], obj));
            return [
                [...mp.keys()], ...result
            ];
        }

        function toCsv(arr) {
            return arr.map(row =>
                row.map(val => isNaN(val) ? JSON.stringify(val) : +val).join(',')
            ).join("\n");
        }
        oneFinalArray = merged.filter((el) => {
            return !isNaN(el.MAPE);
        })
        var merged2 = oneFinalArray.filter(function(el) {
            return el != "undefined";
        });

        let newCsvContent = toCsv(pivot(merged2));
        // console.log("newCsvContent array: ", newCsvContent);
        /****     Saving data to localforage: JS object array and CSV export array     * */

        localforage.setItem('clustering_data', JSON.stringify(merged2));
        // localforage.setItem('export_data', JSON.stringify(newCsvContent));
        // console.log('SAVING: ', newCsvContent);

        /** Export script */
        $("#exportFunction").click(function() {
            saveFile("All_errorMeasures.csv", "data:attachment/csv", newCsvContent);
        });

        /** Function to save file as csv */
        function saveFile(name, type, data) {
            if (data != null && navigator.msSaveBlob)
                return navigator.msSaveBlob(new Blob([data], {
                    type: type
                }), name);
            var a = $("<a style='display: none;'/>");
            var url = window.URL.createObjectURL(new Blob([data], {
                type: type
            }));
            a.attr("href", url);
            a.attr("download", name);
            $("body").append(a);
            a[0].click();
            window.URL.revokeObjectURL(url);
            a.remove();
        }
        /** End of export function */

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

        oneFinalArrayNRMSE = bubu2.filter((el) => {
            return !isNaN(el.NRMSE);
        })
        twoFinalArrayNRMSE = oneFinalArrayNRMSE.filter((el) => {
            return el.NRMSE !== Infinity;
        })
        newFinalArray7 = twoFinalArrayNRMSE.filter((el) => {
            return el.NRMSE !== 'Infinity';
        })
        newFinalArray7.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });
        let periodsBD7 = newFinalArray7.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMax7 = Math.max(...periodsBD7);

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

        newMDArray = bubu.filter((el) => {
            return !isNaN(el.MD);
        })
        newMDArray.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });
        let mdPeriodsBD = newMDArray.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMax8 = Math.max(...mdPeriodsBD);

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

        //MD graph crossfilter
        var ndx8 = crossfilter(newMDArray);
        var all8 = ndx8.groupAll();
        var productDim8 = ndx8.dimension(function(d) {
            return d.Product;
        });
        var periodsBeforeDeliveryDim8 = ndx8.dimension(function(d) {
            return +d.PeriodsBeforeDelivery;
        });
        var ndxDim8 = ndx8.dimension(function(d) {
            return [+d.PeriodsBeforeDelivery, +d.MD, +d.Product];
        });
        var ndxGroup8 = ndxDim8.group();

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
        // console.log("ndxDim2: ", ndxGroup2.top(Infinity));

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

        //NRMSE graph crossfilter
        var ndx7 = crossfilter(newFinalArray7);
        var all7 = ndx7.groupAll();
        var ndxDim7 = ndx7.dimension(function(d) {
            return [+d.PeriodsBeforeDelivery, +d.NRMSE, d.Product];
        });
        var productDim7 = ndx7.dimension(function(d) {
            return d.Product;
        });
        var periodsBeforeDeliveryDim7 = ndx7.dimension(function(d) {
            return +d.PeriodsBeforeDelivery;
        });
        var ndxGroup7 = ndxDim7.group();

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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        MADchart.margins(margin);

        MDchart
            .width(520)
            .height(350)
            .dimension(ndxDim8)
            .symbolSize(10)
            .group(ndxGroup8)
            .data(function(group) {
                return group.all()
                    .filter(function(d) {
                        return d.key !== NaN;
                    });
            })
            .x(d3.scaleLinear().domain([0, periodsMax8]))
            .brushOn(false)
            .clipPadding(10)
            .xAxisLabel("Periods Before Delivery")
            .yAxisLabel("MD")
            .renderTitle(true)
            .title(function(d) {
                return [
                    'Periods Before Delivery: ' + d.key[0],
                    'MD: ' + d.key[1]
                ].join('\n');
            })
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        MDchart.margins(margin);

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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        RMSEchart.margins(margin);

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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        MAPEchart.margins(margin);

        MFBchart
            .width(width)
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
            // .excludedSize(2)
            // .excludedOpacity(0.5)
            // .x(d3.scaleLinear().domain([0, d3.max(periodsBD4, function(d) {
            //     return d;
            // })]))
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
                        x: 54,
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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        // MFBchart.symbol(d3.symbolCircle);
        MFBchart.margins(margin);


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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
        MPEchart.margins(margin);

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
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));

        MSEchart.yAxis().tickFormat(d3.format(".2s"));
        MSEchart.margins(margin);

        NRMSEchart
            .width(520)
            .height(350)
            .dimension(ndxDim7)
            .symbolSize(10)
            .group(ndxGroup7)
            .data(function(group) {
                return group.all()
                    .filter(function(d) {
                        return d.key !== NaN || d.key !== "NaN" || d.key !==
                            Infinity;
                    });
            })
            .x(d3.scaleLinear().domain([0, periodsMax7]))
            .brushOn(false)
            .clipPadding(10)
            .xAxisLabel("Periods Before Delivery")
            .yAxisLabel("NRMSE")
            .renderTitle(true)
            .title(function(d) {
                return [
                    'Periods Before Delivery: ' + d.key[0],
                    'NRMSE: ' + d.key[1],
                ].join('\n');
            })
            .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
            // .xAxis().tickFormat(d3.format('d'));
        NRMSEchart.margins(margin);

        dc.renderAll();


    });
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
</body>

</html>