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
    <link rel="icon" href="/data/ico/innofit.ico">
    <title>Mean Absolute Percentage Error (MAPE) Graph</title>
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
                            <li><a href="./forecasterror.php">Forecast Error</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Error Measures</li>
                            <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD)</a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE)</a></li>
                            <li class="active"><a href="./mape.php">Mean Absolute Percentage Error (MAPE) <span
                                        class="sr-only">(current)</span></a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
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

        <h3>Mean Absolute Percentage Error (MAPE) Graph</h3>
        <small>
            <?php
                echo "You are logged in as: ";
                print_r($_SESSION["session_username"]);
                echo ".";
                ?></small>
        <br><br>
        <p> <b>Graph Description:</b> This graph shows the calculation of the Mean Absolute Percentage Error (MAPE),
            which is the evaluation of forecasting accuracy, calculated by
            the difference between forecasted customer orders and the final customer orders and divided by the final
            customer orders. The result is divided by a number of
            periods with respect to periods before delivery (PBD).
            <br>The formula of the MAPE is the following:
            <img src="https://latex.codecogs.com/gif.latex?MAPE_{j} = \frac {\sum_{i=1}^{n}|x_{i,j}-x_{i,0}|}{\sum_{i=1}^{n}x_{i,0}}"
                title="MAPE formula" />
        </p>
    </div>

    <div style="padding-left:39px">
        <div id="scatter">
            <!-- <p style="text-align:center;"><strong>MAPE graph</strong></p> -->
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <!-- <a class="reset" href="javascript:MAPEchart.filterAll(); dc.redrawAll();" style="display: none;">reset</a> -->
            <div class="clearfix"></div>
        </div>
        <div id="forecastlist">
            <p style="text-align:center;"><strong>Due date </strong></p>
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <!-- <a class="reset" href="javascript:forecastlist.filterAll();dc.redrawAll();" style="display: none;">reset</a> -->
            <div class="clearfix"></div>
        </div>
        <!-- <div style="clear: both"></div> -->
        <!-- <div id="daySelectionDiv"></div> -->
        <!-- <script type="text/javascript" src="../lib/js/header.js"></script> -->
        <div id="productlist">
            <p style="text-align:center;"><strong>Product</strong></p>
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <!-- <a class="reset" href="javascript:productlist.filterAll();dc.redrawAll();" style="display: none;">reset</a> -->
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

        <div id="test"></div><br />
        <svg width="960" height="500"></svg> <br />
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
        MAPEchart = dc.scatterPlot("#scatter")
    visTable = dc.dataTable(".dc-data-table")
    productlist = dc.selectMenu("#productlist");
    // var data = JSON.parse(localStorage['data']);
    const xValue = d => d.PeriodsBeforeDelivery;
    const xLabel = 'Periods Before Delivery';
    const yValue = d => d.MeanOfThisPeriod;
    const yLabel = 'MAPE';
    const colorValue = d => d.Product;
    const colorLabel = '';
    const margin = {
        left: 55,
        right: 25,
        top: 20,
        bottom: 30
    };
    const legendOffset = 52;

    const svg = d3.select('svg');
    const width = svg.attr('width');
    const height = svg.attr('height');
    const innerWidth = width - margin.left - margin.right - legendOffset;
    const innerHeight = height - margin.top - margin.bottom - 35;



    const g = svg.append('g')
        .attr('transform', `translate(${margin.left},${margin.top})`);
    const xAxisG = g.append('g')
        .attr('transform', `translate(0, ${innerHeight})`);
    const yAxisG = g.append('g');
    const colorLegendG = g.append('g')
        .attr('transform', `translate(${innerWidth + 32}, 28)`)
        .attr('stroke', 'black')
        .attr('stroke-width', 0.5);

    xAxisG.append('text')
        .attr('class', 'axis-label')
        .attr('x', innerWidth / 2)
        .attr('y', 41)
        .text(xLabel);

    yAxisG.append('text')
        .attr('class', 'axis-label')
        .attr('x', (-innerHeight / 2))
        .attr('y', -35)
        .attr('transform', `rotate(-90)`)
        .style('text-anchor', 'middle')
        .text(yLabel);

    //   colorLegendG.append('text')
    //       .attr('class', 'legend-label')
    //       .attr('x', -30)
    //       .attr('y', -12)
    //       .text(colorLabel);

    const xScale = d3.scaleLinear();
    const yScale = d3.scaleLinear();
    const colorScale = d3.scaleOrdinal()
        .range(d3.schemeCategory10);

    const xAxis = d3.axisBottom(xScale)
        .ticks(10);

    const yAxis = d3.axisLeft(yScale)
        .ticks(10);

    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);
        localforage.getItem("finalOrder", function(error, finalOrder) {
            finalOrder = JSON.parse(finalOrder);

            let uniqueArray = data.filter(function(obj) {
                return finalOrder.indexOf(obj) == -1;
            });
            // console.log("Unique array: ", uniqueArray);

            let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +
            b);
            // console.log('Sum of all final Orders: ', sumOfAllFinalOrders);

            let dataGroupedByPBD = d3.nest()
                .key(function(d) {
                    return d.PeriodsBeforeDelivery;
                })
                .entries(uniqueArray);

            // console.log('Grouped data: ', dataGroupedByPBD);

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
            // console.log('current mape: ', bubu);

            let mapeCurrentPBD = bubu.map((el) => {
                for (i = 0; i < dataGroupedByPBD.length; i++) {
                    let mape = Math.abs(el.SumOfForecast - sumOfAllFinalOrders) /
                        sumOfAllFinalOrders;
                    return {
                        ActualDate: el.ActualDate,
                        ForecastDate: el.ForecastDate,
                        Product: el.Product,
                        ActualPeriod: el.ActualPeriod,
                        ForecastPeriod: el.ForecastPeriod,
                        OrderAmount: el.OrderAmount,
                        PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                        MeanOfThisPeriod: mape
                    };
                }
            });
            console.log('Final mape: ', mapeCurrentPBD);

            mapeCurrentPBD.forEach(function(d) {
                d.ActualDate = new Date(d.ActualDate);
            });



            var ndx = crossfilter(mapeCurrentPBD);
            var all = ndx.groupAll();
            var forecastPeriodDim = ndx.dimension(function(d) {
                return +d.ForecastPeriod;
            });
            var ndxDim = ndx.dimension(function(d) {
                return [+d.PeriodsBeforeDelivery, +d.MeanOfThisPeriod, +d.Product];
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
                return +d.MeanOfThisPeriod;
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
            var color = {
                0: "#fa87ba",
                1: "#8d2c4a"
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

            MAPEchart
                .width(768)
                .height(480)
                .dimension(ndxDim)
                .symbolSize(9)
                .group(ndxGroup)
                .excludedSize(2)
                .excludedOpacity(0.5)
                .data(function(group) {
                    return group.all()
                        .filter(function(d) {
                            return d.key !== undefined || d.key !== NaN;
                        });
                })
                // .keyAccessor(function (d) { return d.key[0]; })
                // .valueAccessor(function (d) { return d.key[1]; })
                // .colorAccessor(function(d) { 
                //     if (d.key[2]==0) {
                //         return 0;
                //     } else return 1;
                //     // return d.key[2];
                //  })
                // .colors(function(colorKey) { 
                //     return plotColorMap[colorKey]; })

                .x(d3.scaleLinear().domain([0, 100]))
                .brushOn(true)
                .clipPadding(10)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("MAPE")
                // .mouseZoomable(true)
                .renderTitle(true)
                .title(function(d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'MAPE: ' + d.key[1],
                        'Product: ' + d.key[2]
                    ].join('\n');
                })
                .elasticX(true)
                .elasticY(true);
            // console.log('ndxgroup data:', ndxDim);


            MAPEchart.selectAll('path.symbol')
                .attr('opacity', 0.3);

            MAPEchart.margins().left = 50;


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
                    "OrderAmount",
                    "MeanOfThisPeriod"
                ]);

            dc.renderAll();

            /* Old Calculation of MAPE */
            //   let absDiff = function (orignalEl, finalOrder) {
            //                 return Math.abs(orignalEl.OrderAmount - finalOrder);
            //                 }

            //                 let finalOrder = data.filter((el) => {
            //                     return el.ActualPeriod == el.ForecastPeriod;
            //                 });
            //                 console.log('Final order array: ', finalOrder);

            //                  let uniqueArray = data.filter(function (obj) { return finalOrder.indexOf(obj) == -1; });
            //                  console.log("Unique array: ", uniqueArray);

            //                  let valueMap = new Map();
            //                  finalOrder.forEach((val) => {
            //                  let keyString = val.ActualPeriod;
            //                  let valueString = val.OrderAmount;
            //                  valueMap.set(keyString, valueString);
            //                 });

            //             let absValuesArray = uniqueArray.map((el) => {
            //                 let value = absDiff(el, valueMap.get(el.ForecastPeriod));
            //                 return {
            //                     ActualPeriod: el.ActualPeriod,
            //                     ForecastPeriod: el.ForecastPeriod,
            //                     OrderAmount: el.OrderAmount,
            //                     Product: el.Product,
            //                     PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            //                     AbsoluteDiff: value
            //                 };
            //             });


            //             let seperatedByPeriods = d3.nest()
            //                 .key(function (d) { return d.PeriodsBeforeDelivery })
            //                 .entries(absValuesArray);

            //             let madCalc = seperatedByPeriods.map((el) => {
            //                 let meanValue = d3.sum(el.values, function (d) { return d.AbsoluteDiff; });
            //                 return {
            //                     Product: el.Product,
            //                     ActualPeriod: el.ActualPeriod,
            //                     ForecastPeriod: el.ForecastPeriod,
            //                     OrderAmount: el.OrderAmount,
            //                     PeriodsBeforeDelivery: el.key,
            //                     SumOfMAD: meanValue
            //                 };
            //             });

            //                 let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            //                 console.log('Sum of all final Orders: ', sumOfAllFinalOrders);
            //                 console.log('MadCalc: ', madCalc);



            //                 let madSeperatedByPeriods = d3.nest()
            //                 .key(function (d) { return d.PeriodsBeforeDelivery })
            //                 .entries(madCalc);

            //             let madSumCalc = madSeperatedByPeriods.map((el) => {
            //                 let sumMad = el.values.map(item=>item.SumOfMAD).reduce((a, b) => +a + +b);
            //                 return {
            //                     ActualPeriod: el.ActualPeriod,
            //                     ForecastPeriod: el.ForecastPeriod,
            //                     OrderAmount: el.OrderAmount,
            //                     Product: el.Product,
            //                     PeriodsBeforeDelivery: el.key,
            //                     MadSum: sumMad
            //                 };
            //             });



            //             let mapeCalc = madSumCalc.map((val) => {
            //                 let mapeValue = val.MadSum/ sumOfAllFinalOrders;
            //                 return {
            //                     Product: val. Product,
            //                     ActualPeriod: val.ActualPeriod,
            //                     ForecastPeriod: val.ForecastPeriod,
            //                     PeriodsBeforeDelivery: val.PeriodsBeforeDelivery,
            //                     MapeFinal: mapeValue
            //                 };
            //             });
            //             console.log('MAPE Array: ', mapeCalc);


            xScale
                .domain([
                    d3.min([1, d3.min(mapeCurrentPBD, function(d) {
                        return d.PeriodsBeforeDelivery;
                    })]),
                    d3.max([1, d3.max(mapeCurrentPBD, function(d) {
                        return d.PeriodsBeforeDelivery;
                    })])
                ])
                .range([0, innerWidth])
                .nice();

            yScale
                .domain([
                    d3.min([0, d3.min(mapeCurrentPBD, function(d) {
                        return d.MeanOfThisPeriod;
                    })]),
                    d3.max([0, d3.max(mapeCurrentPBD, function(d) {
                        return d.MeanOfThisPeriod;
                    })])
                ])
                .range([innerHeight, 0])
                .nice();


            //Specify Deviation

            g.selectAll('circle').data(mapeCurrentPBD)
                .enter().append('circle')
                .attr('cx', d => xScale(xValue(d)))
                .attr('cy', d => yScale(yValue(d)))
                .attr('fill', d => colorScale(colorValue(d)))
                .attr('fill-opacity', 1)
                .attr('r', 8)
                .attr('stroke', 'black')
                .attr('stroke-width', 1)
                .on('mouseover', function(d) { // Tooltip
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .style("opacity", 1)
                        .attr('r', 10)
                        .attr('stroke-width', 3)
                })
                .on('mouseout', function() {
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .attr('r', 7)
                        .attr('stroke-width', 1)
                })
                .append('title') // Tooltip

                .text(function(d) {
                    return ' Periods Before Delivery: ' + d.PeriodsBeforeDelivery +
                        '\nMAPE of the period: ' + d.MeanOfThisPeriod
                });

            xAxisG.call(xAxis);
            yAxisG.call(yAxis);
            // colorLegendG.call(colorLegend)
            //   .selectAll('.cell text')
            //     .attr('dy', '0.1em');


            //     var margin = { top: 20, right: 15, bottom: 30, left: 80 },
            //         width = 960 - margin.left - margin.right,
            //         height = 590 - margin.top - margin.bottom - legendOffset;

            //         // var valueArray = Array.from(mape.values());
            //         // var keyArray = Array.from(mape.keys());
            //         var x = d3.scaleLinear()
            //         .domain([
            //             d3.min([1, d3.min(mapeCalc, function (d) { return d.PeriodsBeforeDelivery; })]),
            //             d3.max([1, d3.max(mapeCalc, function (d) { return d.PeriodsBeforeDelivery; })])
            //         ])
            //         .range([0, width])


            //     var y = d3.scaleLinear()
            //         .domain([
            //             d3.min([0, d3.min(mapeCalc, function (d) { return d.MapeFinal; })]),
            //             d3.max([0, d3.max(mapeCalc, function (d) { return d.MapeFinal; })])
            //         ])
            //         .range([height, 0])

            // var PeriodsBeforeDelivery = function (d) { return d.PeriodsBeforeDelivery; },
            //     color = d3.scaleOrdinal(d3.schemeCategory10);

            //     var xAxis = d3.axisBottom(x)
            //         .ticks(11);

            //     var yAxis = d3.axisLeft(y);

            //     var svg = d3.select("body").append("svg")
            //         .attr("width", width + margin.left + margin.right)
            //         .attr("height", height + margin.top + margin.bottom + legendOffset)
            //         .append("g")
            //         .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


            //     // Circles
            //     var circles = svg.selectAll('circle')
            //         .data(mapeCalc)
            //         .enter()
            //         .append('circle')
            //         .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
            //         .attr('cy', function (d) { return y(d.MapeFinal) })
            //         .attr('r', '7')
            //         .attr('stroke', 'black')
            //         .attr('stroke-width', 1)
            //         .attr('fill', function (d) { return color(PeriodsBeforeDelivery(d)); })

            //         .on('mouseover', function (d) {  // Tooltip
            //             d3.select(this)
            //                 .transition()
            //                 .duration(500)
            //                 .style("opacity", 1)
            //                 .attr('r', 10)
            //                 .attr('stroke-width', 3)
            //         })
            //         .on('mouseout', function () {
            //             d3.select(this)
            //                 .transition()
            //                 .duration(500)
            //                 .attr('r', 7)
            //                 .attr('stroke-width', 1)
            //         })
            //         .append('title') // Tooltip

            //         .text(function (d) {
            //             return 'Periods Before Delivery: ' +d.PeriodsBeforeDelivery +
            //                 '\nMAPE of the Period: ' + d.MapeFinal 
            //                 //'\nWeeks Before Delivery: ' + d.WeeksBeforeDelivery
            //             //'\nOrder Amount: ' + d.OrderAmount
            //         })

            //     svg.append("text")             
            //     .attr("transform", "translate(" + (width-15) + " ," + (height + margin.top - 32) + ")")
            //      .style("text-anchor", "middle")
            //     .attr("x", -410)
            //     .attr("dy", "3.5em")
            //     .attr("y", 3)
            //     .style("font-size","14px")
            //     .style("stroke-width", "1px")
            //     .text("Periods Before Delivery"); 

            //   svg.append("g")
            //     .attr("class", "x axis")
            //      .attr("transform", "translate(0," + height + ")")
            //      .style("text-anchor", "end")
            //     .text("Periods Before Delivery")
            //     //.attr("class", "label")
            //     // .style("text-anchor", "end")
            //     // .append("text")
            //     // .attr('dy', '.60em') 
            //     .call(xAxis);

            //   svg.append("text")
            //    .attr("transform", "rotate(-90)")
            //    .attr("y", 10)
            //    .attr("x",0 - (height / 1.5))
            //    .attr("dy", "-3em")
            //    .style("font-size","14px")
            //    .style("stroke-width", "1px")
            //     .text("Mean Absolute Percentage Error (MAPE)");

            //   svg.append("g")
            //     .attr("class", "y axis")

            //     .style("text-anchor", "end")
            //     .text("Mean Absolute Percentage Error (MAPE)")
            //     .call(yAxis);   


            //     var legend = svg.selectAll(".legend")
            //         .data(color.domain())
            //         .enter().append("g")
            //         .attr("class", "legend")

            //         .attr("transform", function (d, i) {
            //             return "translate(" + (- width + margin.left + margin.right + i * 90)           // x Position
            //                 + "," + (height + 59) + ")";
            //         });                                           // y Position

            //     legend.append("rect")
            //         .attr("x", width - 10)
            //         .attr("width", 10)
            //         .attr("height", 10)
            //         .style("opacity", 1)
            //         .style("fill", color);

            //     legend.append("text")
            //         .attr("x", width - 24)
            //         .attr("y", 10)
            //         .attr("yAxis", ".35em")
            //         .style("text-anchor", "end")
            //         .text(function (d) { return 'PBD ' + d; });

        });
    });
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