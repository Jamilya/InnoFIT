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
    <title>Customer orders</title>
    <link href="/lib/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            min-height: 2000px;
            padding-top: 70px;
        }

        path {
            stroke: rgb(40, 40, 41);
            stroke-width: 1;
            fill: none;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
        }

        .overlay {
            fill: none;
            pointer-events: all;
        }

        .tooltip circle {
            fill: #F1F3F3;
            stroke: #6F257F;
            stroke-width: 5px;
        }

        .hover-line {
            stroke: #6F257F;
            stroke-width: 2px;
            stroke-dasharray: 3, 3;
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
                    <div class="dropdown">
                        <a class="nav-link active" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li>
                                <a class="dropdown-item" href="./finalorder.php">Final Order Amount</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./deliveryplans.php">Delivery Plans</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./forecastbias.php">Forecast Bias Analysis</a>
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
                                <a class="dropdown-item" href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item active" href="./customerorders.php">Customer Orders</a>
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
    <!--  <script src="http://d3js.org/d3.v3.min.js"></script> -->

    <div style="padding-left:39px">
        <h3>Customer orders Graph</h3>
        <small>
            <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
            <br><br>
        <p> NOTE: This graph shows historical customer order amount registered throughout the period of data upload.</p>
    </div>
    </div>

    <script>

        var margin = { top: 20, right: 25, bottom: 30, left: 55 },
            width = 900 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

/*         var parseDate = d3.timeFormat("%Y-%m-%d").parse,
            bisectDate = d3.bisector(function (d) { return d.Date; }).left; */

        var x = d3.scaleTime().range([0, width]);
        var y = d3.scaleTime().range([height, 0]);

        var parseTime = d3.timeParse("%Y-%m-%d");
        d3.json("/includes/getdata.php", function (error, data) {
            if (error) throw error;

/*             data.forEach(function (d) {
                d.Date = parseTime(d.Date);
                
            }); */
        //Define the axes
        var xAxis = d3.axisBottom(x);
        var yAxis = d3.axisLeft(y);

        // Define the line
        var valueline = d3.line()
            .x(function (d) { return x(d.Date); })
            .y(function (d) { return y(d.OrderAmount); });
        //Append svg object to the body of the page, append the group element to svg, move the group element to the top left    
        var svg = d3.select("body").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



            x.domain(d3.extent(data, function (d) { return d.Date; }));
            y.domain(d3.extent(data, function (d) { return d.OrderAmount; }));

            //Add the value line
            svg.append("path")
                .attr("class", "line")
                .attr("fill", "none")
                .data([data])
                .attr("stroke", "steelblue")
                .attr("stroke-linejoin", "round")
                .attr("stroke-linecap", "round")
                .attr("stroke-width", 1)
                .attr("d", valueline);

            svg.append("marker")
                .attr("id", "arrowhead")
                .attr("markerWidth", 13)
                .attr("markerHeight", 9)
                //		.attr("orient", "right")
                .append("path");

            svg.append("g")
                .attr("class", "xAxis")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x)
                    .tickFormat(d3.timeFormat("%m-%Y")))

                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.35em")
                .attr("dy", ".0em")
                .attr("transform", "rotate(-28)");

            svg.append("g")
                .attr("class", "yAxis")
                .call(d3.axisLeft(y))
                .append("text")
                //.attr("yAxis", 6)
                .attr("dy", "0.70em")
                .attr("text-anchor", "end")
                .text("Customer Orders (pcs)");

            var colorline = function (d) { return d.Date; },
                color = d3.scaleOrdinal(d3.schemeCategory10);


            var circles = svg.selectAll('circle')
                .data(data)
                .enter()
                .append('circle')
                .attr('cx', function (d) { return x(d.Date) })
                .attr('cy', function (d) {
                    return y(d.OrderAmount)
                })

                .attr('r', '7')
                .attr('stroke', 'black')
                .attr('stroke-width', 1)
                .attr('fill', function (d, i) { return color(colorline(3)); })
                .on('mouseover', function (d) {
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
                    return d.Date +
                        '\nOrder Amount Ordered: ' + d.OrderAmount
                })

            var tooltip = svg.append("g")
                .attr("class", "tooltip")
                .style("display", "none");

            tooltip.append("line")
                .attr("class", "x-hover-line hover-line")
                .attr("y1", 0)
                .attr("y2", height);

            tooltip.append("line")
                .attr("class", "y-hover-line hover-line")
                .attr("x1", width)
                .attr("x2", width);

            tooltip.append("circle")
                .attr("r", 7.5);

            tooltip.append("text")
                .attr("x", 15)
                .attr("dy", ".31em");

            // svg.append("rect")
            //     .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
            //     .attr("class", "overlay")
            //     .attr("width", width)
            //     .attr("height", height)
            //     .on("mouseover", function () { tooltip.style("display", null); })
            //     .on("mouseout", function () { tooltip.style("display", "none"); })
            //     .on("mousemove", mousemove);

            function mousemove() {
                var x0 = x.invert(d3.mouse(this)[0]),
                    i = bisectDate(data, x0, 1),
                    d0 = data[i - 1],
                    d1 = data[i],
                    d = x0 - d0.Date > d1.Date - x0 ? d1 : d0;
                tooltip.attr("transform", "translate(" + x(d.Date) + "," + y(d.OrderAmount) + ")");
                tooltip.select("text").text(function () { return d.OrderAmount; });
                tooltip.select(".x-hover-line").attr("y2", height - y(d.OrderAmount));
                tooltip.select(".y-hover-line").attr("x2", width + width);
            }
        });
    </script>

    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>