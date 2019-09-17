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
    <title>Mean Absolute Deviation (MAD) Graph</title>

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
    </style>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script> -->


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
                            <li class="active"><a href="./mad_graph.php">Mean Absolute Deviation (MAD) <span
                                        class="sr-only">(current)</span></a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE) </a></li>
                            <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix - With Variance </a></li>
                            <!-- <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="./boxplot.php">Box Plot</a>
                            </li> -->
                        </ul>
                    </li>
                    <!-- </ul> -->
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

                        <style type="text/css">
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
        <h3>Mean Absolute Deviation (MAD) Graph</h3>
        <small>
            <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
        <br>

        <br>
        <p><b> Graph Description: </b>This graph shows calculation of the Mean Absolute Deviation (MAD) of customer
            orders with respect to periods before delivery (PBD). The mean absolute deviation describes the absolute
            average error between the forecasted and the final order amounts.
            <br>The formula of the MAD: <img
                src="https://latex.codecogs.com/gif.latex?MAD_{j} = \frac{1}{n}\sum_{i=1}^{n}{\left | x_{i,j}-x_{i,0} \right |}"
                title="MAD_formula" />. </p>
    </div>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.24.0/d3-legend.min.js"></script> -->

    <div style="padding-left:39px">
        <div id="scatter">
            <!-- <p style="text-align:center;"><strong>MAD graph</strong></p> -->
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <a class="reset" href="javascript:MADchart.filterAll(); dc.redrawAll();" style="display: none;">reset</a>
            <div class="clearfix"></div>
        </div>
        <div id="forecastlist">
            <p style="text-align:center;"> <strong>Due date </strong></p>
            <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
            <!-- <a class="reset" href="javascript:forecastlist.filterAll();dc.redrawAll();" style="display: none;">reset</a> -->
            <div class="clearfix"></div>
        </div>
        <div id="daySelectionDiv"></div>

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

        <div id="test"></div> <br />
        <svg width="960" height="500"></svg></br>
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
    const xValue = d => d.PeriodsBeforeDelivery;
    const xLabel = 'Periods Before Delivery';
    const yValue = d => d.MeanOfThisPeriod;
    const yLabel = 'MAD';
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
        .attr('x', -innerHeight / 2)
        .attr('y', -42)
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
        .ticks(12);

    const yAxis = d3.axisLeft(yScale)
        .ticks(11);

    localforage.getItem("viz_data", function(error, data) {
       data = JSON.parse(data);

        var forecastlist = dc.selectMenu("#forecastlist"),
            // productChart = dc.pieChart("#product"),
            periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
            visCount = dc.dataCount(".dc-data-count"),
            MADchart = dc.scatterPlot("#scatter")
        visTable = dc.dataTable(".dc-data-table")
        productlist = dc.selectMenu("#productlist");

        let absDiff = function(orignalEl, finalOrder) {
            return Math.abs(orignalEl.OrderAmount - finalOrder);
        }

        let finalOrder = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
        });
        console.log("FINAL Orders array: ", finalOrder);

        let uniqueArray = data.filter(function(obj) {
            return finalOrder.indexOf(obj) == -1;
        });
        console.log("Unique array: ", uniqueArray);

        let valueMap = new Map();
        finalOrder.forEach((val) => {
            let keyString = val.ActualPeriod;
            let valueString = val.OrderAmount;
            valueMap.set(keyString, valueString);
        });
        console.log("valueMap: ", valueMap);

        let absValuesArray = uniqueArray.map((el) => {
            let value = absDiff(el, valueMap.get(el.ForecastPeriod));
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

        console.log("Abs values array: ", absValuesArray);

        let seperatedByPeriods = d3.nest()
            .key(function(d) {
                return d.PeriodsBeforeDelivery
            })
            .entries(absValuesArray);
        console.log("Abs values array: ", seperatedByPeriods);

        let bubu = seperatedByPeriods.map((el) => {
            for (i = 0; i < seperatedByPeriods.length; i++) {
                let meanValue = d3.mean(el.values, function(d) {
                    return d.AbsoluteDiff;
                });
                return {
                    ActualDate: el.values[i].ActualDate,
                    ForecastDate: el.values[i].ForecastDate,
                    Product: el.values[i].Product,
                    ActualPeriod: el.values[i].ActualPeriod,
                    ForecastPeriod: el.values[i].ForecastPeriod,
                    OrderAmount: el.values[i].OrderAmount,
                    PeriodsBeforeDelivery: el.key,
                    MeanOfThisPeriod: meanValue
                };
            }

        });
        console.log("separatedArray: ", bubu);
        bubu.forEach(function(d) {
            d.ActualDate = new Date(d.ActualDate);
        });

        var ndx = crossfilter(bubu);
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
        // var orderDim = ndx.dimension(function(d) { return d.OrderAmount;}) ;
        var dateDim = ndx.dimension(function(d) {
            return +d.ActualDate;
        });

        var forecastPeriodGroup = forecastPeriodDim.group();
        var productGroup = productDim.group();
        var ndxGroup = ndxDim.group().reduceSum(function(d) {
            return +d.MeanOfThisPeriod;
        });
        // var orderGroup = orderDim.group(function(d) { return +d.OrderAmount;});
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

        MADchart
            .width(768)
            .height(480)
            .dimension(ndxDim)
            .symbolSize(9)
            .group(ndxGroup)
            .data(function(group) {
                return group.all()
                    .filter(function(d) {
                        return d.key !== NaN;
                    });
            })
            // .renderHorizontalGridLines(true)
            // .renderVerticalGridLines(true)
            .excludedSize(2)
            .excludedOpacity(0.5)
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
            .yAxisLabel("MAD")
            // .mouseZoomable(true)
            .renderTitle(true)
            .title(function(d) {
                return [
                    'Periods Before Delivery: ' + d.key[0],
                    'MAD: ' + d.key[1]
                ].join('\n');
            })
            .elasticX(true)
            .elasticY(true);
        // console.log('ndxgroup data:', ndxDim);


        MADchart.selectAll('path.symbol')
            .attr('opacity', 0.3);
        MADchart.margins().left = 50;


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


        xScale
            // .domain([
            //     d3.min([0, d3.min(bubu, function (d) { return d.PeriodsBeforeDelivery })]),
            //     d3.max([0, d3.max(bubu, function (d) { return (d.PeriodsBeforeDelivery) })])
            // ])
            .domain([d3.min(bubu, function(d) {
                return d.PeriodsBeforeDelivery
            }), d3.max(bubu, function(d) {
                return d.PeriodsBeforeDelivery
            })])
            .range([0, innerWidth])
            .nice();

        yScale
            .domain([
                d3.min([0, d3.min(bubu, function(d) {
                    return (d.MeanOfThisPeriod)
                })]),
                d3.max([0, d3.max(bubu, function(d) {
                    return (d.MeanOfThisPeriod + 1)
                })])
            ])
            .range([innerHeight, 0])
            .nice();




        //Specify Deviation

        g.selectAll('circle').data(bubu)
            .enter().append('circle')
            .attr('cx', d => xScale(xValue(d)))
            .attr('cy', d => yScale(yValue(d)))
            .attr('fill', d => colorScale(colorValue(d)))
            .attr('fill-opacity', 1)
            .attr('r', 8)
            .attr('stroke', 'black')
            .attr('stroke-width', 1)
            .style("display", function(d) {
                return d.MeanOfThisPeriod == undefined ? "none" : undefined;
            })
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
                    '\nMAD of the period: ' + d.MeanOfThisPeriod
            });

        xAxisG.call(xAxis);
        yAxisG.call(yAxis);
        colorLegendG.call(colorLegend)
            .selectAll('.cell text')
            .attr('dy', '0.1em');


        //console.log(data);




        // var legendOffset = 140;


        // var margin = { top: 20, right: 25, bottom: 30, left: 55 },
        //     width = 960 - margin.left - margin.right,
        //     height = 590 - margin.top - margin.bottom - legendOffset;

        // var x = d3.scaleLinear()
        //     .domain([
        //         d3.min([0, d3.min(bubu, function (d) { return d.PeriodsBeforeDelivery })]),
        //         d3.max([0, d3.max(bubu, function (d) { return d.PeriodsBeforeDelivery })])
        //     ])
        //     .range([0, width])

        // var y = d3.scaleLinear()
        //     .domain([
        //         d3.min([0, d3.min(bubu, function (d) { return (d.MeanOfThisPeriod) })]),
        //         d3.max([0, d3.max(bubu, function (d) { return (d.MeanOfThisPeriod) })])
        //     ])
        //     .range([height, 0])

        // var PeriodsBeforeDelivery = function (d) { return d.PeriodsBeforeDelivery; },
        //     color = d3.scaleOrdinal(d3.schemeCategory10);

        // var xAxis = d3.axisBottom(x)
        //     .ticks(10);

        // var yAxis = d3.axisLeft(y);

        // var svg = d3.select("body").append("svg")
        //     .attr("width", width + margin.left + margin.right)
        //     .attr("height", height + margin.top + margin.bottom + legendOffset)
        //     .append("g")
        //     .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


        // // Circles
        // var circles = svg.selectAll('circle')
        //     .data(bubu)
        //     .enter()
        //     .append('circle')
        //     .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
        //     .attr('cy', function (d) { return y(d.MeanOfThisPeriod) })
        //     .attr('r', '7')
        //     .attr('stroke', 'black')
        //     .attr('stroke-width', 1)
        //     .attr('fill', function (d, i) { return color(PeriodsBeforeDelivery(d)); })

        //     .on('mouseover', function (d) {  // Tooltip
        //         d3.select(this)
        //             .transition()
        //             .duration(500)
        //             .style("opacity", 1)
        //             .attr('r', 10)
        //             .attr('stroke-width', 3)
        //     })
        //     .on('mouseout', function () {
        //         d3.select(this)
        //             .transition()
        //             .duration(500)
        //             .attr('r', 7)
        //             .attr('stroke-width', 1)
        //     })
        //     .append('title') // Tooltip

        //     .text(function (d) {
        //         return ' Periods Before Delivery: '+d.PeriodsBeforeDelivery + 
        //             '\nMAD of the Period: ' + d.MeanOfThisPeriod 
        //             //'\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery
        //         //'\nOrder Amount: ' + d.OrderAmount
        //     })

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
        //    .attr("x", 0 - (height / 1.5))
        //    .attr("dy", "-3em")
        //    .style("font-size","14px")
        //    .style("stroke-width", "1px")
        //     .text("Mean Absolute Deviation (MAD)");

        //   svg.append("g")
        //     .attr("class", "y axis")
        // //    .append("text")
        //  //  .attr("class", "label")
        //     // .attr("transform", "translate(0," + height + ")")
        //     // .attr("x", 0)
        //     // .attr("y", 5)
        //     // .attr("dy", ".45em")
        //     // .style("text-anchor", "end")
        //     .style("text-anchor", "end")
        //     .text("Mean Absolute Deviation (MAD)")
        //     .call(yAxis);   


        // var legend = svg.selectAll(".legend")
        //     .data(color.domain())
        //     .enter().append("g")
        //     .attr("class", "legend")
        //     //.scale(xAxis)
        //     //.shape('circle')
        //     .attr("transform", function (d, i) {
        //         return "translate(" + (- width + margin.left + margin.right + i * 90)           // x Position
        //             + "," + (height + 59) + ")";
        //     });                                           // y Position

        // legend.append("rect")
        //     .attr("x", width - 10)
        //     .attr("width", 10)
        //     .attr("height", 10)
        //     .style("opacity", 1)
        //     .style("fill", color);

        // legend.append("text")
        //     .attr("x", width - 24)
        //     .attr("y", 10)
        //     .attr("yAxis", ".35em")
        //     .style("text-anchor", "end")
        //     .text(function (d) { return 'PBD ' + d; });

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