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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.5.1/lodash.min.js"></script>
    <script>
    localforage.config({
        driver: localforage.INDEXEDDB,
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>
    <script src="./js/calculateErrorMeasures.js"></script>
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Visualizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
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
                    <li class="active"><a href="./dashboard.php">Dashboard</a></li>
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
                            href="./normalized_rmse.php">Normalized Root Mean Square Error (RMSE*/NRMSE)</a>.</p>
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
                    <p class="card-text">To view the full graph please see the graph page: <a href="./md_graph.php">Mean
                            Deviation (MD)</a>.</p>
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
            $('#filter3Info').show();
        } else {
            $('#filter3Info').hide();
        }
    });
    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);
        console.log(data);

        let nested = d3.nest().key(function(d) {
                return d.Product
            })
            .entries(data);

        console.log(nested);

        const calculationErrorMeasures = [];

        for (let i = 0; i < nested.length; i++) {
            // for (let j = 0; j < nested[i].values.length; j++) {
            const currentData = nested[i].values;
            const currentProduct = nested[i].key;
            // const currentPBD = nested[i].values[j].PeriodsBeforeDelivery;

            let mapeResult = calculateMape(currentData);
            let madResult = calculateMAD(currentData);
            let mdResult = calculateMD(currentData);
            let mseResult = calculateMSE(currentData);
            let rmseResult = calculateRMSE(currentData);
            let norm_rmseResult = calculateNormRMSE(currentData);
            let mpeResult = calculateMPE(currentData);
            let mfbResult = calculateMFB(currentData);

            for (let j = 0; j < mfbResult.length; j++) {
                const currentPBD = mfbResult[j].PeriodsBeforeDelivery;
                calculationErrorMeasures.push({
                    Product: currentProduct,
                    PeriodsBeforeDelivery: mfbResult[j].PeriodsBeforeDelivery,
                    MAD: madResult[j].MAD,
                    MD: mdResult[j].MD,
                    MFB: mfbResult[j].MFB,
                    MPE: mpeResult[j].MPE,
                    MAPE: mapeResult[j].MAPE,
                    MSE: mseResult[j].MSE,
                    NRMSE: norm_rmseResult[j].NRMSE,
                    RMSE: rmseResult[j].RMSE,
                });
            }
        }
        console.log('final error measures:', calculationErrorMeasures);
    });
    // localforage.getItem("viz_data", function(error, data) {
    //     data = JSON.parse(data);

    //     var RMSEchart = dc.scatterPlot("#scatter2"),
    //         MAPEchart = dc.scatterPlot("#scatter3"),
    //         MFBchart = dc.scatterPlot("#scatter4"),
    //         MPEchart = dc.scatterPlot("#scatter5"),
    //         MSEchart = dc.scatterPlot("#scatter6"),
    //         NRMSEchart = dc.scatterPlot("#scatter7"),
    //         MDchart = dc.scatterPlot("#scatter8"),
    //         MADchart = dc.scatterPlot("#scatter");

    //     let width = 520;

    //     // Define function of absolute difference of forecast and final orders (needed for MAD graph)
    //     let absDiff = function(orignalEl, finalOrder) {
    //         return Math.abs(orignalEl.OrderAmount - finalOrder);
    //     }
    //     let mdDiff = function(orignalEl, finalOrder) {
    //         return orignalEl.OrderAmount - finalOrder;
    //     }

    //     // Define function of power of difference of forecast and final orders (needed for RMSE graph)
    //     let powerDiff = function(orignalEl, finalOrder) {
    //         return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
    //     }
    //     // Define final orders: PBD = 0 means Final Orders
    //     let finalOrder = data.filter((el) => {
    //         return el.PeriodsBeforeDelivery == 0;
    //     });
    //     // Define forecast orders (which are not final orders)
    //     let uniqueArray = data.filter(function(obj) {
    //         return finalOrder.indexOf(obj) == -1;
    //     });
    //     // Define valid final orders (for normalized RMSE calculation)
    //     let finalOrderForecastPeriods = finalOrder.map(e => e.ForecastPeriod);
    //     // Define valid final orders (for MAPE calculation)
    //     let finalOrdersForecastPeriods = new Map();
    //     finalOrder.map(e => {
    //         finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    //     });
    //     //Order All data by PBD (for MAPE calculation)
    //     // Order the Final Orders
    //     let dataByPBD = d3.nest()
    //         .key(function(d) {
    //             return d.ActualPeriod;
    //         })
    //         .entries(data);

    //     //Find the max number of Actual periods in Final orders array -- Needed for MAPE calculation
    //     let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function(o) {
    //         return o.ActualPeriod;
    //     }))

    //     // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders -- Needed for MAPE calculation
    //     let orderByPBD = d3.nest()
    //         .key(function(d) {
    //             return d.PeriodsBeforeDelivery;
    //         })
    //         .entries(uniqueArray);

    //     // Calculate the sum for the Forecasts for each pbd != 0 ---------Calculation of MAPE
    //     let calculationsOrderByPBD = orderByPBD.map((el) => {
    //         const uniqueNames = [...new Set(el.values.map(i => i.Product))];

    //         // Forecast Sums
    //         let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);
    //         // console.log('validForecasts: ', validForecasts);

    //         let forecastOrdersForecastPeriods = new Map();
    //         validForecasts.map(e => {
    //             forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
    //         });

    //         let invalidForecasts = el.values.filter(function(obj) {
    //             return validForecasts.indexOf(obj) == -1;
    //         });
    //         let sumOfForecasts = validForecasts.reduce((a, b) => +a + +b.OrderAmount, 0);

    //         let pbdForecasts = el.values.map(e => e.ForecastPeriod);
    //         // ALL valid Forecast Periods for each Period before delivery -- Calculation of Normalized RMSE (RMSE*)
    //         let validForecasts2 = finalOrderForecastPeriods.filter(value => -1 !== pbdForecasts
    //             .indexOf(value));
    //         let noFinalOrders = validForecasts2.length;

    //         // FinalOrder Sums
    //         let items = el.values;
    //         let forecastItems = items.map(el => el.ForecastPeriod);
    //         let sumFinalOrders = 0;
    //         let forecastSum = 0;
    //         let difference = [];
    //         let MPEdifference = [];
    //         forecastItems.forEach(e => {
    //             if (finalOrdersForecastPeriods.get(e) !== undefined) {
    //                 sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
    //                 forecastSum += parseInt(forecastOrdersForecastPeriods.get(e), 0);
    //                 difference.push(Math.abs(finalOrdersForecastPeriods.get(e) -
    //                     forecastOrdersForecastPeriods.get(e)));
    //                 MPEdifference.push(forecastOrdersForecastPeriods.get(e) -
    //                     finalOrdersForecastPeriods.get(e));
    //             }
    //         });

    //         let meanFinalOrders = sumFinalOrders / noFinalOrders;
    //         let sumOfDifferences = difference.reduce((a, b) => +a + +b, 0);
    //         let MPEsumOfDifferences = MPEdifference.reduce((a, b) => +a + +b, 0);

    //         // MFB & MAPE
    //         let mfbValue = forecastSum / sumFinalOrders;
    //         let mapeValue = sumOfDifferences / sumFinalOrders;
    //         let mpeValue = MPEsumOfDifferences / sumFinalOrders;

    //         return {
    //             PeriodsBeforeDelivery: el.key,
    //             Product: uniqueNames,
    //             ActualPeriod: el.values[0].ActualPeriod,
    //             ForecastPeriod: el.values[0].ForecastPeriod,
    //             ActualDate: el.values[0].ActualDate,
    //             sumOfForecasts: sumOfForecasts,
    //             sumOfFinalOrders: sumFinalOrders,
    //             difference: difference,
    //             MeanFinalOrders: meanFinalOrders,
    //             MFB: mfbValue.toFixed(3),
    //             MPE: mpeValue.toFixed(3),
    //             MAPE: mapeValue.toFixed(3)
    //         }
    //     });

    //     var exportArray = calculationsOrderByPBD.map((el) => {
    //         return {
    //             Product: el.Product,
    //             PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
    //             MFB: el.MFB,
    //             MPE: el.MPE,
    //             MAPE: el.MAPE + ' \n'
    //         }
    //     })

    //     oneFinalArray = calculationsOrderByPBD.filter((el) => {
    //         return !isNaN(el.MAPE);
    //     })
    //     twoFinalArray = oneFinalArray.filter((el) => {
    //         return el.MAPE !== Infinity;
    //     })
    //     newFinalArray3 = twoFinalArray.filter((el) => {
    //         return el.MAPE !== 'Infinity';
    //     })

    //     newFinalArray3.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });

    //     oneFinalArrayMFB = calculationsOrderByPBD.filter((el) => {
    //         return !isNaN(el.MFB);
    //     })
    //     twoFinalArrayMFB = oneFinalArrayMFB.filter((el) => {
    //         return el.MFB !== Infinity;
    //     })
    //     newFinalArray4 = twoFinalArrayMFB.filter((el) => {
    //         return el.MFB !== 'Infinity';
    //     })
    //     let periodsBD3 = newFinalArray3.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax3 = Math.max(...periodsBD3);

    //     newFinalArray4.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let periodsBD4 = newFinalArray4.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax4 = Math.max(...periodsBD4);

    //     oneFinalArrayMPE = calculationsOrderByPBD.filter((el) => {
    //         return !isNaN(el.MFB);
    //     })
    //     twoFinalArrayMPE = oneFinalArrayMPE.filter((el) => {
    //         return el.MFB !== Infinity;
    //     })
    //     newFinalArray5 = twoFinalArrayMPE.filter((el) => {
    //         return el.MPE !== 'Infinity';
    //     })
    //     newFinalArray5.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let periodsBD5 = newFinalArray5.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax5 = Math.max(...periodsBD5);

    //     //Define mean value of Order Amount, i.e. Avg. Order Amount -- For MAPE calculation
    //     var dataMean = d3.mean(newFinalArray4, function(
    //         d) {
    //         return d.MAPE;
    //     });

    //     let valueMap = new Map();
    //     finalOrder.forEach((val) => {
    //         let keyString = val.ActualPeriod;
    //         let valueString = val.OrderAmount;
    //         valueMap.set(keyString, valueString);
    //     });
    //     var valueMap2 = d3.nest()
    //         .key(function(d) {
    //             return d.Product;
    //         })
    //         .key(function(d) {
    //             return d.ActualPeriod;
    //         })
    //         .entries(finalOrder);
    //     console.log("valueMap2: ", valueMap2);

    //     let dataByProducts2 = d3.nest()
    //         .key(function(d) {
    //             return d.Product;
    //         })
    //         .key(function(d) {
    //             return d.ForecastPeriod;
    //         })
    //         .entries(uniqueArray);
    //     console.log("dataByProducts2: ", dataByProducts2);

    //     var merge = _.mergeWith({}, valueMap2, dataByProducts2, function(a, b) {
    //         // if (isNaN(a[i]) != false) {
    //         if (_.isArray(a)) {
    //             return b.concat(a);
    //         }
    //     });
    //     let merge2 = JSON.stringify(merge).substr(1, JSON.stringify(merge).length - 3);
    //     var output = [];

    //     let result2 = Object.keys(merge).reduce(function(r, k) {
    //         return r.concat(k, merge[k].values);
    //     }, []);

    //     //** Remove NaN values from the array */
    //     let result3 = result2.filter((el) => {
    //         return isNaN(el) != false;
    //     });
    //     /** Remove duplicate values from result3 */
    //     let result4 = Object.values(result3.reduce((c, {
    //         key,
    //         values
    //     }) => {
    //         c[key] = c[key] || {
    //             key,
    //             values: []
    //         };
    //         c[key].values = c[key].values.concat(Array.isArray(values) ? values : [values]);
    //         return c;
    //     }, {}));

    //     function getKeyValues(arr, key) {
    //         return arr.reduce((a, b) => {
    //             let keys = Object.keys(b);
    //             keys.forEach(v => {
    //                 if (Array.isArray(b[v])) a = a.concat(getKeyValues(b[v], key));
    //                 if (v === key) a = a.concat(b[v]);
    //             });
    //             return a;
    //         }, [])
    //     }
    //     let periodsFilter = getKeyValues(result4, "key");
    //     console.log(result4, periodsFilter);
    //     console.log("merge", merge);


    //     let MadCalcNew = [];
    //     let newMADcalc = result4.map((el) => {
    //         const productNames = [...new Set(el.values.map(i => i.Product))];
    //         const orderAmount = [...new Set(el.values.map(i => i.OrderAmount))];
    //         const actualPeriods = [...new Set(el.values.map(i => i.ActualPeriod))];
    //         // console.log("allPeriodsBeforeDelivery", allPeriodsBeforeDelivery);
    //         // let finalOrdersFilter = el.values.filter(e => e.PeriodsBeforeDelivery == 0);
    //         // let forecastOrdersFilter = el.values.filter(e => e.PeriodsBeforeDelivery != 0);


    //         let finalOrdersOu = [];
    //         let finalOrdersMap = new Map();
    //         let finalOrdersMap1 = new Map();
    //         let finalOrdersMap2 = new Map();
    //         finalOrder.map(e => {
    //             finalOrdersMap.set(e.ActualPeriod, e.OrderAmount);
    //             finalOrdersMap1.set(e.OrderAmount, e.Product);
    //             console.log("finalOrdersMap1",  finalOrdersMap1);
    //         });

    //         let forecastOrdersOu = [];
    //         let forecastOrdersMap = new Map();
    //         let forecastOrdersMap1 = new Map();
    //         let forecastOrdersMap2 = new Map();
    //         uniqueArray.map(e => {
    //             forecastOrdersMap.set(e, e.OrderAmount);
    //             forecastOrdersMap1.set(e.OrderAmount, e.Product);
    //             forecastOrdersMap2.set(e.ForecastPeriod, e.OrderAmount); 
    //             forecastOrdersOu.push({
    //                 Product: e.Product,
    //                 ForecastPeriod: e.ForecastPeriod,
    //                 OrderAmount: e.OrderAmount
    //             })
    //         });
    //         console.log("forecastOrdersMap2", forecastOrdersMap2);
    //         console.log("forecastOrdersMap1", forecastOrdersMap1);

    //             actualPeriods.forEach(e => {
    //                 orderAmount.forEach(el => {
    //                     productNames.forEach(elem => {
    //                     if (
    //                         // forecastOrdersMap2.get(e) !==  undefined &&  finalOrdersMap.get(e) !== undefined &&
    //                         forecastOrdersMap2.get(el) !==  undefined && finalOrdersMap.get(el) !==  undefined &&
    //                         forecastOrdersMap1.get(elem) !==  undefined && finalOrdersMap1.get(elem) !==  undefined &&

    //                         forecastOrdersMap1.get(el) ==  finalOrdersMap1.get(el) &&  //check products step 1
    //                             finalOrdersMap.get(el) == forecastOrdersMap2.get(el)  //check forecast periods
    //                             // forecastOrdersMap2.get(e) == forecastOrdersMap1.get(elem) //check products  step 2
    //                             ) 
    //                             { 
    //                                 MadCalcNew.push({
    //                                 ActualPeriod: finalOrdersMap.get(el),
    //                                 ForecastPeriod: forecastOrdersMap2.get(el),
    //                                 // Product: forecastElements.Product,
    //                                 Product: forecastOrdersMap1.get(el),     //////check !!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //                                 MAD: Math.abs(forecastOrdersMap2.get(e) -  finalOrdersMap.get(e)),
    //                                 MD: forecastOrdersMap2.get(e) - finalOrdersMap.get(e),
    //                                 // MAD: Math.abs(forecastOrdersMap1.get(elem) -  finalOrdersMap1.get(elem)),
    //                                 // MD: forecastOrdersMap1.get(elem) - finalOrdersMap1.get(elem)
    //                                 });
    //                             }
    //                 });
    //                 });
    //             });
    //     });
    //     /*** Remove duplicates from the MadCalcNew array */

    //     let myMadArray = MadCalcNew;
    //     MadCalcNew = Array.from(new Set(myMadArray.map(JSON
    //         .stringify))).map(JSON.parse);
    //         console.log("MadCalcNew", MadCalcNew);

    //     let absValues = [];
    //     let absValuesArray = uniqueArray.map((el) => {
    //         // console.log("el: ", el);
    //         let value = absDiff(el, valueMap.get(el.ForecastPeriod));
    //         let value2 = mdDiff(el, valueMap.get(el.ForecastPeriod));
    //         return {
    //             // ActualDate: el.ActualDate,
    //             // ForecastDate: el.ForecastDate,
    //             ActualPeriod: el.ActualPeriod,
    //             ForecastPeriod: el.ForecastPeriod,
    //             // OrderAmount: el.OrderAmount,
    //             Product: el.Product,
    //             PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
    //             MAD: value,
    //             MD: value2
    //         };
    //     });


    //     let newAbsValuesArray = absValuesArray.filter((el) => {
    //         return !isNaN(el.MAD);
    //     });
    //     // var newSeparatedByPBD = d3.nest()
    //     //     .key(function(d) {
    //     //         return d.PeriodsBeforeDelivery;
    //     //     })
    //     //     .key(function(d) {
    //     //         return d.Product;
    //     //     })
    //     //     .entries(newAbsValuesArray);

    //     var newMadSeparatedByPBD = d3.nest()
    //         .key(function(d) {
    //             return d.PeriodsBeforeDelivery;
    //         })
    //         .key(function(d) {
    //             return d.Product;
    //         })
    //         .entries(MadCalcNew);

    //     console.log("absValuesArray", absValuesArray);

    //     let MADarray = [];
    //     let MADcalc = newMadSeparatedByPBD.map((el) => {
    //         for (var i = 0; i < newMadSeparatedByPBD.length; i++) { //length 29   47
    //             var length1 = el.values;
    //             for (var j = 0; j < el.values.length; j++) { //length 15   4
    //                 for (var k = 0; k < length1[j].values.length -
    //                     1; k++) { //length 76    19
    //                     let meanValue = d3.mean(length1[j].values, function(d) {
    //                         return d.MAD;
    //                     });
    //                     let meanValue5 = d3.mean(length1[j].values, function(d) {
    //                         return d.MD;
    //                     });
    //                     MADarray.push({
    //                         PeriodsBeforeDelivery: el.key,
    //                         Product: length1[j].values[k].Product,
    //                         MAD: meanValue,
    //                         MD: meanValue5
    //                     })
    //                 }
    //             }
    //         }
    //     });

    //     /**** Remove duplicates from the MAD array */
    //     let myNewarray = MADarray;
    //     MADarray = Array.from(new Set(myNewarray.map(JSON
    //         .stringify))).map(JSON.parse);
    //     // console.log("unique array", MADarray);

    //     var exportArray2 = MADarray.map((el) => {
    //         return {
    //             Product: el.Product,
    //             PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
    //             MD: el.MD,
    //             MAD: el.MAD + ' \n'
    //         }
    //     })

    //     //Powered difference values array (needed for RMSE & MSE calculation)
    //     let squaredAbsValuesArray = uniqueArray.map((el) => {
    //         let value = powerDiff(el, valueMap.get(el.ForecastPeriod));
    //         return {
    //             ActualDate: el.ActualDate,
    //             ForecastDate: el.ForecastDate,
    //             ActualPeriod: el.ActualPeriod,
    //             ForecastPeriod: el.ForecastPeriod,
    //             OrderAmount: el.OrderAmount,
    //             Product: el.Product,
    //             PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
    //             SquaredAbsoluteDiff: value
    //         };
    //     });
    //     //Combining two arrays to get values of normalized RMSE
    //     var squaredAbsValuesArray2 = squaredAbsValuesArray.reduce((arr, e) => {
    //         arr.push(Object.assign({}, e, calculationsOrderByPBD.find(a => a
    //             .PeriodsBeforeDelivery == e.PeriodsBeforeDelivery)))
    //         return arr;
    //     }, [])
    //     //Nested array needed for RMSE & MSE calculation
    //     let seperatedByPeriods2 = d3.nest()
    //         .key(function(d) {
    //             return d.PeriodsBeforeDelivery
    //         })
    //         .entries(squaredAbsValuesArray2);

    //     var newSeparatedByPBD2 = d3.nest()
    //         .key(function(d) {
    //             return d.PeriodsBeforeDelivery;
    //         })
    //         .key(function(d) {
    //             return d.Product;
    //         })
    //         .entries(squaredAbsValuesArray2);

    //     let bubu2 = newSeparatedByPBD2.map((el) => {
    //         for (i = 0; i < newSeparatedByPBD2.length; i++) {
    //             let meanValue2 = Math.sqrt(d3.mean(el.values, function(d) {
    //                 return d.SquaredAbsoluteDiff;
    //             }), 2);
    //             let meanValue3 = d3.mean(el.values, function(d) {
    //                 return d.SquaredAbsoluteDiff;
    //             });
    //             let normRMSE = meanValue2 / el.values[i].MeanFinalOrders;
    //             return {
    //                 ActualDate: el.values[i].values[i].ActualDate,
    //                 ForecastDate: el.values[i].values[i].ForecastDate,
    //                 Product: el.values[i].values[i].Product,
    //                 ActualPeriod: el.values[i].values[i].ActualPeriod,
    //                 ForecastPeriod: el.values[i].values[i].ForecastPeriod,
    //                 OrderAmount: el.values[i].values[i].OrderAmount,
    //                 PeriodsBeforeDelivery: el.key,
    //                 MSE: meanValue3,
    //                 NRMSE: normRMSE,
    //                 RMSE: meanValue2
    //             };
    //         }
    //     });

    //     var exportArray3 = bubu2.map((el) => {
    //         return {
    //             Product: el.Product,
    //             PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
    //             RMSE: el.RMSE,
    //             NRMSE: el.NRMSE,
    //             MSE: el.MSE
    //         }
    //     })

    //     /**Combine four export Arrays */
    //     let merged = [];
    //     for (let i = 0; i < exportArray2.length; i++) {
    //         merged.push({
    //             // ...exportArray[i],
    //             ...exportArray2[i]
    //             // ...exportArray3[i],
    //             // ...exportArray4[i]
    //         });
    //     }

    //     /**   Convert array to csv function           */
    //     function pivot(arr) {
    //         var mp = new Map();

    //         function setValue(a, path, val) {
    //             if (Object(val) !== val) { // primitive value
    //                 var pathStr = path.join('.');
    //                 var i = (mp.has(pathStr) ? mp : mp.set(pathStr, mp.size)).get(pathStr);
    //                 a[i] = val;
    //             } else {
    //                 for (var key in val) {
    //                     setValue(a, key == '0' ? path : path.concat(key), val[key]);
    //                 }
    //             }
    //             return a;
    //         }
    //         var result = arr.map(obj => setValue([], [], obj));
    //         return [
    //             [...mp.keys()], ...result
    //         ];
    //     }

    //     function toCsv(arr) {
    //         return arr.map(row =>
    //             row.map(val => isNaN(val) ? JSON.stringify(val) : +val).join(',')
    //         ).join("\n");
    //     }
    //     oneFinalArray = merged.filter((el) => {
    //         return !isNaN(el.MAPE);
    //     });
    //     merged2 = oneFinalArray.filter(function(el) {
    //         return el != "undefined";
    //     });

    //     // function remove_linebreaks_ss(str) {
    //     //     for (var i = 0; i < str.length; i++)
    //     //         if (!(str[i] == '\n' || str[i] == '\r'))
    //     //             filtered += str[i];
    //     //     return merged2;
    //     // }
    //     let newCsvContent = toCsv(pivot(merged2));
    //     let newCsvContent2 = toCsv(pivot(MADarray));

    //     /****     Saving data to localforage: JS object array and CSV export array     * */

    //     localforage.setItem('clustering_data', JSON.stringify(MADarray));
    //     // localforage.setItem('export_data', JSON.stringify(newCsvContent));

    //     /** Export script */
    //     $("#exportFunction").click(function() {
    //         saveFile("All_errorMeasures.csv", "data:attachment/csv", newCsvContent2);
    //     });

    //     /** Function to save file as csv */
    //     function saveFile(name, type, data) {
    //         if (data != null && navigator.msSaveBlob)
    //             return navigator.msSaveBlob(new Blob([data], {
    //                 type: type
    //             }), name);
    //         var a = $("<a style='display: none;'/>");
    //         var url = window.URL.createObjectURL(new Blob([data], {
    //             type: type
    //         }));
    //         a.attr("href", url);
    //         a.attr("download", name);
    //         $("body").append(a);
    //         a[0].click();
    //         window.URL.revokeObjectURL(url);
    //         a.remove();
    //     }
    //     /** End of export function */

    //     newFinalArray2 = bubu2.filter((el) => {
    //         return !isNaN(el.RMSE);
    //     });
    //     newFinalArray2.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });

    //     newFinalArray6 = bubu2.filter((el) => {
    //         return !isNaN(el.MSE);
    //     });
    //     newFinalArray6.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let periodsBD6 = newFinalArray6.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax6 = Math.max(...periodsBD6);

    //     oneFinalArrayNRMSE = bubu2.filter((el) => {
    //         return !isNaN(el.NRMSE);
    //     });
    //     twoFinalArrayNRMSE = oneFinalArrayNRMSE.filter((el) => {
    //         return el.NRMSE !== Infinity;
    //     });
    //     newFinalArray7 = twoFinalArrayNRMSE.filter((el) => {
    //         return el.NRMSE !== 'Infinity';
    //     });
    //     newFinalArray7.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let periodsBD7 = newFinalArray7.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax7 = Math.max(...periodsBD7);

    //     newFinalArray = MADarray.filter((el) => {
    //         return !isNaN(el.MAD);
    //     });
    //     newFinalArray.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let periodsBD = newFinalArray.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax = Math.max(...periodsBD);

    //     let periodsBD2 = newFinalArray2.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax2 = Math.max(...periodsBD2);

    //     newMDArray = MADarray.filter((el) => {
    //         return !isNaN(el.MD);
    //     });
    //     newMDArray.forEach(function(d) {
    //         d.ActualDate = new Date(d.ActualDate);
    //     });
    //     let mdPeriodsBD = newMDArray.map(function(d) {
    //         return d.PeriodsBeforeDelivery
    //     });
    //     let periodsMax8 = Math.max(...mdPeriodsBD);

    // });
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
</body>

</html>