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
    <title>Percentage Error</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css" />
    <link rel="stylesheet" href="./css/forecasterror.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="../lib/js/localforage.js"></script>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="../lib/js/crossfilter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-tip/0.7.1/d3-tip.min.js"></script>
    <script src="../lib/js/dc.js"></script>
    <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.24.0/d3-legend.min.js"></script>
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
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz  <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li class="dropdown-header">Dashboard</li>
                        <li><a href="./dashboard.php">Dashboard</a></li>
                        <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li class="active"><a href="./forecasterror.php">Percentage Error <span
                                        class="sr-only">(current)</span></a></li>
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
        </div>
    </nav>
    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-10">
                <h3>Percentage Error</h3>
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
        </div>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 50px;">
                <br />
                <p><b> Graph Description:</b> This graph shows the Information Quality (IQ) representation for each
                    final order with
                    respect to
                    the
                    periods before delivery (PBD). The relative deviation is calculated
                    comparing the forecasted order amounts to the final order amounts with respect to periods before
                    delivery.<br>
                    The formula of the Percentage Error:
                        <img src="../data/img/forecast.png" title="Percentage Error formula" height="56" width="105"/>
                    . </p>
                </p>
            </div>
        </div>

        <div class="row">
            <div id="scatter">
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div id="forecastlist">
                    <br />
                    <p> <strong>Due date <br /><small>(due date: number of records) </small></strong></p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="pbd"><br />
                    <p><strong>Periods Before Delivery (PBD) <br /><small>(PBD: number of records)</small></strong></p>
                </div>
                <div style="clear: both"></div>
            </div>
            <br />
            <div id="d3Legend"></div>
        </div>
        <div class="row" style="margin: 50px 0 50px 0;">
            <div class="dc-data-count">
                There are <span class="filter-count"></span> selected out of <span class="total-count"></span> records | <a class="badge badge-light"
                    href="javascript:dc.filterAll(); dc.renderAll();"> Reset all </a><br />
                <br />
                <button class="btn btn-secondary" onclick="myFunction()"><strong>Show Data table</strong></button>
                <table class="table table-hover dc-data-table" id="myTable" style="display:none">
                </table>
                <br />
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
        const margin = {
            top: 10,
            right: 10,
            bottom: 80,
            left: 80
        };

        const result = getAppropriateDimensions();
        let width = result.width;
        let height = result.height;

        localforage.getItem("viz_data", function(error, data) {
            data = JSON.parse(data);

            let calcDeviation = function(orignalEl, finalOrder) {
                return (orignalEl.OrderAmount - finalOrder) / finalOrder;
            }
            let filterValues = data.filter((el) => {
                return el.PeriodsBeforeDelivery == 0;
            });
            // console.log("Final Orders: ", filterValues);
            let valueMap = new Map();
            filterValues.forEach((val) => {
                let keyString = val.ActualPeriod;
                let valueString = val.OrderAmount;
                valueMap.set(keyString, valueString);
            });
            // console.log("Mapped final order array: ", valueMap);

            let finalArray = data.map((el) => {
                let deviation = calcDeviation(el, valueMap.get(el.ForecastPeriod))
                return {
                    ActualDate: el.ActualDate,
                    ForecastDate: el.ForecastDate,
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    Product: el.Product,
                    FinalOrder: valueMap.get(el.ForecastPeriod),
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    Deviation: deviation.toFixed(2)
                };
            })
            // console.log("FINAL Array with deviation: ", finalArray);
            newFinalArray = finalArray.filter((el) => {
                return !isNaN(el.Deviation);
            })
            isfinitearray = newFinalArray.filter((el) => {
                return isFinite(el.Deviation) == true;
            })
            // console.log("isfinitearray: ", isfinitearray);
            let deviationCalc = d3.values(isfinitearray, function(d) {
                return d.Deviation;
            })
            var deviationMax = d3.max(deviationCalc, function(d) {
                return +d.Deviation;
            });
            var deviationMin = d3.min(deviationCalc, function(d) { //Define minimum  value of Order Amount
                return +d.Deviation;
            });

            var forecastlist = dc.selectMenu("#forecastlist"),
                productChart = dc.selectMenu("#product"),
                periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
                visCount = dc.dataCount(".dc-data-count"),
                forecastErrorChart = dc.scatterPlot("#scatter"),
                visTable = dc.dataTable(".dc-data-table");

            isfinitearray.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });

            var ndx = crossfilter(isfinitearray);
            var all = ndx.groupAll();
            var forecastPeriodDim = ndx.dimension(function(d) {
                return +d.ForecastPeriod;
            });
            var ndxDim = ndx.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.Deviation, +d.ForecastPeriod];
            });
            var productDim = ndx.dimension(function(d) {
                return d.Product;
            });
            var periodsBeforeDeliveryDim = ndx.dimension(function(d) {
                return +d.PeriodsBeforeDelivery;
            });
            var forecastErrorDim = ndx.dimension(function(d) {
                return +d.Deviation;
            });
            var dateDim = ndx.dimension(function(d) {
                return +d.ActualDate;
            });

            var forecastPeriodGroup = forecastPeriodDim.group();
            var productGroup = productDim.group();
            var ndxGroup = ndxDim.group();
            // var group = ndxDim.group();
            // var reducer = reductio()
            //     .exception(function(d) {
            //         return d.PeriodsBeforeDelivery;
            //     })
            //     .exceptionCount(true);
            // reducer(group);

            var forecastErrorGroup = forecastErrorDim.group(function(d) {
                return d.Deviation;
            });
            var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
            var dateGroup = dateDim.group();
            // console.log("ndxDim: ", ndxGroup.top(Infinity));


            forecastlist
                .dimension(forecastPeriodDim)
                .group(forecastPeriodGroup)
                .multiple(true)
                .numberVisible(15);

            productChart
                .dimension(productDim)
                .group(productGroup)
                .multiple(true)
                .numberVisible(15);

            periodsBeforeDeliveryChart
                .dimension(periodsBeforeDeliveryDim)
                .group(periodsBeforeDeliveryGroup)
                .multiple(true)
                .numberVisible(15);
            var plotColorMap = d3.scaleOrdinal(d3.schemeCategory10)
                .domain(d3.extent(isfinitearray, function (d){ return d.ForecastPeriod}));
            let mdPeriodsBD = isfinitearray.map(function(d) {
                return d.PeriodsBeforeDelivery
            });
            let periodsMax = Math.max(...mdPeriodsBD);

            forecastErrorChart
                .width(768 + margin.left + margin.right)
                .height(480 + margin.top + margin.bottom)
                .dimension(ndxDim)
                .symbolSize(10)
                .group(ndxGroup)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return !isNaN(d.key[1]);
                        });
                })
                .colorAccessor(function(d) {
                    return d.key[2];
                })
                // .colors(function(d) {
                //     return plotColorMap(d);
                // })
                .keyAccessor(function(d) {
                    return d.key[0];
                })
                .valueAccessor(function(d) {
                    return d.key[1];
                })
                .x(d3.scaleLinear().domain(d3.extent(isfinitearray, function(d) {
                    return d.PeriodsBeforeDelivery
                })))
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("Deviation")
                .legend(dc.legend().x(790).y(10).itemHeight(20).gap(2))
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'Deviation: ' + d.key[1],
                        'Actual Period: ' + d.key[2]
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.format('d'));
                // .xAxis().tickFormat(d3.format('d'));

            forecastErrorChart.yAxis().tickFormat(d3.format('.0%'));

            forecastErrorChart.symbol(d3.symbolCircle);
            forecastErrorChart.margins(margin);
            forecastErrorChart.legend(dc.legend().legendText("Actual Period").x(770).y(45));

            visCount
                .dimension(ndx)
                .group(all);

            visTable
                .dimension(dateDim)
                .group(function(d) {
                    var format = d3.format('02d');
                    return d.ActualDate.getFullYear() + '/' + format((d.ActualDate.getMonth() +
                        1));
                })
                .columns([
                    "Product",
                    "ActualPeriod",
                    "ForecastPeriod",
                    "PeriodsBeforeDelivery",
                    "OrderAmount",
                    "Deviation"
                ]);
            dc.renderAll();
            const colorScale = d3.scaleOrdinal()
                .range(d3.schemeCategory10);
            const colorLegend = d3.legendColor()
                .scale(colorScale)
                .shape('circle');
            var Deviation = function(d) {
                return d.Deviation === (d.OrderAmount - d.FinalOrder) / d.FinalOrder;
            };
        });
        </script>
        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>

</body>

</html>