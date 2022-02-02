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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css" />
    <link rel="stylesheet" href="./css/cormse.css">
    <link rel="stylesheet" href="./css/header.css">
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
    <script src="./js/util.js"></script>

    <script>
    localforage.config({
        driver: localforage.INDEXEDDB,
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
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
                <a class="navbar-brand" href="/about.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a class="specialLine" href="./configuration.php">Configuration</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Dashboard</li>
                            <li><a href="./dashboard.php">Dashboard</a></li>
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
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
                    <!-- <li><a href="./dashboard.php">Dashboard</a></li> -->
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li class="active"><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) <span
                                        class="sr-only">(current)</span></a></li>
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

    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-6">
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
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 50px;">
                    <br />
                    <p> <b>Graph Description:</b> This graph presents an estimation of CRMSE and RMSE with respect to
                        periods before
                        delivery (PBD).
                        <br> The Formula of the Corrected Root Mean Square Error (CRMSE) is:
                        <!-- <img src="https://latex.codecogs.com/gif.latex?CRMSE_{j} = \sqrt{\frac{1}{n}\sum_{1}^{n}(x_{i,0}-(\frac{x_{i,j}}{MFB_{j}}))^{2}}"
                            title="Corrected RMSE_1" />  -->
                        <img src="../data/img/corr_rmse.gif" title="Corrected RMSE formula" />, <br>
                        where MFB (Mean Forecast Bias) =
                        <!-- <img src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}"
                            title="Mean Forecast Bias formula" /> -->
                        <img src="../data/img/mfb.gif" title="MFB formula" />
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="compositeChart">
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div id="pbd">
                            <p style="text-align:center;"><strong>Periods Before Delivery</strong></p>
                        </div>
                        <div style="clear: both"></div>
                        <div class="row" style="margin: 50px 0 50px 0;">
                            <div class="dc-data-count">
                                <span class="filter-count"></span> selected out of <span
                                    class="total-count"></span>records
                                | <a class="badge badge-light" href="javascript:dc.filterAll(); dc.renderAll();"> Reset
                                    all
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 50px 0 50px 0;">
                        <!-- <div class="dc-data-count">
                            There are <span class="filter-count"></span> selected out of <span
                                class="total-count"></span>
                            records | <a class="badge badge-light" href="javascript:dc.filterAll(); dc.renderAll();">
                                Reset
                                all
                            </a><br />
                            <br /> -->
                            <button class="btn btn-secondary" id="exportFunction"><strong>Export Data</strong></button>
                            <table class="table table-hover dc-data-table" id="myTable" style="display:none">
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
            <script>
            // function myFunction() {
            //     var x = document.getElementById("myTable");
            //     if (x.style.display === "none") {
            //         x.style.display = "block";
            //     } else {
            //         x.style.display = "none";
            //     }
            // }
            // 
            </script>
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
                bottom: 80,
                left: 80
            };

            const result = getAppropriateDimensions();
            let height = result.height - margin.top - margin.bottom;

            const res = getPercentToPixelDimensions(70);
            let width = res.width - margin.left - margin.right;

            localforage.getItem("viz_data", function(error, data) {
                data = JSON.parse(data);

                let finalOrder = data.filter((el) => {
                    return el.PeriodsBeforeDelivery == 0;
                });

                var periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
                    visCount = dc.dataCount(".dc-data-count"),
                    composite = dc.compositeChart("#compositeChart");
                // visTable = dc.dataTable(".dc-data-table");

                let valueMap = new Map();
                finalOrder.forEach((val) => {
                    let keyString = val.ActualDate;
                    let valueString = val.OrderAmount;
                    valueMap.set(keyString, valueString);
                });

                let finalOrdersForecastPeriods = new Map();
                finalOrder.map(e => {
                    finalOrdersForecastPeriods.set(e.ForecastDate, e.OrderAmount);
                });
                ///////              * CRMSE Calc **          /////
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
                let finalOrderForecastPeriods = finalOrder.map(e => e.ForecastDate);

                // Calculate the sum for the Forecasts for each pbd != 0
                let calculationsOrderByPBD = orderByPBD.map((el) => {
                    const uniqueNames = [...new Set(el.values.map(i => i.Product))];
                    let pbdForecasts = el.values.map(e => e.ForecastDate);
                    // ALL valid Forecast Periods for each Period before delivery
                    // Forecast Sums
                    let validForecasts = el.values.filter(e => e.ForecastPeriod <= maxActualPeriod);
                    let validForecasts2 = finalOrderForecastPeriods.filter(value => -1 !== pbdForecasts
                        .indexOf(value));

                    let invalidForecasts = el.values.filter(function(obj) {
                        return validForecasts.indexOf(obj) == -1;
                    });

                    let forecastOrdersForecastPeriods = new Map();
                    validForecasts.map(e => {
                        forecastOrdersForecastPeriods.set(e.ForecastDate, e.OrderAmount);
                    });
                    let sumOfForecasts = validForecasts.reduce((a, b) => +a + +b.OrderAmount, 0);

                    // FinalOrder Sums
                    let items = el.values;
                    let forecastItems = items.map(el => el.ForecastDate);
                    let sumFinalOrders = 0;
                    let forecastSum = 0;

                    let sumFinalOrders2 = 0;
                    let forecastSum2 = 0;
                    // MFB
                    let division = [];
                    let division2 = [];
                    let difference = [];
                    let difference2 = [];

                    forecastItems.forEach(e => {
                        if (finalOrdersForecastPeriods.get(e) !== undefined) {
                            sumFinalOrders += parseInt(finalOrdersForecastPeriods.get(e), 0);
                            forecastSum += parseInt(forecastOrdersForecastPeriods.get(e), 0);
                        }
                    });
                    let mfbValue = forecastSum / sumFinalOrders;

                    // validForecasts2.forEach(e => {
                    //     if (finalOrdersForecastPeriods.get(e) !== undefined) {
                    //         division2.push({
                    //             key: e,
                    //             value: finalOrdersForecastPeriods.get(e) / mfbValue
                    //         });
                    //     }
                    // })
                    validForecasts2.forEach(e => {
                        if (finalOrdersForecastPeriods.get(e) !== undefined) {
                            sumFinalOrders2 += parseInt(finalOrdersForecastPeriods.get(e), 0);
                            forecastSum2 += parseInt(forecastOrdersForecastPeriods.get(e), 0);
                        }
                    });
                    let mfbValue2 = forecastSum2 / sumFinalOrders2;

                    validForecasts2.forEach(e => {
                        if (forecastOrdersForecastPeriods.get(e) !== undefined) {
                            division2.push({
                                key: e,
                                value: forecastOrdersForecastPeriods.get(e) / mfbValue2
                            });
                        }
                    });

                    forecastItems.forEach(e => {
                        if (forecastOrdersForecastPeriods.get(e) !== undefined) {
                            division.push({
                                key: e,
                                value: forecastOrdersForecastPeriods.get(e) / mfbValue
                            });
                        }
                    })
                    divisionCalc = new Map();
                    division.map(e => {
                        divisionCalc.set(e.key, e.value);
                    });

                    divisionCalc2 = new Map();
                    division2.map(e => {
                        divisionCalc2.set(e.key, e.value);
                    });

                    forecastItems.forEach(e => {
                        if (finalOrdersForecastPeriods.get(e) !== undefined) {
                            difference.push(parseInt((finalOrdersForecastPeriods.get(e)) -
                                divisionCalc.get(e)));
                        }
                    })
                    validForecasts2.forEach(e => {
                        if (finalOrdersForecastPeriods.get(e) !== undefined) {
                            difference2.push(parseInt((finalOrdersForecastPeriods.get(e)) -
                                divisionCalc2.get(e)));
                        }
                    })

                    let mathPow = difference.map(x => x ** 2);
                    let mathPow2 = difference2.map(x => x ** 2);

                    let average = d3.mean(mathPow);
                    let average2 = d3.mean(mathPow2);

                    let crmseCalc = Math.sqrt(average);
                    let crmseCalc2 = Math.sqrt(average2);


                    return {
                        PeriodsBeforeDelivery: el.key,
                        Product: uniqueNames,
                        ActualPeriod: el.values[0].ActualPeriod,
                        ForecastPeriod: el.values[0].ForecastPeriod,
                        ActualDate: el.values[0].ActualDate,
                        MFB: mfbValue,
                        CRMSE: crmseCalc,
                        CRMSE2: crmseCalc2
                    }
                });
                console.log('CRMSE: ', calculationsOrderByPBD);
                newFinalArray1 = calculationsOrderByPBD.filter((el) => {
                    return !isNaN(el.CRMSE);
                })

                newFinalArray1.forEach(function(d) {
                    d.ActualDate = new Date(d.ActualDate),
                        d.ForecastDate = new Date(d.ForecastDate)
                });
                let periodsBD = newFinalArray1.map(function(d) {
                    return d.PeriodsBeforeDelivery
                });
                let periodsMax = Math.max(...periodsBD);


                /**    RMSE Calc */ /////////////////////////////////////////////////

                let powerDiff = function(orignalEl, finalOrder) {
                    return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
                }

                let squaredAbsValuesArray = uniqueArray.map((el) => {
                    let value = powerDiff(el, valueMap.get(el.ForecastDate));
                    return {
                        ActualDate: el.ActualDate,
                        PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                        SquaredAbsoluteDiff: value
                    };
                });

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
                            RMSE: RMSE
                        };
                    }
                });
                newFinalArray2 = bebe.filter((el) => {
                    return !isNaN(el.RMSE);
                })



                const mergeById = (newFinalArray1, newFinalArray2) =>
                    newFinalArray1.map(itm => ({
                        ...newFinalArray2.find((item) => (item.PeriodsBeforeDelivery === itm
                            .PeriodsBeforeDelivery) && item),
                        ...itm
                    }));

                console.log("merged array:", mergeById(newFinalArray1, newFinalArray2));
                const exportArray = mergeById(newFinalArray1, newFinalArray2);
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
                    ).join('\n');
                }
                let newCsvContent = toCsv(pivot(exportArray));
                // console.log("newCsvContent array: ", newCsvContent);

                /** Export script */
                $("#exportFunction").click(function() {
                    saveFile("CRMSE-RMSE.csv", "data:attachment/csv", newCsvContent);
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

                newFinalArray2.forEach(function(d) {
                    d.ActualDate = new Date(d.ActualDate),
                        d.ForecastDate = new Date(d.ForecastDate);
                });

                var ndx = crossfilter();
                ndx.add(mergeById(newFinalArray1, newFinalArray2).map(function(d) {
                    return {
                        x: +d.PeriodsBeforeDelivery,
                        y2: 0,
                        y1: d.CRMSE,
                        ActualDate: +d.ActualDate
                    };
                }));
                ndx.add(mergeById(newFinalArray1, newFinalArray2).map(function(d) {
                    return {
                        x: +d.PeriodsBeforeDelivery,
                        y1: 0,
                        y2: d.RMSE,
                        ActualDate: +d.ActualDate
                    };
                }));
                var all = ndx.groupAll();

                var dim = ndx.dimension(dc.pluck('x')),
                    grp1 = dim.group().reduceSum(dc.pluck('y1')),
                    grp2 = dim.group().reduceSum(dc.pluck('y2'));

                var periodsBeforeDeliveryDim = ndx.dimension(dc.pluck('x'));
                var dateDim = ndx.dimension(dc.pluck('ActualDate'));

                var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
                var dateGroup = dateDim.group();


                periodsBeforeDeliveryChart
                    .dimension(periodsBeforeDeliveryDim)
                    .group(periodsBeforeDeliveryGroup)
                    .multiple(true)
                    .numberVisible(15);


                composite
                    .width(width + margin.left + margin.right)
                    .height(height + margin.top + margin.bottom)
                    .x(d3.scaleLinear().domain([0, periodsMax]))
                    .brushOn(false)
                    .clipPadding(10)
                    .xAxisLabel("Periods Before Delivery")
                    .yAxisLabel("CRMSE & RMSE")
                    .legend(dc.legend().x(790).y(10).itemHeight(20).gap(2))
                    .compose([
                        dc.lineChart(composite)
                        .dimension(dim)
                        .group(grp1, 'CRMSE')
                        .colors(['green']),
                        dc.lineChart(composite)
                        .dimension(dim)
                        .group(grp2, 'RMSE')
                        .colors(['blue'])
                        .dashStyle([2, 2])
                    ])
                    .xAxis().ticks(periodsMax).tickFormat(d3.format('d'));
                // .xAxis().tickFormat(d3.format('d'));
                composite.title(function(d) {
                    return ndx.dimension(dc.pluck('ActualDate')) + ' ' + key + '' + value;
                });

                composite.margins(margin);

                visCount
                    .dimension(ndx)
                    .group(all);

                dc.renderAll();


            });
            </script>

            <script src="/lib/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
                integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
                crossorigin="anonymous">
            </script>

</body>

</html>