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
		<title>Forecast Error</title>
		<link href="/lib/css/bootstrap.min.css" rel="stylesheet">
	<style>

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
		</style>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
 <script type="text/javascript" src="/lib/js/bootstrap.min.js"></script>
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
                                <a class="dropdown-item active" href="./forecasterror.php">Forecast Error</a>
                            </li>
                            <li class="dropdown-header">Eror Measures</li>
                            <li>
                                <a class="dropdown-item" href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./mse_graph.php">Mean Square Error (MSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
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

   <div style="padding-left:39px">
      
      <h3>Forecast Error</h3>
      <small>
        <?php
        echo "You are logged in as: ";
        print_r($_SESSION["session_username"]);
        echo ".";
        ?></small>
        <br><br>
      <p><b> Graph Description:</b> This graph shows the Information Quality (IQ) for each final order with respect to the 
            period before delivery (PBD). The relative deviation is calculated 
         comparing the forecasted order amount to the final order amount with respect to periods before delivery.<br> The formula of the Forecast Error: 
        <img src="https://latex.codecogs.com/gif.latex?e_{i,j} = (\frac{ x_{i,j} - x_{i,0} }{x_{i,0}})*100" title="Forecast Error formula" /> (Note: different from the formula in the list of notations).
      </p>
   </div>
   <!-- <script src="https://cdn.rawgit.com/mozilla/localForage/master/dist/localforage.js"></script> -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.24.0/d3-legend.min.js"></script>
   <svg width="960" height="500"></svg>
   <script>
    //    fetch("/includes/getdata.php")
    //      .then(response => response.json())
    //      .then(json => {
    //         console.log("LOADED: ", json.length);
    //      }); 
    // var finalOrder = localforage['finalOrder'];
    // console.log(finalOrder);
    // var data = localforage['data'];

      const xValue = d => d.PeriodsBeforeDelivery;
      const xLabel = 'Periods Before Delivery';
      const yValue = d => d.Deviation * 100;
      const yLabel = 'Deviation (%)';
      const colorValue = d => d.ActualPeriod;
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
          .attr('x', -innerHeight / 2)
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
   










        var finalOrder = JSON.parse(localStorage['finalOrder']);
        var data = JSON.parse(localStorage['data']);

    let calcDeviation = function (orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
         } 

         let filterValues = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
         });

         console.log("Final Orders: ", filterValues);

         let valueMap = new Map();

         filterValues.forEach((val) => {
            let keyString = val.ActualPeriod;
            let valueString = val.OrderAmount;
            valueMap.set(keyString, valueString);
         });

         console.log("Mapped final order array: ", valueMap);

         let finalArray = data.map((el) => {
            let deviation = calcDeviation(el, valueMap.get(el.ForecastPeriod));
            return {
               ActualPeriod: el.ActualPeriod,
               ForecastPeriod: el.ForecastPeriod,
               OrderAmount: el.OrderAmount,
               Product: el.Product,
               FinalOrder: valueMap.get(el.ForecastPeriod),
               PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
               Deviation: deviation.toFixed(2)
            };
         })
         //console.log("Calculated Deviation Array: ", calcDeviation(data[0], 630));
         console.log("FINAL Array with deviation: ", finalArray);

                  var Deviation = function (d) {
            return d.Deviation === ((d.OrderAmount - d.FinalOrder) / d.FinalOrder);
         };


      d3.json("/includes/getdata.php", function (error, data2) {
        xScale
          .domain(d3.extent(finalArray, xValue))
          .range([0, innerWidth])
          .nice();
        
          yScale
          .domain(d3.extent(finalArray, yValue))
          .range([innerHeight, 0])
          .nice();


         //Specify Deviation
    
        g.selectAll('circle').data(finalArray)
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
               return d.Product +
                  '\nDeviation: ' + d.Deviation +
                  '\nActual Period: ' + d.ActualPeriod +
                  '\nForecast Period: ' + d.ForecastPeriod +
                  '\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery +
                  '\nOrder Amount: ' + d.OrderAmount
            });

        xAxisG.call(xAxis);
        yAxisG.call(yAxis);
        colorLegendG.call(colorLegend)
          .selectAll('.cell text')
            .attr('dy', '0.1em');


        //  var margin = { top: 20, right: 25, bottom: 30, left: 55 },
        //     width = 960 - margin.left - margin.right,
        //     height = 590 - margin.top - margin.bottom - legendOffset;

        //  var x = d3.scaleLinear()
        //     .domain([
        //        d3.min([0, d3.min(finalArray, function (d) { return d.PeriodsBeforeDelivery })]),
        //        d3.max([0, d3.max(finalArray, function (d) { return d.PeriodsBeforeDelivery })])
        //     ])
        //     .range([0, width])

        //  var y = d3.scaleLinear()
        //     .domain([
        //        d3.min([0, d3.min(finalArray, function (d) { return (d.Deviation * 100) })]),
        //        d3.max([0, 100])
        //     ])
        //     .range([height, 0])

        //  var ActualPeriod = function (d) { return d.ActualPeriod; },
        //     color = d3.scaleOrdinal(d3.schemeCategory10);

        //     var xAxis = d3.axisBottom(x)
        //         .ticks(10);

        //     var yAxis = d3.axisLeft(y);

        //  var svg = d3.select("body").append("svg")
        //     .attr("width", width + margin.left + margin.right)
        //     .attr("height", height + margin.top + margin.bottom + legendOffset)
        //     .append("g")
        //     .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


        //  // Circles
        //  var circles = svg.selectAll('circle')
        //     .data(finalArray)
        //     .enter()
        //     .append('circle')
        //     .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
        //     .attr('cy', function (d) { return y(d.Deviation * 100) })
        //     .attr('r', '7')
        //     .attr('stroke', 'black')
        //     .attr('stroke-width', 1)
        //     .attr('fill', function (d, i) { return color(ActualPeriod(d)); })

        //     .on('mouseover', function (d) {  // Tooltip
        //        d3.select(this)
        //           .transition()
        //           .duration(500)
        //           .style("opacity", 1)
        //           .attr('r', 10)
        //           .attr('stroke-width', 3)
        //     })
        //     .on('mouseout', function () {
        //        d3.select(this)
        //           .transition()
        //           .duration(500)
        //           .attr('r', 7)
        //           .attr('stroke-width', 1)
        //     })
        //     .append('title') // Tooltip

        //     .text(function (d) {
        //        return d.Product +
        //           '\nDeviation: ' + d.Deviation +
        //           '\nActual Period: ' + d.ActualPeriod +
        //           '\nForecast Period: ' + d.ForecastPeriod +
        //           '\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery +
        //           '\nOrder Amount: ' + d.OrderAmount
        //     })
           

        //  svg.append("g")
        //     .attr("class", "x axis")
        //     .attr("transform", "translate(0," + height + ")")
        //     .call(xAxis)
        //     .append("text")
        //     .attr("x", width-385)
        //     .attr("y", 20)
        //     .attr('dy', '1em')
        //     .style("text-anchor", "middle")
        //     .style("font-size","11px")
        //     .style("stroke-width", "1px")
        //     .text("Periods Before Delivery")

        // svg.append("text")
        // .attr("x", width-385)
        //     .attr("y", 415)
        //     .attr("dy", "1em")
        //     .style("text-anchor", "middle")
        //     .text("Periods Before Delivery");


        //  svg.append("g")
        //     .attr("class", "y axis")
        //     .call(yAxis)
        //     .append("text")
        //     .attr("class", "label")
        //     .attr("transform", "rotate(-90)")
        //     .attr("x", -160)
        //     .attr("y", -79)
        //     .attr("dy", "3.9em")
        //     .style("text-anchor", "middle")
        //     .style("font-size","11px")
        //     .style("stroke-width", "1px")
        //     .text("Deviation (%)")

        //     svg.append("text")
        //     .attr("x", -160)
        //     .attr("y", -79)
        //     .attr("dy", "3.9em")
        //     .attr("transform", "rotate(-90)")
        //     .style("text-anchor", "middle")
        //     .text("Deviation (%)");

        //     var svg = d3.select("#new_legend")

        //     svg.append("circle").attr("cx",70).attr("cy",15).attr("r", 6).data(color.domain())
        //     svg.append("circle").attr("cx",180).attr("cy",15).attr("r", 6).data(color.domain())
                
        //     //svg.append("circle").attr("cx",200).attr("cy",160).attr("r", 6).style("fill", "#404080")
        //     svg.append("text").attr("x", 90).attr("y", 15).text("Final Order").style("font-size", "15px").attr("alignment-baseline","middle")
        //     svg.append("text").attr("x", 200).attr("y", 15).text("Forecast Order").style("font-size", "15px").attr("alignment-baseline","middle")




        //  var legend = svg.selectAll(".legend")
        //     .data(color.domain())
        //     .enter().append("g")
        //     .attr("class", "legend")
        //     .attr("transform", function (d, i) {
        //        return "translate(" + (- width + margin.left + margin.right + i * 80)           // x Position
        //           + "," + (height + 47) + ")";
        //     });                                           // y Position

        //  legend.append("rect")
        //     .attr("x", width - 70)
        //     .attr("y", 7)
        //     .attr("width", 10)
        //     .attr("height", 10)
        //     .style("opacity", 1)
        //     .style("fill", color);

        //  legend.append("text")
        //     .attr("x", width -45)
        //     .attr("y", 0)
        //     .attr("yAxis", ".15em")
        //     .style("text-anchor", "end")
        //     .text(function (d) { return 'AP' + d; });

        //      localforage.setItem ('deviation', 'finalArray');
        //     // console.log( JSON.parse( localforage.getItem( 'deviation' ) ) );

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