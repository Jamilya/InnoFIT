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
    <title>Final Order Amount</title>
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
    }

    .dc-chart .axis text {
        font: 12px sans-serif;
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
        font-size: 12px;
        font-family: sans-serif;
    }

    .axis-label,
    .legend-label {
        fill: #635F5D;
        font-size: 11px;
        font-family: sans-serif;
    }

    .axis line {
        fill: none;
        stroke: grey;
        stroke-width: 1;
        shape-rendering: crispEdges;
    }

    .tick line {
        stroke: #C0C0BB;
    }

    div {
        padding-right: 10px;
        padding-left: 10px;
    }

    .info-container {
        display: inline-block;
        width: calc(100% + -50px);
        vertical-align: middle;
    }

    .customContainer {
        padding: 0 3% 0 3%;
    }

    #selections_table {
        border-collapse: collapse;
    }

    #selections_table td,
    th {
        border: 1px solid black;
    }

    a.gflag {
        vertical-align: middle;
        font-size: 12px;
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
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Corrections <span class="caret"></span> </a>
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
                <h3>Final Order Amount</h3>
                <small>
                    <?php
        echo "You are logged in as: ";
        print_r($_SESSION["session_username"]);
        echo ".";
        ?></small>
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
            <div class="col-md-12">
                <br />
                <p> <b>Graph Description: </b>The graph presents the distribution of final orders (FO) with respect to
                    the due date.
                    The <font color="green"> green-coloured </font> line
                    is the average (mean) value of all final orders. <br> Additionally, the calculations of several
                    statistical
                    measures are shown in the table on the right.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div id="scatter">
                    <div class="clearfix"></div>
                </div>
                <div id="forecastlist">
                    <br />
                    <p style="text-align:left;"><strong>Due Date <br /><small>(due date: no. of
                                records)</small></strong></p>
                    <div class="clearfix"></div>
                </div>
                <div id="forecastWeek">
                    <br />
                    <p style="text-align:left;"><strong>Due date (forecast period) <br /><small>(due date: no. of
                                records)</small></strong></p>
                    <div class="clearfix"></div>
                </div>
                <div id="select1"><br />
                    <p style="text-align:left;"><strong>Product<br /><small>(product ID: no. of
                                records)</small></strong></p>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="col-md-4">
                <br />Statistical measures:<br />
                <div id="selections_table"></div>
                <br /><br />
                <script>
                $(document).ready(function() {
                    if (localStorage.getItem('checkFiltersActive') === 'true') {
                        $('#filterInfo').show();
                    } else {
                        $('#filterInfo').hide();
                    }
                });
                // The table generation function
                function tabulate(data, columns) {
                    var table = d3.select('#selections_table').append('selections_table')
                    var thead = table.append('thead')
                    var tbody = table.append('tbody');
                    thead.append('tr')
                        .selectAll('th')
                        .data(columns).enter()
                        .append('th')
                        .text(function(column) {
                            return column;
                        });
                    var rows = tbody.selectAll('tr')
                        .data(data)
                        .enter()
                        .append('tr');
                    var cells = rows.selectAll('td')
                        .data(function(row) {
                            return columns.map(function(column) {
                                return {
                                    column: column,
                                    value: row[column]
                                };
                            });
                        })
                        .enter()
                        .append('td')
                        .text(function(d) {
                            return d.value;
                        });
                    return table;
                }


                function generateDescObject(desc, value) {
                    const obj = {};
                    obj['Description'] = desc;
                    obj['Value'] = value;
                    return obj;
                }
                var valuesToPrint = [];
                </script>
            </div>
        </div>
        <div id="d3Legend"></div>

        <div class="dc-data-count">
            <span class="filter-count"></span> selected out of <span class="total-count"></span>records | <a
                href="javascript:dc.filterAll(); dc.renderAll();"> Reset all </a><br />

            <br />
            <button onclick="myFunction()">Data table display</button>
            <table class="table table-hover dc-data-table" id="newTable" style="display:none">
            </table>
            <br />

        </div>
        <script>
        function myFunction() {
            var x = document.getElementById("newTable");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
        </script>
        <script>
        const margin = {
            top: 10,
            right: 10,
            bottom: 80,
            left: 80
        };

        localforage.getItem("viz_data", function(error, data) {
            data = JSON.parse(data);

            const width = "790";
            const lineWidth = "410";

            let finalOrder = data.filter((el) => {
                //  return el.PeriodsBeforeDelivery==0;
                return el.PeriodsBeforeDelivery == 0 && el.PeriodsBeforeDelivery == "0";
            });

            // Order Ascending
            finalOrder = finalOrder.sort((a, b) => {
                return d3.ascending(a.ForecastDate, b.ForecastDate);
            });



            let finalOrderCalc = d3.values(finalOrder, function(d) {
                return d.OrderAmount;
            })

            var dataMean = d3.mean(finalOrderCalc, function(
                d) {
                return +d.OrderAmount;
            });
            console.log("Mean Value: ", dataMean);

            var dataMedian = d3.median(finalOrderCalc, function(
                d) {
                return +d.OrderAmount;
            });
            var dataMax = d3.max(finalOrderCalc, function(d) {
                return +d.OrderAmount;
            });
            var dataMin = d3.min(finalOrderCalc, function(d) { //Define minimum  value of Order Amount
                return +d.OrderAmount;
            });
            var dataQuantile1 = d3.quantile(finalOrder, 0.99, function(d) {
                return d.OrderAmount;
            });
            var dataQuantile2 = d3.quantile(finalOrder, 0.95, function(d) {
                return d.OrderAmount;
            });
            var dataQuantile3 = d3.quantile(finalOrder, 0.75, function(d) {
                return d.OrderAmount;
            });
            var dataMaxPer = d3.max(finalOrder, function(d) {
                return d.ActualPeriod;
            });
            var standardDev = d3.deviation(finalOrder, function(
                d) { //Define a standard deviation variable
                return d.OrderAmount;
            });
            var varKo = standardDev / dataMean;
            var roundVarKo = varKo.toFixed(2);

            valuesToPrint.push(generateDescObject('Mean Value: ', dataMean.toFixed(2) + " "));
            valuesToPrint.push(generateDescObject('Median Value: ', dataMedian + " "));
            valuesToPrint.push(generateDescObject('Min Value: ', dataMin + "      "));
            valuesToPrint.push(generateDescObject('Max Value: ', dataMax + "      "));
            valuesToPrint.push(generateDescObject('99% Quantile: ', dataQuantile1.toFixed(2) + '  '));
            valuesToPrint.push(generateDescObject('95% Quantile: ', dataQuantile2.toFixed(2) + '  '));
            valuesToPrint.push(generateDescObject('75% Quantile: ', dataQuantile3.toFixed(2) + '  '));
            valuesToPrint.push(generateDescObject('Max Period', dataMaxPer + " "));
            valuesToPrint.push(generateDescObject('Var. Ko.:: ', roundVarKo + " "));
            valuesToPrint.push(generateDescObject('St. Dev.: ', standardDev.toFixed(2), 1));
            var forecastlist = dc.selectMenu("#forecastlist"),
                visCount = dc.dataCount(".dc-data-count"),
                FinalOrderChart = dc.scatterPlot("#scatter"),
                visTable = dc.dataTable(".dc-data-table"),
                select1 = dc.selectMenu("#select1"),
                forecastWeek = dc.selectMenu("#forecastWeek");

            let minDate = d3.min(finalOrder, (d) => d.ForecastDate);
            let maxDate = d3.max(finalOrder, (d) => d.ForecastDate);

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

            weeksArray.push(minWeek);
            weeksArray.push(maxWeek);

            finalOrder.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate),
                    d.ForecastDate = new Date(d.ForecastDate)
            });
            console.log("finalOrder: ", finalOrder);
            console.log("weeksArray: ", weeksArray);


            var ndx = crossfilter(finalOrder);
            var all = ndx.groupAll();
            var actualPeriodDim = ndx.dimension(function(d) {
                return +d.ActualPeriod;
            });
            var forecastPeriodDim = ndx.dimension(function(d) {
                return +d.ForecastPeriod;
            });
            var forecastDateDim = ndx.dimension(function(d) {
                return +d.ForecastDate;
            });

            var ndxDim = ndx.dimension(function(d) {
                return [+d.ForecastDate, +d.OrderAmount, d.Product, +d.ForecastPeriod, d.ForecastDate];
            });
            var productDim = ndx.dimension(function(d) {
                return d.Product;
            });
            var dateDim = ndx.dimension(function(d) {
                return +d.ActualDate;
            });
            var plotColorMap = d3.scaleOrdinal(d3.schemeCategory10);

            var actualPeriodGroup = actualPeriodDim.group();
            var productGroup = productDim.group();
            var ndxGroup = ndxDim.group();
            var forecastPeriodGroup = forecastPeriodDim.group();
            var forecastDateGroup = forecastDateDim.group();
            var dateGroup = dateDim.group();

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

            select1
                .dimension(productDim)
                .group(productGroup)
                .multiple(true);

            console.log("ndxDim: ", ndxGroup.top(Infinity));

            FinalOrderChart
                .width(700 + margin.left + margin.right)
                .height(410 + margin.top + margin.bottom)
                .symbolSize(10)
                .group(ndxGroup)
                // .data(function(group) {
                //     return group.all()
                //         .sort(function(a) {
                //             return d3.ascending(a.ForecastDate);
                //         });
                // })
                .dimension(ndxDim)
                .colorAccessor(function(d) {
                    return d.key[2];
                })
                .colors(function(colorKey) {
                    return plotColorMap(colorKey);
                })
                .keyAccessor(function(d) {
                    return d.key[0];
                })
                .valueAccessor(function(d) {
                    return d.key[1];
                })
                .excludedSize(2)
                .excludedOpacity(0.5)
                // .x(d3.scaleLinear().domain([minWeek, maxWeek]))
                .x(d3.scaleTime().domain(d3.extent(finalOrder, function(d) {
                        return d.ForecastDate
                    }))
                    .range([0, 410])
                )
                .brushOn(false)
                .clipPadding(10)
                .xAxisLabel("Due Date (forecast period)")
                .yAxisLabel("Order Amount (pcs)")
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Product: ' + d.key[2],
                        'Order Amount: ' + d.key[1],
                        'Forecast Period: ' + d.key[3],
                        'Forecast Date: ' + new Date(d.key[0]).toDateString()
                    ].join('\n');
                })
                // .elasticY(true)
                // .elasticX(true)

                .on('renderlet', function(FinalOrderChart) {
                    var x_vert = width;
                    var extra_data = [{
                            x: 47,
                            y: FinalOrderChart.y()(dataMean)
                        },
                        {
                            x: x_vert,
                            y: FinalOrderChart.y()(dataMean)
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
                    var chartBody = FinalOrderChart.select('g');
                    var path = chartBody.selectAll('path.extra').data([extra_data]);
                    path = path.enter()
                        .append('path')
                        .attr('class', 'oeExtra')
                        .attr('stroke', 'green')
                        .attr('id', 'oeLine')
                        .attr("stroke-width", 1)
                        .style("stroke-dasharray", ("10,3"))
                        .merge(path);
                    path.attr('d', line);
                })
                // .xAxis().tickFormat(d3.format('d'));
                .xAxis().tickFormat(d3.timeFormat("%V"));

            FinalOrderChart.symbol(d3.symbolCircle);
            FinalOrderChart.margins(margin);

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
                    "ActualPeriod",
                    "ForecastPeriod",
                    "PeriodsBeforeDelivery",
                    "OrderAmount"
                ]);

            dc.renderAll();

            // Create Legend
            // var svg = d3.select("#d3Legend").append('svg').attr('width', 300).attr('height', 35)
            // svg.append("path").attr('d', d3.symbol().size(100).type(d3.symbolCircle)).style("fill", "#1f77b4")
            //     .attr("transform", "translate(75,14)")
            // svg.append("path").attr("d", d3.symbol().size(100).type(d3.symbolCircle)).style("fill",
            //         "#9467bd")
            //     .attr("transform", "translate(185,14)")
            // svg.append("text").attr("x", 90).attr("y", 15).text("Product ID1").style("font-size", "15px")
            //     .attr("alignment-baseline", "middle")
            // svg.append("text").attr("x", 200).attr("y", 15).text("Product ID2").style("font-size",
            //         "15px")
            //     .attr("alignment-baseline", "middle")

            tabulate(valuesToPrint, ['Description', 'Value']);

            console.log("DataMin: ", dataMin);
            console.log("DataMax: ", dataMax);
            console.log("Standard Deviation: ", standardDev, 1);
            console.log("Var Ko : ", varKo);

        });
        </script>


        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>


</body>

</html>