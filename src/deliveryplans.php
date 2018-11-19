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
		<title>Delivery Plans</title>
		<link href="/lib/css/bootstrap.min.css" rel="stylesheet">

<style>
        body {
            min-height: 2000px;
            padding-top: 70px;
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
						<a class="navbar-light" href="/index.php">Web tool home</a>
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
										<a class="dropdown-item active"  href="./deliveryplans.php">Delivery Plans</a>
									</li>
									<li>
										<a class="dropdown-item" href="./forecastbias.php">Forecast Bias Analysis</a>
									</li>
									<li>
										<a class="dropdown-item" href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>
									</li>
									<li>
										<a class="dropdown-item" href="./mse_graph.php">Mean Square Error (MSE)</a>
									</li>
									<li>
										<a class="dropdown-item" href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
									</li>
									<li>
										<a class="dropdown-item " href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
									</li>
									<li>
										<a class="dropdown-item" href="./customerorders.php">Customer Orders</a>
									</li>
		
									<li role="separator" class="divider"></li>
									<li class="dropdown-header">Matrices</li>
									<li>
										<a class="dropdown-item" href="./matrix.html">Delivery Plans Matrix</a>
									</li>
									<li>
										<a class="dropdown-item" href="./matrixvariance.html">Delivery Plans Matrix - With Variance</a>
									</li>
									<li role="separator" class="divider"></li>
									<li class="dropdown-header">New Graphs</li>
									<li>
										<a class="dropdown-item" href="./boxplot.html">Box Plot</a>
									</li>
								</ul>
							</li>
						</ul>
						</div>
						<ul class="nav navbar-nav navbar-right">

							<li>
								<a class = "nav-link" href="/includes/logout.php">Logout
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
 
<!-- <div id="option"> -->
	<!-- <input name="uploadButton" -->
	<!-- type="button" -->
	<!-- value="Upload" -->
	<!-- onclick="uploadData()" -->
<!-- /> </div>  -->
	
<div style="padding-left:39px">
	<h3>Delivery plans</h3>
	<small>
		<?php
		echo "You are logged in as: ";
		print_r($_SESSION["session_username"]);
		echo ".";
		?></small>
		<br><br>
<p> NOTE: This graph shows how the amount of products ordered by the customer varied on each period or calendar week. *FO = Final Order </p>
</div>
	



<script>
d3.json("/includes/getdata.php", function(error, data) {
if (error) throw error;
console.log(data);
//console.log('2', parseInt('2'));
var legendOffset = 140;

var margin = {top: 20, right: 25, bottom: 30, left: 55},
    width = 960 - margin.left - margin.right,
    height = 590 - margin.top - margin.bottom - legendOffset;

 var x = d3.scale.linear()
    .domain([
    	d3.min([0,d3.min(data,function (d) { return d.ForecastPeriod })]),
    	d3.max([0,d3.max(data,function (d) { return d.ForecastPeriod })])
    	])
    .range([0,width])

var y = d3.scale.linear()
    .domain([
    	d3.min([0,d3.min(data,function (d) { return d.OrderAmount })]),
    	d3.max([0,d3.max(data,function (d) { return d.OrderAmount })])
    	])
    .range([height,0])

var color = d3.scale.category10();
var color2 = d3.scale.category10();

       var xAxis = d3.svg.axis()
            .scale(x)
            .ticks(10)
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
      .data(data)
      .enter()
    .append('circle')
      .attr('cx',function (d) { return x(d.ForecastPeriod) })
      .attr('cy',function (d) { return y(d.OrderAmount) })
      .attr('r','7')
      .attr('stroke','black')
      .attr('stroke-width',1)
      //.attr('fill',function (d,i) { return color(d.ForecastWeek)  })
      .attr('fill',function (d) { return color2(d.ActualPeriod===d.ForecastPeriod)  })
      .on('mouseover', function (d) {
        d3.select(this)
          .transition() 
          .duration(500)
          .attr('r',10)
          .attr('stroke-width',3)
      })
      .on('mouseout', function () {
        d3.select(this)
          .transition()
          .duration(500)
		  .style("opacity", .9)
          .attr('r',7)
          .attr('stroke-width',1)
      })
    .append('title') // Tooltip
      .text(function (d) { return d.Product +
                           '\nActual Period: ' + d.ActualPeriod +
                           '\nForecast Period: ' + d.ForecastPeriod +
                           '\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery +
                           '\nOrder Quantity: ' + d.OrderAmount })

  svg.append("g")
      .attr("class", "x")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
    .append("text")
      .attr("class", "label")
      .attr("x", width)
      .attr("y", 2)
	  .attr('dy','.71em')
      .style("text-anchor", "end")
      .text("Forecast Period");

  svg.append("g")
      .attr("class", "y")
      .call(yAxis)
    .append("text")
      .attr("class", "label")
      .attr("transform", "rotate(-90)")
	  .attr("x",0)
      .attr("y", 5)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Order Quantity(pcs)")
     


/* var linearSize = d3.scaleLinear()
.data(color.domain())
.range([0, height]);

var svg = d3.select("svg");

svg.append("g")
  .attr("class", "legend")
  .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

var legendSize = d3.legendSize()
  .scale(linearSize)
  .shape('circle')
  //.shapePadding(15)
  .labelOffset(20)
  .orient('horizontal');

svg.select(".legend")
  .call(legendSize); */


	var legend = svg.selectAll(".legend")
      .data(color2.domain())
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
    .style("fill", color2);
      //.style("fill", color); 

  legend.append("text")
      .attr("x", width - 24)
      .attr("y", 10)
      .attr("yAxis", ".35em")
      .style("text-anchor", "end")
	  .text(function(d) { return 'FO ' + d ; });
     
});

  
</script>
<!-- <div class="legend1">
        <div class="legend1"></div> -->

		<script src="/lib/jquery/jquery.min.js"></script>
		<script src="/lib/js/bootstrap.bundle.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		 crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
		 crossorigin="anonymous"></script>
		

</body>
</html>