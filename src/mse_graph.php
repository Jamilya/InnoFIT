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
    <link rel="stylesheet" href="./css/msegraph.css">
    <link rel="stylesheet" href="./css/header.css">

    <title>Mean Squared Error</title>
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
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Dashboard</li>
                            <li><a href="./dashboard.php">Dashboard</a></li>
                            <li role="separator" class="divider"></li>
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
                            <li class="active"> <a href="./mse_graph.php">Mean Square Error (MSE) <span
                                        class="sr-only">(current)</span></a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE) </a></li>
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
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-6">
                <h3>Mean Squared Error (MSE) Graph</h3>
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
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 50px;">
                <br />
                <p> <b>Graph Description:</b> This graph shows the average squared difference between forecasted and
                    final
                    customer orders with respect to periods before delivery (PBD). <br>
                    Mean Squared Error (the mean/average of the squared errors) measures the quality of an
                    estimation (zero
                    meaning perfect accuracy). <br>
                    The Formula of the Mean Squared Error (MSE) is:
                    <!-- <img src="https://latex.codecogs.com/gif.latex?MSE_{j} = \frac{1}{n}\sum_{i=1}^{n}(x_{i,j}-x_{i,0})^{2}"
                        title="MSE formula" /> -->
                    <img src="../data/img/mse.gif" title="MSE formula" />
                    . Note MSE values: M = millions, K = thousands </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="scatter">
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div id="pbd">
                    <p style="text-align:center;"><strong>Periods Before Delivery (PBD)<br /><small>(PBD: number of
                                records)
                            </small></strong></p>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="row" style="margin: 50px 0 50px 0;">
            <div class="dc-data-count">
                There are <span class="filter-count"></span> selected out of <span class="total-count"></span> records |
                <a class="badge badge-light" href="javascript:dc.filterAll(); dc.renderAll();"> Reset all </a><br />
                <br />
                <button class="btn btn-secondary" onclick="myFunction()"><strong>Show Data table</strong></button>
                <button class="btn btn-secondary" id="exportFunction"><strong>Export Data</strong></button>
                <table class="table table-hover dc-data-table" id="myTable" style="display:none">
                </table>
                <br />
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
    let width = result.width;
    let height = result.height;

    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);
        const uniqueNames = [...new Set(data.map(i => i.Product))];

        let finalOrder = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
        });

        var forecastlist = dc.selectMenu("#forecastlist"),
            periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
            visCount = dc.dataCount(".dc-data-count"),
            MSEchart = dc.scatterPlot("#scatter"),
            visTable = dc.dataTable(".dc-data-table"),
            productlist = dc.selectMenu("#productlist");


        let absDiff = function(orignalEl, finalOrder) {
            return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
        }

        // console.log("FINAL ORDERS: ", finalOrder);

        let uniqueArray = data.filter(function(obj) {
            return finalOrder.indexOf(obj) == -1;
        });
        // console.log("Unique array: ", uniqueArray);

        let valueMap = new Map();
        finalOrder.forEach((val) => {
            let keyString = val.ActualDate; // actual period changed to actual date
            let valueString = val.OrderAmount;
            valueMap.set(keyString, valueString);
        });
        // console.log("valueMap: ", valueMap);

        let absValuesArray = uniqueArray.map((el) => {
            let value = absDiff(el, valueMap.get(el.ForecastDate)); //changed to forecastdate
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
        // console.log("Absolute values: ", absValuesArray);

        let seperatedByPeriods = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery
            })
            .entries(absValuesArray);
        // console.log("seperatedByPeriods: ", seperatedByPeriods);

        let bubu = seperatedByPeriods.map((el) => {
            for (i = 0; i < seperatedByPeriods.length; i++) {
                let meanValue = d3.mean(el.values, function(d) {
                    return d.AbsoluteDiff;
                });
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: uniqueNames,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    MSE: meanValue
                };
            }
        });

        firstFinalArray = bubu.filter((el) => {
            return !isNaN(el.MSE);
        })
        twoFinalArrayMSE = firstFinalArray.filter((el) => {
            return el.MSE !== Infinity;
        })
        newFinalArray = twoFinalArrayMSE.filter((el) => {
            return el.MSE !== 'Infinity';
        })
        var exportArray = newFinalArray.map((el) => {
            return {
                Product: el.Product,
                PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                MSE: el.MSE + "\n"
            }
        })

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
            saveFile("MSE.csv", "data:attachment/csv", newCsvContent);
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


        newFinalArray.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });
        let periodsBD = newFinalArray.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMax = Math.max(...periodsBD);

        var ndx = crossfilter(newFinalArray);
        var all = ndx.groupAll();
        var forecastPeriodDim = ndx.dimension(function(d) {
            return +d.ForecastPeriod;
        });
        var ndxDim = ndx.dimension(function(d) {
            return [+d.PeriodsBeforeDelivery, +d.MSE, +d.Product];
        });
        var productDim = ndx.dimension(function(d) {
            return d.Product;
        });
        var periodsBeforeDeliveryDim = ndx.dimension(function(d) {
            return +d.PeriodsBeforeDelivery;
        });
        var dateDim = ndx.dimension(function(d) {
            return +d.ActualDate;
        });

        var forecastPeriodGroup = forecastPeriodDim.group();
        var productGroup = productDim.group();
        var ndxGroup = ndxDim.group();

        var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
        var dateGroup = dateDim.group();

        forecastlist
            .dimension(forecastPeriodDim)
            .group(forecastPeriodGroup)
            .multiple(true)
            .numberVisible(15);

        productlist
            .dimension(productDim)
            .group(productGroup)
            .multiple(true)
            .numberVisible(15);

        periodsBeforeDeliveryChart
            .dimension(periodsBeforeDeliveryDim)
            .group(periodsBeforeDeliveryGroup)
            .multiple(true)
            .numberVisible(15);

        // console.log("ndxDim: ", ndxGroup.top(Infinity));

        MSEchart
            .width(width + margin.left + margin.right)
            .height(height + margin.top + margin.bottom)
            .dimension(ndxDim)
            .symbolSize(10)
            .group(ndxGroup)
            .data(function(group) {
                return group.all()
                    .filter(function(d) {
                        return d.key !== NaN;
                    });
            })
            .excludedSize(2)
            .excludedOpacity(0.5)
            .x(d3.scaleLinear().domain([0, periodsMax]))
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
        // .xAxis().tickFormat(d3.format('d'));

        MSEchart.yAxis().tickFormat(d3.format(".2s"));
        // console.log('ndxgroup data:', ndxDim);


        MSEchart.selectAll('path.symbol')
            .attr('opacity', 0.3);
        MSEchart.margins(margin);

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
                "Product",
                "PeriodsBeforeDelivery",
                "MSE"
            ]);

        dc.renderAll();

        // var maxLabel = d3.max(isfinitearray, function(d) {
        //         return d.MSE;
        //     }),
        //     maxWidth;
    });
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>


</body>

</html>