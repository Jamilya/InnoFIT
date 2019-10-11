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
    <title>Mean Forecast Bias</title>
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
        font-size: 12px;
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
                    <li><a href="./about.php">About</a></li>
                    <li class><a href="./howto.php">How to Interpret Error Measures </a></li>
                    <li class="dropdown active">
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
                            <li class="active"><a href="./meanforecastbias.php">Mean Forecast Bias (MFB) <span
                                        class="sr-only">(current)</span></a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix - With Variance </a></li>
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

    <div style="padding-left:39px">

        <h3>Mean Forecast Bias</h3>
        <small>
            <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
        <br>

        <br>
        <p> <b>Graph Description:</b> This graph shows the calculation of the Mean Forecast Bias, which is the
            description of the forecast error with respect to periods before delivery (PBD).
            <br> The <font color="orange"> orange-coloured line </font> is the average (mean) value of forecast bias
            values.
            <br>The formula of the Mean Forecast Bias is: <img
                src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}"
                title="Mean Forecast Bias formula" />. </p>

    </div>
    <div style="padding-left:39px">
        <div id="scatter">
            <!-- <p style="text-align:center;"><strong>MFB graph</strong></p> -->
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <!-- <a class="reset" href="javascript:MFBchart.filterAll(); dc.redrawAll();" style="display: none;">reset</a> -->
            <div class="clearfix"></div>
        </div>

        <!-- <div id="forecastlist">
            <p style="text-align:center;"><strong>Due date </strong></p>
            <div class="clearfix"></div>
        </div>

        <div id="productlist">
            <p style="text-align:center;"><strong>Product</strong></p>
            <div class="clearfix"></div>
        </div> -->

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
    var forecastlist = dc.selectMenu("#forecastlist"),
        // productChart = dc.pieChart("#product"),
        periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
        visCount = dc.dataCount(".dc-data-count"),
        MFBchart = dc.scatterPlot("#scatter"),
        visTable = dc.dataTable(".dc-data-table"),
        productlist = dc.selectMenu("#productlist");
    const margin = {
        left: 55,
        right: 25,
        top: 20,
        bottom: 30
    };

    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);

        let finalOrder = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
        });


        let uniqueArray = data.filter(function(obj) {
            return finalOrder.indexOf(obj) == -1;
        });

        let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +
            b);

        let dataGroupedByPBD = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery;
            })
            .entries(uniqueArray);

        let finalDataGroupedByPBD = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery;
            })
            .entries(finalOrder);
        

        let bubu = dataGroupedByPBD.map((el) => {
            for (i = 0; i < dataGroupedByPBD.length; i++) {
                let sum = el.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: el.values[i].Product,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    SumOfForecast: sum
                };
            }
        });
        let finalSumCalc = finalDataGroupedByPBD.map((val) => {
            let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            return {
                PeriodsBeforeDelivery: val.key,
                FinalOrderSum: sum
            };
        });
        console.log('Final orders sum calc: ', finalSumCalc);
        console.log('Sum of all final orders: ', sumOfAllFinalOrders);

        let finalForecastBias = bubu.map((el) => {
            for (i = 0; i < dataGroupedByPBD.length; i++) {
                let finalForecastBiasPBD = el.SumOfForecast / sumOfAllFinalOrders;
                return {
                    ActualDate: el.ActualDate,
                    ForecastDate: el.ForecastDate,
                    Product: el.Product,
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    MFB: finalForecastBiasPBD.toFixed(3)
                };
            }
        });
        console.log('Final mfb: ', finalForecastBias);

        finalForecastBias.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });

        var dataMean = d3.mean(finalForecastBias, function(
            d) { //Define mean value of Order Amount, i.e. Avg. Order Amount
            return d.MFB;
        });
        console.log("Mean Value: ", dataMean);

        var ndx = crossfilter(finalForecastBias);
        var all = ndx.groupAll();
        var forecastPeriodDim = ndx.dimension(function(d) {
            return +d.ForecastPeriod;
        });
        var ndxDim = ndx.dimension(function(d) {
            return [+d.PeriodsBeforeDelivery, +d.MFB, +d.Product];
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
        var ndxGroup = ndxDim.group().reduceSum(function(d) {
            return +d.MFB;
        });
        var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
        var dateGroup = dateDim.group();
        const plotColorMap = {
            0: '#000099',
            1: '#cc8800'
        };
        var plotColorMap2 = function(d) {
            if (d.PeriodsBeforeDelivery == 0) return 0;
            else return 1;
        };

        forecastlist
            .dimension(forecastPeriodDim)
            .group(forecastPeriodGroup)
            .multiple(true)
            .numberVisible(15);

        productlist
            .dimension(productDim)
            .group(productGroup)
            //.controlsUseVisibility(true)
            .multiple(true)
            .numberVisible(15);

        periodsBeforeDeliveryChart
            .dimension(periodsBeforeDeliveryDim)
            .group(periodsBeforeDeliveryGroup)
            .multiple(true)
            .numberVisible(15);

        console.log("ndxDim: ", ndxGroup.top(Infinity));

        MFBchart
            .width(768)
            .height(480)
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
            .x(d3.scaleLinear().domain(d3.extent(finalForecastBias, function(d) {
                return d.PeriodsBeforeDelivery
            })))
            .brushOn(true)
            .clipPadding(10)
            .xAxisLabel("Periods Before Delivery")
            .yAxisLabel("MFB")
            // .mouseZoomable(true)
            .renderTitle(true)
            .title(function(d) {
                return [
                    'Periods Before Delivery: ' + d.key[0],
                    'MFB: ' + d.key[1],
                    'Product: ' + d.key[2]
                ].join('\n');
            })
            .elasticX(true)
            .elasticY(true)
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
        MFBchart.margins().left = 50;

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
                "MFB"
            ]);
        dc.renderAll();

        /* Old Calculation of MFB */
        // let finalForecastBias = dataGroupedByPBD.map((val) => {
        //     let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
        //         console.log('sum for pbd: ', val.key, ' sum: ', sum);
        //         let finalForecastBiasPBD = sum / sumOfAllFinalOrders;
        //         console.log('Final Forecast Bias by PBD: ', finalForecastBiasPBD);

        //         return {
        //             PeriodsBeforeDelivery: val.key,
        //             ForecastBiasPBD: finalForecastBiasPBD
        //         };
        //     });

        // console.log('Final Forecast Bias: ', finalForecastBias);

    });
    const width = "960";
    </script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>


</body>

</html>