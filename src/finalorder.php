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
    <link href="/lib/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 2000px;
            padding-top: 70px;
        }

        path {
            stroke: steelblue;
            stroke-width: 3;
            fill: none;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
        }
        table {
        border-collapse: collapse;
        }

        table, th, td {
        border: 1px solid black;
        }
        th {
        height: 30px;
        }
        table, th, td {
        text-align: center;
        }
        tr, thead {
        text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="/lib/js/bootstrap.min.js"></script>

</head>
<!-- <div id = "area1"></div> 
    <div id="area2"></div> -->

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
                                <a class="dropdown-item active" href="./finalorder.php">Final Order Amount</a>
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
                                <a class="dropdown-item" href="./mse_graph.php">Mean Square Error (MSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./mpe.php">Mean Percentage Error (MPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
                            </li>
                            <li>
                                <a class="dropdown-item " href="./meanforecastbias.php">Mean Forecast Bias</a>
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
    <!-- <script src="http://d3js.org/d3.v3.min.js"></script> -->
    <!-- <script src="https://d3js.org/d3-format.v1.min.js"></script>  -->
    <div style="padding-left:39px">

        <h3>Final Order Amount</h3>
        <small>
    <?php
    echo "You are logged in as: ";
    print_r($_SESSION["session_username"]);
    echo ".";
    ?>
        </small>
        <br>
        <br>
        <p> <b>Graph Description: </b>The graph shows the distribution of final orders (FO) per time period (calendar weeks).The <font color="orange"> orange-coloured line </font>
            is the average (mean) value of all final orders. <br> Additionally, the calculations of several statistical measures are shown in the table on the right.
        </p>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div id="chart"></div>
        </div>
        <div class="col-md-3">
            <div id="table"></div>
        </div>
    </div>


    <!--     <div class ="tooltip"><img src="img/info.png" alt="Description of this graph">
        <span class="tooltiptext">NOTE: This graph shows the final customer orders received and an average line calculated from the average of those
                order amounts.<br>The legend below shows the Calendar weeks depicted on the graph shown with different colors</span>
    </div>  

     -->


    <script>

        d3.json("/includes/getdata.php", function (error, data) {
            if (error) throw error;
            console.log(data);

            var valuesToPrint = [];
            let dataFiltered = data.filter((el) => { return el.PeriodsBeforeDelivery==0; });

            console.log("Final orders: ", dataFiltered);

            //console.log('2', parseInt('2'));
            var legendOffset = 140;

            var margin = { top: 20, right: 25, bottom: 30, left: 55 },
                width = 960 - margin.left - margin.right,
                height = 590 - margin.top - margin.bottom - legendOffset;

            var margin2 = { top2: 100, right2: 25, bottom2: 30, left2: 55 },
                width2 = 60 - margin.left - margin.right,
                height2 = 60 - margin.top - margin.bottom - legendOffset;

            var x = d3.scaleLinear()
                .domain([
                    d3.min([0, d3.min(dataFiltered, function (d) { return d.ActualPeriod })]),
                    d3.max([0, d3.max(dataFiltered, function (d) { return d.ActualPeriod })])
                ])
                .range([0, width])

            var y = d3.scaleLinear()
                .domain([
                    d3.min([0, d3.min(dataFiltered, function (d) {
                        if (d.PeriodsBeforeDelivery==0)
                            return d.OrderAmount
                    })]),
                    d3.max([0, d3.max(dataFiltered, function (d) {
                        if (d.PeriodsBeforeDelivery==0)
                            return d.OrderAmount
                    })])
                ])
                .range([height, 0])

            var product = function (d) { return d.Product; },
                color = d3.scaleOrdinal(d3.schemeCategory10);

            var xAxis = d3.axisBottom(x)
                .ticks(10);

            var yAxis = d3.axisLeft(y);
                // .ticks(11)


            var svg = d3.select("#chart").append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom + legendOffset)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            var dataMean = d3.mean(dataFiltered, function (d) { //Define mean value of Order Amount, i.e. Avg. Order Amount
                return d.OrderAmount;
            });
            console.log("Mean Value: ", dataMean);

            var dataMedian = d3.median(dataFiltered, function (d) { //Define median value of Order Amount
                return d.OrderAmount;
            });            
            var dataMax = d3.max(dataFiltered, function (d) { //Define maximum  value of Order Amount
                return d.OrderAmount;
            });
            var dataMin = d3.min(dataFiltered, function (d) { //Define minimum  value of Order Amount
                return d.OrderAmount;
            });
            var dataQuantile1 = d3.quantile(dataFiltered, 0.99, function (d) { 
                return d.OrderAmount;
            });
            var dataQuantile2 = d3.quantile(dataFiltered, 0.95, function (d) { 
                return d.OrderAmount;
            });
            var dataQuantile3 = d3.quantile(dataFiltered, 0.75, function (d) { 
                return d.OrderAmount;
            });

            //valuesToPrint.push(generateDescObject('Product: ', product));
            valuesToPrint.push(generateDescObject('Mean Value: ', dataMean));
            valuesToPrint.push(generateDescObject('Median Value: ', dataMedian));
            valuesToPrint.push(generateDescObject('Min Value: ', dataMin));
            valuesToPrint.push(generateDescObject('Max Value: ', dataMax));
            valuesToPrint.push(generateDescObject('99% Quantile: ', dataQuantile1));
            valuesToPrint.push(generateDescObject('95% Quantile: ', dataQuantile2));
            valuesToPrint.push(generateDescObject('75% Quantile: ', dataQuantile3));

            var productName = function (d) {
                return d.Product;
            }
            var dataMin = d3.min(dataFiltered, function (d) { //Define min number of periods
                return d.ActualPeriod;
            });
            var dataMaxPer = d3.max(dataFiltered, function (d) { //Define max number of periods
                return d.ActualPeriod;
            });
            //console.log("Amount of Periods: ", dataMaxPer);
            valuesToPrint.push(generateDescObject('Max Number of Periods', dataMaxPer));

            var standardDev = d3.deviation(dataFiltered, function (d) { //Define a standard deviation variable
                return d.OrderAmount;
            });
            console.log("Standard Deviation: ", standardDev, 1);
            valuesToPrint.push(generateDescObject('St. Dev.: ', standardDev, 1));

            var varKo = standardDev / dataMean;
            console.log("Var Ko : ", varKo);
            valuesToPrint.push(generateDescObject('Var. Ko.:: ', varKo));


            //document.getElementById("standardDev").style.color = "lightblue";


            //Define a tooltip
            /*             var tooltip = d3.select("body").append("div")
                            .attr("class", "tooltip")
                            .style("position", "absolute")
                            .style("visibility", "hidden")
                            .text("NOTE: This graph shows the final customer orders received and an average line calculated from the average of those order amounts");
            
                        svg.selectAll("div")
                            .enter()
                            .on("mouseover", function (d) {
                                div.transition()
                                    .duration(500)
                                    .style("opacity", .9);
                                //    var string="<img src=+" img/info.png "+ />";
                            })
                            .on('mouseout', function (d) {
                                div.transition()
                                    .duration(500)
                                    .style("opacity", .9);
                            });
            
            */



            svg.append("line")
                .style("stroke", "orange")
                .attr("stroke-width", 2)
                .data (dataFiltered)
                .attr("x1", 0)
                .attr("y1", y(dataMean))
                .attr("x2", width)
                .attr("y2", y(dataMean));

                //console.log('data Mean in px: ', y(dataMean));

            var circles = svg.selectAll('circle')
                .data(dataFiltered)
                .enter()
                .append('circle')
                .attr('cx', function (d) { return x(d.ActualPeriod) })
                .attr('cy', function (d) {
                    return y(d.OrderAmount)
                })

                .attr('r', '7')
                .attr('stroke', 'black')
                .attr('stroke-width', 1)
                .attr('fill', function (d, i) { return color(product(d)); })
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
                        .attr('stroke-width', 3)
                })
                .append('title') // Tooltip
                .text(function (d) {
                    return d.Product +
                        '\nFinal Customer Order: ' + d.OrderAmount +
                        '\nPeriod: ' + d.ActualPeriod +
                        '\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery
                })



            svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis)
                .append("text")
                .attr("class", "label")
                .attr("x", width)
                .attr("y", 3)
                .attr('dy', '.45em')
                .style("text-anchor", "end")
                .text("Period");


            svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("class", "label")
                .attr("transform", "rotate(-90)")
                .attr("x", 0)
                .attr("y", 5)
                .attr("dy", ".45em")
                .style("text-anchor", "end")
                .text("Final Customer Order (pcs)")


            var legend = svg.selectAll(".legend")
                .data(color.domain())
                .enter().append("g")
                .attr("class", "legend")
                .attr("transform", function (d, i) {
                    return "translate(" + (- width + margin.left + margin.right + i * 90)           // x Position
                        + "," + (height + 42) + ")";
                });                                           // y Position

            legend.append("rect")
                .attr("x", width - 60)
                .attr("y", 7)
                .attr("width", 10)
                .attr("height", 10)
                .style("opacity", 0.5)
                .style("fill", color);

            legend.append("text")
                .attr("x", width + 5)
                .attr("y", 0)
                .attr("yAxis", ".35em")
                .style("text-anchor", "end")
                .text(function (d) { return ' ' + d; });

            legend.append("rect")
                .attr("x", width + 140)
                .attr("y", 7)
                .attr("width", 20)
                .attr("height", 1)
                .style("opacity", 0.5)
                .style("fill", "orange");

            legend.append("text")
                .attr("x", width + 198)
                .attr("y", 0)
                .attr("yAxis", ".35em")
                .style("text-anchor", "end")
                .text(function (d) { return 'Average line '; });
                         var lineSize = d3.scaleLinear()
                            .domain([
                                d3.min([0, d3.min(dataFiltered, function (d) { return d.ActualWeek })]),
                                d3.max([0, d3.max(dataFiltered, function (d) { return d.ActualWeek })])
                            ])
                            .range([dataMin, dataMax]);
            
                        var svg = d3.select("svg");
                        svg.append("g")
                            .attr("class", "legendSizeLine")
                            .attr("transform", function (d, i) {
                                return "translate(" + (- width + margin.left + margin.right + i * 190)           // x Position
                                    + "," + (height + 42) + ")";
                            });                                           // y Position
            /*             var legendSizeLine = d3.legend.size()
                            .scale(lineSize)
                            .shape("line")
                            .orient("horizontal")
                            //otherwise labels would have displayed:
                            // 0, 2.5, 5, 10
                            .labels(["tiny testing at the beginning",
                                "small", "medium", "large"])
                            .labelWrap(30)
                            .shapeWidth(40)
                            .labelAlign("start")
                            .shapePadding(10);
            
                        svg.select(".legendSizeLine")
                            .call(legendSizeLine); */

                tabulate(valuesToPrint, ['Description', 'Value']);

        });

            // The table generation function
            function tabulate(data, columns) {
                        var table = d3.select('#table').append('table')
                        var thead = table.append('thead')
                        var	tbody = table.append('tbody');

                        // append the header row
                        thead.append('tr')
                        .selectAll('th')
                        .data(columns).enter()
                        .append('th')
                            .text(function (column) { return column; });

                        // create a row for each object in the data
                        var rows = tbody.selectAll('tr')
                        .data(data)
                        .enter()
                        .append('tr');

                        // create a cell in each row for each column
                        var cells = rows.selectAll('td')
                        .data(function (row) {
                            return columns.map(function (column) {
                            return {column: column, value: row[column]};
                            });
                        })
                        .enter()
                        .append('td')
                            .text(function (d) { return d.value; });

                        return table;
                    }

            function generateDescObject(desc, value) {
                const obj = {};
                obj['Description'] = desc;
                obj['Value'] = value;

                return obj;
            }

    </script>


    <script src="/lib/jquery/jquery.min.js"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>