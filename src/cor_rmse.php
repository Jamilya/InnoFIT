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

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/data//ico/innofit.ico">
    <title>Corrected Root Mean Square Error (RMSE) </title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="../lib/js/localforage.js"></script>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="../lib/js/crossfilter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-tip/0.7.1/d3-tip.min.js"></script>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css" />



    <style>
    body {
        margin: 0px;
        /* font: 12px sans-serif; */
    }

    .dc-chart .axis text {
        font: 11px sans-serif;
    }

    .dc-chart .brush rect.selection {
        fill: #4682b4;
        fill-opacity: .125;
    }

    .dc-chart .symbol {
        stroke: #000;
        stroke-width: 0.5px;
    }


    .domain {
        /* display: none; */
        stroke: #635F5D;
        stroke-width: 1;
    }

    .tick text,
    .legendCells text {
        fill: #635F5D;
        font-size: 11px;
        font-family: sans-serif;
    }

    .axis-label,
    .legend-label {
        fill: #635F5D;
        font-size: 11px;
        font-family: sans-serif;
    }

    /*  .axis path, */
    .axis line {
        fill: none;
        stroke: grey;
        stroke-width: 1;
        shape-rendering: crispEdges;
    }

    .tick line {
        stroke: #C0C0BB;
    }

    .info-container {
        display: inline-block;
        width: calc(100% + -50px);
        vertical-align: middle;
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
                    <li><a href="./configuration.php">Configuration</a></li>
                    <!--  <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li > -->
                    <!-- <li><a href="./about.php">About</a></li>
            <li class><a href="./howto.php">How to Interpret Error Measures </a></li> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./finalorder.php">Final Order Amount</a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans</a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Error Measures</li>
                            <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD)</a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE)</a></li>
                            <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix - With Variance </a></li>
                        </ul>
                    </li>
                    <!-- </ul> -->
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li class="active"><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) <span
                                        class="sr-only">(current)</span></a></li>
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

    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-10">
                <h3>Corrected Root Mean Square Error (CRMSE) and Root Mean Square Error (RMSE) comparison </h3>
                <small>
                    <?php
                echo "You are logged in as: ";
                print_r($_SESSION["session_username"]);
                echo ".";
                ?></small>
                <br>
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
                            <span style="font-size: 12px; vertical-align: middle;" class="alert-info" role="info"> To
                                change settings please visit <a href="./configuration.php">Configuration</a>.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br />
                    <p> <b>Graph Description:</b> This graph presents an estimation of CRMSE and RMSE with respect to
                        periods before
                        delivery (PBD).
                        <br> The Formula of the Corrected Root Mean Square Error (CRMSE) is: <img
                            src="https://latex.codecogs.com/gif.latex?CRMSE_{j} = \sqrt{\frac{1}{n}\sum_{1}^{n}(x_{i,0}-(\frac{x_{i,j}}{MFB_{j}}))^{2}}"
                            title="Corrected RMSE_1" /> , <br>
                        where MFB (Mean Forecast Bias) = <img
                            src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}"
                            title="Mean Forecast Bias formula" /></p>
                </div>
            </div>
            <div class="row">
                <div id="compositeChart">
                    <div class="clearfix"></div>
                </div>

                <div id="pbd">
                    <p style="text-align:center;"><strong>Periods Before Delivery</strong></p>
                    <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
                    <!-- <a class="reset" href="javascript:periodsBeforeDeliveryChart.filterAll(); dc.redrawAll();" style="display: none;">reset</a> -->
                </div>
                <div style="clear: both"></div>


                <div>
                    <div class="dc-data-count">
                        <span class="filter-count"></span> selected out of <span class="total-count"></span>records | <a
                            href="javascript:dc.filterAll(); dc.renderAll();"> Reset all </a>
                    </div><br /><br />
                    <button onclick="myFunction()">Data table display</button>
                    <table class="table table-hover dc-data-table" id="myTable" style="display:none">
                    </table>
                </div>
            </div>
        </div>
        <script>
        function myFunction() {
            var x = document.getElementById("myTable");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
        </script>
        <script>
        $(document).ready(function() {
            if (localStorage.getItem('checkFiltersActive') === 'true') {
                $('#filterInfo').show();
            } else {
                $('#filterInfo').hide();
            }
        });
        localforage.getItem("viz_data", function(error, data) {
            data = JSON.parse(data);

            let finalOrder = data.filter((el) => {
                return el.PeriodsBeforeDelivery == 0;
            });
            const margin = {
                left: 55,
                right: 25,
                top: 20,
                bottom: 30
            };

            var periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
                visCount = dc.dataCount(".dc-data-count"),
                composite = dc.compositeChart("#compositeChart"),
                visTable = dc.dataTable(".dc-data-table");

            // let uniqueArray = data.filter(function(obj) {
            //     return finalOrder.indexOf(obj) == -1;
            // });

            // let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            // console.log('Sum of all final Orders: ', sumOfAllFinalOrders);

            // let dataGroupedByPBD = d3.nest()
            //     .key(function(d) {
            //         return d.PeriodsBeforeDelivery;
            //     })
            //     .entries(uniqueArray);

            // let finalMFB = dataGroupedByPBD.map((val) => {
            //     let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            //     let mfbCurrentPBD = sum / sumOfAllFinalOrders;
            //     return {
            //         ActualPeriod: val.ActualPeriod,
            //         ForecastPeriod: val.ForecastPeriod,
            //         PeriodsBeforeDelivery: val.key,
            //         OrderAmount: JSON.stringify(mfbCurrentPBD)
            //     };
            // });

            // let newValueMap = new Map(); // Map of Mean forecast bias
            // finalMFB.forEach((val) => {
            //     let keyString = val.PeriodsBeforeDelivery;
            //     let valueString = val.OrderAmount;
            //     newValueMap.set(keyString, valueString);
            // });
            // console.log("newValueMap: ", newValueMap.values());


            // let divisionOne = function(uniqueArray, finalMFB) { //Calculate division of forecasted orders
            //     return uniqueArray.OrderAmount / finalMFB;
            // }

            // let divisionArray = uniqueArray.map((el) => {
            //     let divArray = divisionOne(el, newValueMap.get(el.PeriodsBeforeDelivery))
            //     return {
            //         ActualDate: el.ActualDate,
            //         ForecastPeriod: el.ForecastPeriod,
            //         //  OrderAmount: el.OrderAmount,
            //         Product: el.Product,
            //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            //         OrderAmount: divArray
            //     };
            // });
            // console.log("divisionArray: ", divisionArray);


            // let secondValueMap = new Map();
            // divisionArray.forEach((val) => {
            //     let keyString = val.PeriodsBeforeDelivery;
            //     let valueString = val.OrderAmount;
            //     secondValueMap.set(keyString, valueString);
            // });
            // console.log("secondValueMap: ", secondValueMap);


            // let squaredDiff = function(originalEl, divisionArray) {
            //     return Math.pow((originalEl.OrderAmount - divisionArray), 2);
            // }

            // let valueMap = new Map();
            // finalOrder.forEach((val) => {
            //     let keyString = val.ActualPeriod;
            //     let valueString = val.OrderAmount;
            //     valueMap.set(keyString, valueString);
            // });


            // let squaredDifference = divisionArray.map((el) => {
            //     let value = squaredDiff(el, valueMap.get(el.ForecastPeriod));
            //     return {
            //         ActualDate: el.ActualDate,
            //         OrderAmount: el.OrderAmount,
            //         PeriodsBeforeDelivery: (el.PeriodsBeforeDelivery),
            //         SquaredDiff: value
            //     };
            // });
            // console.log("squared Diff: ", squaredDifference);


            // let seperatedByPeriodsTwo = d3.nest()
            //     .key(function(d) {
            //         return d.PeriodsBeforeDelivery
            //     })
            //     .entries(squaredDifference);
            // console.log("seperatedByPeriodsTwo: ", seperatedByPeriodsTwo);

            // let bubu = seperatedByPeriodsTwo.map((el) => {
            //     for (i = 0; i < seperatedByPeriodsTwo.length; i++) {
            //         let CRMSE = Math.sqrt(d3.mean(el.values, function(d) {
            //             return d.SquaredDiff;
            //         }), 2);
            //         return {
            //             ActualDate: el.values[i].ActualDate,
            //             PeriodsBeforeDelivery: el.key,
            //             MeanOfThisPeriod: CRMSE.toFixed(3)
            //         };
            //     }
            // });
            // console.log("final CRMSE Array: ", bubu);
            // bubu.forEach(function(d) {
            //     d.ActualDate = new Date(d.ActualDate);
            // });

            //MFB calculation

            let finalOrdersForecastPeriods = new Map();
            finalOrder.map(e => {
                finalOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
            });
            console.log('FINAL ORDER MAP: ', finalOrdersForecastPeriods);

            //Order All data by PBD
            // Order the Final Orders

            // PBD != 0 means all Others or Forecast Orders
            let uniqueArray = data.filter(function(obj) {
                return finalOrder.indexOf(obj) == -1;
            });
            //Find the max number of Actual periods in Final orders array
            let maxActualPeriod = Math.max.apply(Math, finalOrder.map(function(o) {
                return o.ActualPeriod;
            }))
            console.log('maxActualPeriod: ', maxActualPeriod);

            // Order the Products by PBD in order to calculate sum of Forecasts and FinalOrders
            let orderByPBD = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery;
                })
                .entries(uniqueArray);

            // Calculate the sum for the Forecasts for each pbd != 0
            let calculationsOrderByPBD = orderByPBD.map((el) => {
                const uniqueNames = [...new Set(el.values.map(i => i.Product))];

                // Forecast Sums
                let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);
                let invalidForecasts = el.values.filter(function(obj) {
                    return validForecasts.indexOf(obj) == -1;
                });

                let forecastOrdersForecastPeriods = new Map();
                validForecasts.map(e => {
                    forecastOrdersForecastPeriods.set(e.ForecastPeriod, e.OrderAmount);
                });
                let sumOfForecasts = validForecasts.reduce((a, b) => +a + +b.OrderAmount, 0);

                // FinalOrder Sums
                let items = el.values;
                let forecastItems = items.map(el => el.ForecastPeriod);
                let sumFinalOrders = 0;
                // MFB

                forecastItems.forEach(e => {
                    if (finalOrdersForecastPeriods.get(e) !== undefined) {
                        sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                    }
                });
                console.log('items: ', items);
                let mfbValue = sumOfForecasts / sumFinalOrders;

                let calcByPBD = items.map(el => el.PeriodsBeforeDelivery);
                let division = [];
                calcByPBD.forEach(e => {
                    division.push(Math.pow(finalOrdersForecastPeriods.get(e) - (
                        forecastOrdersForecastPeriods.get(e) / mfbValue)), 2);
                })

                console.log('calcByPBD: ', calcByPBD);

                return {
                    PeriodsBeforeDelivery: el.key,
                    Product: uniqueNames,
                    ActualPeriod: el.values[0].ActualPeriod,
                    ForecastPeriod: el.values[0].ForecastPeriod,
                    ActualDate: el.values[0].ActualDate,
                    MFB: mfbValue.toFixed(3),
                    CRMSE: Math.sqrt(d3.mean(division))
                }
            });
            console.log('Forecast, FinalOrders, MFB, CRMSE all orderByPBD: ', calculationsOrderByPBD);

            calculationsOrderByPBD.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });


            /**    RMSE Calc */ ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            let powerDiff = function(orignalEl, finalOrder) {
                return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
            }


            let squaredAbsValuesArray = uniqueArray.map((el) => {
                let value = powerDiff(el, valueMap.get(el.ActualPeriod));
                return {
                    ActualDate: el.ActualDate,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    SquaredAbsoluteDiff: value
                };
            });
            // console.log("squaredAbsValuesArray:", squaredAbsValuesArray);

            let seperatedByPeriods2 = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery
                })
                .entries(squaredAbsValuesArray);

            let bebe = seperatedByPeriods2.map((el) => {
                for (i = 0; i < seperatedByPeriods2.length; i++) {
                    let RMSE = Math.sqrt(d3.mean(el.values, function(d) {
                        return d.SquaredAbsoluteDiff;
                    }), 2);
                    return {
                        ActualDate: el.values[i].ActualDate,
                        PeriodsBeforeDelivery: el.key,
                        MeanOfThisPeriod2: RMSE
                    };
                }
            });
            console.log("bebe:", bebe);



            const mergeById = (bubu, bebe) =>
                bubu.map(itm => ({
                    ...bebe.find((item) => (item.PeriodsBeforeDelivery === itm
                        .PeriodsBeforeDelivery) && item),
                    ...itm
                }));

            console.log("merged array:", mergeById(bubu, bebe));

            bebe.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });


            // const yMax = Math.max.apply(Math,mergeById(bubu, bebe).map(function(o){return o.MeanOfThisPeriod;}))
            // var yMax = function(arr) {
            //     return arr.reduce(
            //         function(acc, cur) {
            //             var max = Math.max(acc, cur)
            //             if (isNaN(max)) {
            //                 return (isNaN(max) ? acc : max);
            //             }
            //             return max;
            //         });
            // }
            // console.log(yMax(mergeById(bubu, bebe)));

            // var dataMax = mergeById(bubu, bebe).reduce(function(prev, current) {
            //     return (prev.MeanOfThisPeriod > current.MeanOfThisPeriod) ? prev
            //         .MeanOfThisPeriod2 : current
            //         .MeanOfThisPeriod2
            // });
            // console.log("dataMax", dataMax);

            var ndx = crossfilter(mergeById(bubu, bebe));
            var all = ndx.groupAll();
            var CRMSEDim = ndx.dimension(function(d) {
                return +d.MeanOfThisPeriod;
            });
            var RMSEDim = ndx.dimension(function(d) {
                return +d.MeanOfThisPeriod2;
            })
            var ndxDim = ndx.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MeanOfThisPeriod2, +d.MeanOfThisPeriod];
            });

            var periodsBeforeDeliveryDim = ndx.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var dateDim = ndx.dimension(function(d) {
                return +d.ActualDate;
            });

            var CRMSEGroup = CRMSEDim.group().reduceSum(function(d) {
                return d.MeanOfThisPeriod2;
            });
            var RMSEGroup = RMSEDim.group().reduceSum(function(d) {
                return d.MeanOfThisPeriod;
            });
            var ndxGroup = ndxDim.group();
            var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
            var dateGroup = dateDim.group();


            periodsBeforeDeliveryChart
                .dimension(periodsBeforeDeliveryDim)
                .group(periodsBeforeDeliveryGroup)
                .multiple(true)
                .numberVisible(15);

            // console.log("ndxDim: ", ndxGroup.top(Infinity));

            composite
                .width(768)
                .height(480)
                .dimension(ndxDim)
                .x(d3.scaleLinear().domain(d3.extent(mergeById(bubu, bebe), function(d) {
                    return d.PeriodsBeforeDelivery
                })))
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("CRMSE & RMSE")
                // .renderHorizontalGridLines(true)
                .legend(dc.legend().x(720).y(10).itemHeight(20).gap(2))
                .compose([
                    dc.scatterPlot(composite)
                    .dimension(ndxDim)
                    .group(ndxGroup)
                    .colors('green')
                    .keyAccessor(function(d) {
                        return d.key[0];
                    })
                    .valueAccessor(function(d) {
                        return d.key[1];
                    }),

                    dc.scatterPlot(composite)
                    .dimension(ndxDim)
                    .group(ndxGroup)
                    .colors('blue')
                    .keyAccessor(function(d) {
                        return d.key[0];
                    })
                    .valueAccessor(function(d) {
                        return d.key[2];
                    })
                ]);
            composite.selectAll('path.symbol')
                .attr('opacity', 0.3);

            composite.margins().left = 50;

            visCount
                .dimension(ndx)
                .group(all);

            visTable
                .dimension(dateDim)
                .group(function(d) {
                    var format = d3.format('02d');
                    return d.ActualDate.getFullYear() + '/' + format((d.ActualDate.getMonth() + 1));
                })
                .columns([
                    "PeriodsBeforeDelivery",
                    "MeanOfThisPeriod",
                    "MeanOfThisPeriod2"
                ]);

            dc.renderAll();




            var svg = d3.select("#new_legend")
            svg.append("circle").attr("cx", 70).attr("cy", 15).attr("r", 6).style("fill", "red")
            svg.append("circle").attr("cx", 180).attr("cy", 15).attr("r", 6).style("fill",
                "green")

            //svg.append("circle").attr("cx",200).attr("cy",160).attr("r", 6).style("fill", "#404080")
            svg.append("text").attr("x", 90).attr("y", 15).text("CRMSE").style("font-size",
                "15px").attr(
                "alignment-baseline", "middle")
            svg.append("text").attr("x", 200).attr("y", 15).text("RMSE").style("font-size",
                "15px").attr(
                "alignment-baseline", "middle")


        });
        </script>

        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>

</body>

</html>