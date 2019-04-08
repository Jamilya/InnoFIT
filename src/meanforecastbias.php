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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
    <link href="/lib/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 2000px;
            padding-top: 70px;
        }


        path {
            stroke: steelblue;
            stroke-width: 2;
            fill: none;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
      

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/index.php">Web tool home</a>
            </div>
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <!--  <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li > -->
                    <li>
                        <a class="nav-link " href="./about.php">About this tool</a>
                    </li>
                    <div class="nav-link dropdown">
                        <a class="nav-link active" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations
                            <span class="caret"></span>
                        </a>
                        <ul class="nav-link dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li>
                                <a class="dropdown-item" href="./finalorder.php">Final Order Amount</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./deliveryplans.php">Delivery Plans</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./forecasterror.php">Forecast Error</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mse_graph.php">Mean Squared Error (MSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mpe.php">Mean Percentage Error (MPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item active" href="./meanforecastbias.php"> Mean Forecast Bias</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Corrected Error Measures</li>
                            <li>
                                <a class="dropdown-item" href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE)</a>
                            </li>

                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Matrices</li>
                            <li>
                                <a class="dropdown-item" href="./matrix.php">Delivery Plans Matrix</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./matrixvariance.php">Delivery Plans Matrix - With Variance</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="./boxplot.php">Box Plot</a>
                            </li>
                        </ul>
                        </li>
                </ul>
                </div>
                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a class="nav-link" href="/includes/logout.php">Logout
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
    </nav>
    <!--/.nav-collapse -->
    </div>
    </nav>


    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>

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
        <p> <b>Graph Description:</b> This graph shows the calculation of the Mean Forecast Bias, which is the description of the forecast error with respect to periods before delivery (PBD).
        <br> The <font color="orange"> orange-coloured line </font>        is the average (mean) value of forecast bias values. 
            <br>The formula of the Mean Forecast Bias is: <img src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}" title="Mean Forecast Bias formula" />. </p>
            
    </div>

    <script>

        d3.json("/includes/getdata.php", function (error, data) {
            if (error) throw error;
            //console.log(data);

            let finalOrder = data.filter((el) => {
                return el.PeriodsBeforeDelivery == 0;
            });



            let uniqueArray = data.filter(function (obj) { return finalOrder.indexOf(obj) == -1; });
            console.log("Unique array: ", uniqueArray);


            let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            console.log('Sum of all final Orders: ', sumOfAllFinalOrders);


            let dataGroupedByPBD = d3.nest()
                .key(function(d) { return d.PeriodsBeforeDelivery; })
                .entries(uniqueArray);
            console.log('Grouped data: ', dataGroupedByPBD);



            let finalForecastBias = dataGroupedByPBD.map((val) => {
                let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
                    console.log('sum for pbd: ', val.key, ' sum: ', sum);
                    let finalForecastBiasPBD = sum / sumOfAllFinalOrders;
                    console.log('Final Forecast Bias by PBD: ', finalForecastBiasPBD);

                    return {
                        PeriodsBeforeDelivery: val.key,
                        ForecastBiasPBD: finalForecastBiasPBD
                    };
                });

            console.log('Final Forecast Bias: ', finalForecastBias);

            var dataMean = d3.mean(finalForecastBias, function (d) { //Define mean value of Order Amount, i.e. Avg. Order Amount
                return d.ForecastBiasPBD;
            });
            console.log("Mean Value: ", dataMean);

            // let valueMap = new Map();
            // finalOrder.forEach((val) => {
            //     let keyString = val.ActualPeriod;
            //     let valueString = val.OrderAmount;
            //     valueMap.set(keyString, valueString);
            // });
            // console.log("Actual period and  Order amount of final orders: ", valueMap);

            // let valuesArray = uniqueArray.map((el) => {
            //     let value = orderDiff(el, valueMap.get(el.ForecastPeriod));
            //     return {
            //         ActualPeriod: el.ActualPeriod,
            //         ForecastPeriod: el.ForecastPeriod,
            //         OrderAmount: el.OrderAmount,
            //         Product: el.Product,
            //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            //         OrderDiff: value
            //     };
            // });

            // console.log("Final array of forecast bias calculation: ", valuesArray);

            // let seperatedByPeriods = d3.nest()
            //     .key(function (d) { return d.PeriodsBeforeDelivery })
            //     .entries(valuesArray);

            // let bubu = seperatedByPeriods.map((el) => {
            //     let meanValue = d3.mean(el.values, function (d) { return d.OrderDiff; });
            //     return {
            //         Product: el.Product,
            //         ActualPeriod: el.ActualPeriod,
            //         ForecastPeriod: el.ForecastPeriod,
            //         OrderAmount: el.OrderAmount,
            //         PeriodsBeforeDelivery: el.key,
            //         MeanOfThisPeriod: meanValue
            //     };
            // });
            // console.log("separatedArray: ", bubu);

            /*     uniqueArray.forEach((el, i) => {         // indexing
                    console.log("Index: ", i);
                    finalOrder.forEach((el2, i2) => {
                        console.log("Index inner: ", i2);
                    })
                }); */

            // uniqueArray.forEach((ell) => {
            //     finalOrder.forEach((val) => {
            //         if (ell.ActualWeek <= val.ActualWeek);
            //         //let keyString = (ell.WeeksBeforeDelivery, ell.ActualWeek);
            //         let keyString = (ell.WeeksBeforeDelivery);

            //         //            ell.mad === ell.OrderAmount===ell.FinalOrder === 0;} */
            //         let valueString = Math.abs(ell.OrderAmount - val.OrderAmount);
            //         valueMap.set(keyString, valueString);
            //     });
            // });

            /*             var mad = d3.mean(valueMap, function (d) { return d.OrderAmount; });
                        console.log("MAD:", mad);
            
                      let zip = (data, finalOrder) => data.map ((OrderAmount,ActualWeek) => [ActualWeek, finalOrder[OrderAmount]]);
                                 console.log("mapped arrays: ", zip);
                        
                        
                   */

            /*             let finalArray = data.map((el) => {
                            let mad = calcMad(el, valueMap.get(el.WeeksBeforeDelivery));
                            return {
                                ActualWeek: el.ActualWeek,
                                ForecastWeek: el.ForecastWeek,
                                OrderAmount: el.OrderAmount,
                                Product: el.Product,
                                OrderDifference: valueMap.get(el.WeeksBeforeDelivery),
                                WeeksBeforeDelivery: el.WeeksBeforeDelivery,
                                Mad: el.mad
                            };
                        })
                        console.log("FINAL ARRAY: ", finalArray);
            
                        var CalcMad = function (d) {
                            return d3.mean(Math.abs(d.OrderAmount - d.FinalOrder));
                        }
                        console.log("Calculated MAD:", CalcMad); */

            var legendOffset = 140;


            var margin = { top: 15, right: 5, bottom: 15, left: 30 },
                width = 1250 - margin.left - margin.right,
                height = 600 - margin.top - margin.bottom - legendOffset;

            var x = d3.scale.linear()
                .domain([
                    d3.min([0, d3.min(finalForecastBias, function (d) { return d.PeriodsBeforeDelivery })]),
                    d3.max([0, d3.max(finalForecastBias, function (d) { return d.PeriodsBeforeDelivery })])
                ])
                .range([0, width])

            var y = d3.scale.linear()
                .domain([
                    d3.min([0, d3.min(finalForecastBias, function (d) { return (d.ForecastBiasPBD) })]),
                    d3.max([0, d3.max(finalForecastBias, function (d) { return (d.ForecastBiasPBD) })])
                ])
                .range([height, 0])

            var PeriodsBeforeDelivery = function (d) { return d.PeriodsBeforeDelivery; },
                color = d3.scale.category10();

            var xAxis = d3.svg.axis()
                .scale(x)
                .ticks(11)
                .orient("bottom");

            var yAxis = d3.svg.axis()
                .scale(y)
                // .ticks(11)
                .orient("left");

            var svg = d3.select("body").append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom + legendOffset)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


            // Circles
            var circles = svg.selectAll('circle')
                .data(finalForecastBias)
                .enter()
                .append('circle')
                .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
                .attr('cy', function (d) { return y(d.ForecastBiasPBD) })
                .attr('r', '7')
                .attr('stroke', 'black')
                .attr('stroke-width', 1)
                .attr('fill', function (d, i) { return color(PeriodsBeforeDelivery(d)); })

                .on('mouseover', function (d) {  // Tooltip
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .style("opacity", .9)
                        .attr('r', 10)
                        .attr('stroke-width', 3)
                })
                .on('mouseout', function () {
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .attr('r', 7)
                        .attr('stroke-width', 1)
                })
                .append('title') // Tooltip

                .text(function (d) {
                    return ' Periods Before Delivery: '+d.PeriodsBeforeDelivery + 
                        '\nForecast Bias of the Period: ' + d.ForecastBiasPBD 
                        // '\nActual Period: ' + d.ActualPeriod +
                        // '\nForecast Period: ' + d.ForecastPeriod +
                        // '\nProduct: ' + d.Product 
                })

            svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis)
                .append("text")
                .attr("class", "label")
                .attr("x", width)
                .attr("y", 2)
                .attr('dy', '.50em')
                .style("text-anchor", "end")
                .text("Periods Before Delivery");


            svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("class", "label")
                .attr("transform", "rotate(-90)")
                .attr("x", 0)
                .attr("y", 5)
                .attr("dy", ".55em")
                .style("text-anchor", "end")
                .text("Forecast Bias")

            svg.append("line")
                .style("stroke", "orange")
                .attr("stroke-width", 2)
                .data (finalForecastBias)
                .attr("x1", 0)
                .attr("y1", y(dataMean))
                .attr("x2", width)
                .attr("y2", y(dataMean));



            var legend = svg.selectAll(".legend")
                .data(color.domain())
                .enter().append("g")
                .attr("class", "legend")
                //.scale(xAxis)
                //.shape('circle')
                .attr("transform", function (d, i) {
                    return "translate(" + (- width + margin.left + margin.right + i * 90)           // x Position
                        + "," + (height + 42) + ")";
                });                                           // y Position

            legend.append("rect")
                .attr("x", width - 10)
                .attr("width", 10)
                .attr("height", 10)
                .style("opacity", 0.5)
                .style("fill", color);

            legend.append("text")
                .attr("x", width - 24)
                .attr("y", 10)
                .attr("yAxis", ".35em")
                .style("text-anchor", "end")
                .text(function (d) { return 'PBD ' + d; });

        });

    </script>

<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
 crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
 crossorigin="anonymous"></script>

</body>

</html>