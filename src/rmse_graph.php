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
    <title>Root Mean Square Error (RMSE) Graph</title>
    <link href="/lib/css/bootstrap.min.css" rel="stylesheet">

    <style>
      body {
        margin: 0px;
      }
      path {
            stroke: rgb(65, 69, 73);
            stroke-width: 1;
            fill: none;
        }

       /*  .axis path, */
        .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
        } 
      .domain {
        display: none;
      }
      .tick line {
        stroke: #C0C0BB;
      }
      .tick text, .legendCells text {
        fill: #8E8883;
        font-size: 10pt;
        font-family: sans-serif;
      }
      .axis-label, .legend-label {
        fill: #635F5D;
        font-size: 10pt;
        font-family: sans-serif;
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
                        <a class="nav-link" href="./about.php">About this tool</a>
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
                            <li class="dropdown-header">Eror Measures</li>
                            <li>
                                <a class="dropdown-item" href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mse_graph.php">Mean Square Error (MSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item active" href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mpe.php">Mean Percentage Error (MPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a>
                            </li>
                            <li class="dropdown-header">Matrices</li>
                            <li>
                                <a class="dropdown-item" href="./matrix.php">Delivery Plans Matrix</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./matrixvariance.php">Delivery Plans Matrix - With Variance</a>
                            </li>
                            <!-- <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="./boxplot.php">Box Plot</a>
                            </li> -->
                        </ul>
                </div>
                <div class="nav-link dropdown">
                        <a class="nav-link " href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Corrections
                            <span class="caret"></span> </a>
                            <ul class="nav-link dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li>
                                <a class="dropdown-item " href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE)</a>
                            </li>
                            </ul>
                </div>
                </ul>  
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="nav-link" href="/includes/logout.php">Logout
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>

                </ul>
            </div>
    </div>
    </nav>

    <script src="http://d3js.org/d3.v4.min.js"></script>
    <!-- <script src="http://d3js.org/d3.v3.min.js"></script> -->

    
       <div style="padding-left:3px"> 

            <h3>Root Mean Square Error (RMSE)</h3>
            <small>
                <?php
                echo "You are logged in as: ";
                print_r($_SESSION["session_username"]);
                echo ".";
                ?></small>
                <br><br>
            <p> <b>Graph Description:</b>  This graph shows an estimate of the square root of the Mean Squared Error (MSE), which is the quadratic
                mean of differences between forecasted and final customer orders with respect to periods before delivery (PBD).
                <br> Root Mean Square Error (square root of the squared errors), like the Mean Squared error, also measures accuracy (zero meaning perfect score). The Formula of the Root Mean Square Error (RMSE) is:
                <img src="https://latex.codecogs.com/gif.latex?RMSE_{j} = \sqrt{\frac{1}{n}\sum_{i=1}^{n} ( x_{i,j} - x_{i,0})^{2}}" 
                title="RMSE formula" />. </p> <!-- \sqrt{\frac{1}{n}\sum_{i=1}^{n} ( x_{i,j} - x_{i,0})^{2}} -->
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.24.0/d3-legend.min.js"></script>
         <svg width="960" height="500"></svg>

        <script>
         var data = JSON.parse(localStorage['data']);
    const xValue = d => d.PeriodsBeforeDelivery;
      const xLabel = 'Periods Before Delivery';
      const yValue = d => d.MeanOfThisPeriod;
      const yLabel = 'RMSE';
      const colorValue = d => d.PeriodsBeforeDelivery;
      const colorLabel = 'Actual Period';
      const margin = { left: 55, right: 25, top: 20, bottom: 30 };
      const legendOffset = 140;

    const svg = d3.select('svg');
      const width = svg.attr('width');
      const height = svg.attr('height');
      const innerWidth = width - margin.left - margin.right - legendOffset;
      const innerHeight = height - margin.top - margin.bottom-35;


      
      const g = svg.append('g')
        .attr('transform', `translate(${margin.left},${margin.top})`);
      const xAxisG = g.append('g')
        .attr('transform', `translate(0, ${innerHeight})`);
      const yAxisG = g.append('g');
      const colorLegendG = g.append('g')
        .attr('transform', `translate(${innerWidth + 32}, 28)`)
        .attr('stroke','black')
        .attr('stroke-width',0.5);

        xAxisG.append('text')
          .attr('class', 'axis-label')
          .attr('x', innerWidth / 2)
          .attr('y', 41)
          .text(xLabel);

      yAxisG.append('text')
          .attr('class', 'axis-label')
          .attr('x', (-innerHeight / 2)+30)
          .attr('y', -35)
          .attr('transform', `rotate(-90)`)
          .style('text-anchor', 'middle')
          .text(yLabel);

      colorLegendG.append('text')
          .attr('class', 'legend-label')
          .attr('x', -30)
          .attr('y', -12)
          .text(colorLabel);

      const xScale = d3.scaleLinear();
      const yScale = d3.scaleLinear();
      const colorScale = d3.scaleOrdinal()
        .range(d3.schemeCategory10);

        const xAxis = d3.axisBottom()
        .scale(xScale)
        .tickPadding(15)
        .tickSize(-innerHeight);

      const yAxis = d3.axisLeft()
        .scale(yScale)
        .ticks(5)
        .tickPadding(15)
        .tickSize(-innerWidth);

      const colorLegend = d3.legendColor()
        .scale(colorScale)
        .shape('circle');

  let powerDiff = function (orignalEl, finalOrder) {
                    return Math.pow((orignalEl.OrderAmount - finalOrder), 2);
                }


                let finalOrder = data.filter((el) => {
                    return el.PeriodsBeforeDelivery == 0;
                });
                console.log("FINAL ORDERS: ", finalOrder);

                /*             let squaredVal = function (absDiff){
                                    return Math.sqrt(absDiff);
                            };
                            console.log("SQUARED VAL: ", squaredVal); */

                let uniqueArray = data.filter(function (obj) { return finalOrder.indexOf(obj) == -1; });
                console.log("Unique array: ", uniqueArray);

                let valueMap = new Map();
                finalOrder.forEach((val) => {
                    let keyString = val.ActualPeriod;
                    let valueString = val.OrderAmount;
                    valueMap.set(keyString, valueString);
                });
                //console.log("valueMap: ", valueMap);

                let squaredAbsValuesArray = uniqueArray.map((el) => {
                    let value = powerDiff(el, valueMap.get(el.ForecastPeriod));
                    return {
                        ActualPeriod: el.ActualPeriod,
                        ForecastPeriod: el.ForecastPeriod,
                        OrderAmount: el.OrderAmount,
                        Product: el.Product,
                        PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                        SquaredAbsoluteDiff: value
                    };
                });
                console.log("FINAL: ", squaredAbsValuesArray);

                /*            let squaredValuesArray = absValuesArray.map((el) =>  {
                               let squared = Math.sqrt (el.AbsoluteDiff, 2);
                               return {
                                   ActualWeek: el.ActualWeek,
                                   ForecastWeek: el.ForecastWeek,
                                   OrderAmount: el.OrderAmount,
                                   Product: el.Product,
                                   WeeksBeforeDelivery: el.WeeksBeforeDelivery,
                                   SquaredValue: squared
                               };
                           });
                           console.log("squared values array: ", squaredValuesArray);
               
                */
                let seperatedByPeriods = d3.nest()
                    .key(function (d) { return d.PeriodsBeforeDelivery })
                    .entries(squaredAbsValuesArray);

                let bubu = seperatedByPeriods.map((el) => {
                    let meanValue = Math.sqrt (d3.mean(el.values, function (d) { return d.SquaredAbsoluteDiff; }),2);
                    return {
                        Product: el.Product,
                        ActualPeriod: el.ActualPeriod,
                        ForecastPeriod: el.ForecastPeriod,
                        OrderAmount: el.OrderAmount,
                        PeriodsBeforeDelivery: el.key,
                        MeanOfThisPeriod: meanValue
                    };
                });
                console.log("separatedArray: ", bubu);

        d3.json("/includes/getdata.php", function (error, data) {
            xScale
          .domain(d3.extent(bubu, xValue))
          .range([0, innerWidth])
          .nice();
        
          yScale
          .domain(d3.extent(bubu, yValue))
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
            .attr('stroke','black')
             .attr('stroke-width',1)
        .on('mouseover', function (d) {  // Tooltip
               d3.select(this)
                  .transition()
                  .duration(500)
                  .style("opacity", 1)
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
                  '\nRMSE of the period: ' + d.MeanOfThisPeriod
            });

        xAxisG.call(xAxis);
        yAxisG.call(yAxis);
        colorLegendG.call(colorLegend)
          .selectAll('.cell text')
            .attr('dy', '0.1em');


              




                var legendOffset = 140;

            //     var margin = { top: 20, right: 25, bottom: 30, left: 55 },
            //         width = 960 - margin.left - margin.right,
            //         height = 590 - margin.top - margin.bottom - legendOffset;

            //     var x = d3.scaleLinear()
            //         .domain([
            //             d3.min([0, d3.min(bubu, function (d) { return d.PeriodsBeforeDelivery })]),
            //             d3.max([0, d3.max(bubu, function (d) { return d.PeriodsBeforeDelivery })])
            //         ])
            //         .range([0, width])

            //     var y = d3.scaleLinear()
            //         .domain([
            //             d3.min([0, d3.min(bubu, function (d) { return (d.MeanOfThisPeriod) })]),
            //             d3.max([0, d3.max(bubu, function (d) { return (d.MeanOfThisPeriod) })])
            //         ])
            //         .range([height, 0])

            //     var PeriodsBeforeDelivery = function (d) { return d.PeriodsBeforeDelivery; },
            //         color = d3.scaleOrdinal(d3.schemeCategory10);

            //     var xAxis = d3.axisBottom(x)
            //         .ticks(10);

            //     var yAxis = d3.axisLeft(y);

            //     var svg = d3.select("body").append("svg")
            //         .attr("width", width + margin.left + margin.right)
            //         .attr("height", height + margin.top + margin.bottom + legendOffset)
            //         .append("g")
            //         .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


            //     // Circles
            //     var circles = svg.selectAll('circle')
            //         .data(bubu)
            //         .enter()
            //         .append('circle')
            //         .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
            //         .attr('cy', function (d) { return y(d.MeanOfThisPeriod) })
            //         .attr('r', '7')
            //         .attr('stroke', 'black')
            //         .attr('stroke-width', 1)
            //         .attr('fill', function (d, i) { return color(PeriodsBeforeDelivery(d)); })

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
            //             return 'Periods Before Delivery: ' + d.PeriodsBeforeDelivery +
            //                 '\nRMSE of this period: ' + d.MeanOfThisPeriod
            //             //'\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery 
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
            //     .text("Root Mean Square Error (RMSE)");

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
            //     .text("Root Mean Square Error (RMSE)")
            //     .call(yAxis);   


            //     var legend = svg.selectAll(".legend")
            //         .data(color.domain())
            //         .enter().append("g")
            //         .attr("class", "legend")
            //         //.scale(xAxis)
            //         //.shape('circle')
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


        </script>
    <script src="/lib/jquery/jquery.min.js"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>