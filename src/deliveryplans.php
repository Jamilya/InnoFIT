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
    <link rel="stylesheet" href="./css/deliveryplans.css">
    <link rel="stylesheet" href="./css/header.css">

    <title>Delivery Plans</title>
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
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li class="dropdown-header">Dashboard</li>
                        <li><a href="./dashboard.php">Dashboard</a></li>
                        <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
                            <li class="active"><a href="./deliveryplans.php">Delivery Plans <span
                                        class="sr-only">(current)</span></a></li>
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
            <div class="col-md-10">
                <h3>Delivery plans</h3>
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
                <p><b>Graph Description: </b>The graph presents the distribution of forecasted and final customer
                    orders with respect to the due date.
            </div>
        </div>

        <div class="row">
            <div id="scatter">
                <div class="clearfix"></div>
            </div>

            <div id="d3Legend"></div>

        </div>
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-3">
                <div id="forecastlist">
                    <p> <strong>Due Date <br /><small>(due date: number of
                                records)</small></strong></p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="forecastWeek">
                    <p style="text-align:left;"><strong>Due date (forecast period) <br /><small>(due date: number of
                                records)</small></strong></p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="productlist">
                    <p><strong>Product<br /><small>(product ID: number of
                                records)</small></strong></p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="pbd">
                    <p><strong>Periods Before Delivery (PBD)<br /><small>(PBD: number of
                                records)</small></strong></p>
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
        let width = window.screen.width / 2;
        let height = result.height;

        localforage.getItem("viz_data", function(error, data) {
            data = JSON.parse(data);

            let finalOrder = data.filter((el) => {
                return el.PeriodsBeforeDelivery == 0;
            });

            var max = d3.max(data, function(d) {
                return d.OrderAmount
            });

            let minDate = d3.min(data, (d) => d.ForecastDate);
            let maxDate = d3.max(data, (d) => d.ForecastDate);

            let minFormat = JSON.stringify(minDate.slice(0, 10));
            let maxFormat = JSON.stringify(maxDate.slice(0, 10));
            let weeksArray = [];

            newMinFormat = new Date(minFormat);
            newMaxFormat = new Date(maxFormat);
            let onejan = new Date(newMinFormat.getFullYear(), 0, 1);
            let twojan = new Date(newMaxFormat.getFullYear(), 0, 1);
            let minWeek = Math.ceil((((newMinFormat - onejan) / 86400000) + onejan.getDay() +
                1) / 7);
            let maxWeek = Math.ceil((((newMaxFormat - twojan) / 86400000) + twojan.getDay() + 1) /
                7);

            var forecastlist = dc.selectMenu("#forecastlist"),
                periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
                visCount = dc.dataCount(".dc-data-count"),
                DeliveryPlansChart = dc.scatterPlot("#scatter"),
                visTable = dc.dataTable(".dc-data-table"),
                productlist = dc.selectMenu("#productlist"),
                forecastWeek = dc.selectMenu("#forecastWeek");

            data.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate),
                    d.ForecastDate = new Date(d.ForecastDate)
            });

            var ndx = crossfilter(data);
            var all = ndx.groupAll();
            var forecastPeriodDim = ndx.dimension(function(d) {
                return +d.ForecastPeriod;
            });
            var forecastDateDim = ndx.dimension(function(d) {
                return +d.ForecastDate;
            });
            var ndxDim = ndx.dimension(function(d) {
                return [+d.ForecastDate, +d.OrderAmount, +d.PeriodsBeforeDelivery, +d.ForecastPeriod, d
                    .ForecastDate
                ];
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
            var forecastDateGroup = forecastDateDim.group();

            const plotColorMap = {
                1: '#cc8800',
                0: '#000099'
            };
            var plotColorMap2 = function(d) {
                if (d.PeriodsBeforeDelivery == 0) return 0;
                else return 1;
            };
            var color = {
                1: "#8d2c4a",
                0: "#fa87ba"
            };

            forecastlist
                .dimension(forecastDateDim)
                .group(forecastDateGroup)
                .multiple(true)
                .numberVisible(15)
                .title(function(d) {
                    return `${new Date(d.key).toDateString()}:${d.value}`;
                });

            forecastWeek
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

            DeliveryPlansChart
                .width(width + margin.left + margin.right)
                .height(height + margin.top + margin.bottom)
                .dimension(ndxDim)
                .symbolSize(10)
                .group(ndxGroup)
                .keyAccessor(function(d) {
                    return d.key[0];
                })
                .valueAccessor(function(d) {
                    return d.key[1];
                })
                .colorAccessor(function(d) {
                    if (d.key[2] == 0) {
                        return 0;
                    } else {
                        return 1;
                    }
                })
                .colors(function(colorKey) {
                    return plotColorMap[colorKey];
                })
                .excludedSize(2)
                .excludedOpacity(0.5)
                // .x(d3.scaleLinear().domain(d3.extent(data, function(d) {
                //     return d.ForecastPeriod
                // })))
                .x(d3.scaleTime().domain(d3.extent(data, function(d) {
                        return d.ForecastDate
                    })).clamp(true).nice()
                    // .range([0, 410])
                )
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Due Date (forecast period)")
                .yAxisLabel("Order Amount (pcs)")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[2],
                        'Order Amount: ' + d.key[1],
                        'Forecast Period: ' + d.key[3],
                        'Forecast Date: ' + new Date(d.key[0]).toDateString()
                    ].join('\n');
                })
                .xAxis().tickFormat(d3.timeFormat("%U"));
            // .xAxis().tickFormat(d3.format('d'));
            DeliveryPlansChart.margins(margin);
            DeliveryPlansChart.symbol(function(d) {
                if (d.key[2] == 0) {
                    return d3.symbolStar;
                } else {
                    return d3.symbolCircle;
                }
            });

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
                    "OrderAmount"
                ]);

            dc.renderAll();

            // Create Legend
            var svg = d3.select("#d3Legend").append('svg').attr('width', 300).attr('height', 35)
            svg.append("path").attr('d', d3.symbol().size(100).type(d3.symbolStar)).style("fill", "#000099")
                .attr("transform", "translate(75,14)")
            svg.append("path").attr("d", d3.symbol().size(100).type(d3.symbolCircle)).style("fill", "#cc8800")
                .attr("transform", "translate(185,14)")

            svg.append("text").attr("x", 90).attr("y", 15).text("Final Order").style("font-size", "15px").attr(
                "alignment-baseline", "middle")
            svg.append("text").attr("x", 200).attr("y", 15).text("Forecast Order").style("font-size", "15px")
                .attr(
                    "alignment-baseline", "middle")
        });
        </script>

        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>

</body>

</html>