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


  <title>Delivery Plans Correlation Matrix with Variance</title>

  <link rel="stylesheet" href="/lib/css/bootstrap.min.css">
  <style>
    body {
      font: 12px Arial;
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


    td,
    th {
      padding: 2px 4px;
    }

    th {
      font-weight: bold;
    }
  </style>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
    crossorigin="anonymous"></script>


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
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
                  <a class="dropdown-item" href="./mpe.php">Mean Percentage Error (MPE)</a>
                  </li>
              <li>
                <a class="dropdown-item" href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
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
                <a class="dropdown-item " href="./matrix.php">Delivery Plans Matrix</a>
              </li>
              <li>
                <a class="dropdown-item active" href="./matrixvariance.php">Delivery Plans Matrix - With Variance</a>
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
  <div class="container">

    <div style="padding-left:39px">
      <br>
      <h3>Delivery Plans Correlation Matrix With Variance</h3>

      <small>
        <?php
        echo "You are logged in as: ";
        print_r($_SESSION["session_username"]);
        echo ".";
        ?></small>
      <br><br>
      <p> NOTE: This is Delivery plans correlation matrix with the calculation of variance. <font color="red">(Note: the matrix calculation is still under development!)</font></p>

    </div>
    <div style="display:inline-block;" id="legend"></div>
    <div style="display:inline-block; float:left" id="container"></div>
    <script>
      var correlationMatrix = [
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0.23, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0.48, 0.29, 0, 0, 0, 0, 0, 0, 0, 0],
        [0.42, 0.44, 0.27, 0, 0, 0, 0, 0, 0, 0],
        [0.29, 0.5, 0.35, 0.36, 0, 0, 0, 0, 0, 0],
        [0.24, 0.24, 0.57, 0.38, 0.32, 0, 0, 0, 0, 0],
        [0.04, 0.22, 0.17, 0.55, 0.39, 0.34, 0, 0, 0, 0],
        [0.03, 0.15, 0.15, 0.23, 0.46, 0.45, 0.24, 0, 0, 0],
        [0.04, 0, 0.12, 0.16, 0.22, 0.54, 0.42, 0.26, 0, 0],
        [0.05, 0.05, 0.08, 0.1, 0.18, 0.25, 0.5, 0.4, 0.3, 0]
      ];

      var labels = ['CW 1', 'CW 2', 'CW 3', 'CW 4', 'CW 5', 'CW 6', 'CW 7', 'CW 8', 'CW 9', 'CW 10'];

      Matrix({
        container: '#container',
        data: correlationMatrix,
        labels: labels,
        start_color: '#ffffff',
        middle_color: '#B40404',
        end_color: '#3498db'
      });

      function Matrix(options) {
        var margin = { top: 50, right: 50, bottom: 100, left: 100 },
          width = 350,
          height = 350,
          data = options.data,
          container = options.container,
          labelsData = options.labels,
          startColor = options.start_color,
          endColor = options.end_color;

        var widthLegend = 100;

        if (!data) {
          throw new Error('Please pass data');
        }

        if (!Array.isArray(data) || !data.length || !Array.isArray(data[0])) {
          throw new Error('It should be a 2-D array');
        }

        var maxValue = d3.max(data, function (layer) { return d3.max(layer, function (d) { return d; }); });
        var minValue = d3.min(data, function (layer) { return d3.min(layer, function (d) { return d; }); });

        var numrows = data.length;
        var numcols = data[0].length;

        var svg = d3.select(container).append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
          .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        var background = svg.append("rect")
          .style("stroke", "black")
          .style("stroke-width", "2px")
          .attr("width", width)
          .attr("height", height);

        var x = d3.scale.ordinal()
          .domain(d3.range(numcols))
          .rangeBands([0, width]);

        var y = d3.scale.ordinal()
          .domain(d3.range(numrows))
          .rangeBands([0, height]);

        var colorMap = d3.scale.linear()
          .domain([minValue, maxValue])
          .range([startColor, endColor]);

        var row = svg.selectAll(".row")
          .data(data)
          .enter().append("g")
          .attr("class", "row")
          .attr("transform", function (d, i) { return "translate(0," + y(i) + ")"; });

        var cell = row.selectAll(".cell")
          .data(function (d) { return d; })
          .enter().append("g")
          .attr("class", "cell")
          .attr("transform", function (d, i) { return "translate(" + x(i) + ", 0)"; });

        cell.append('rect')
          .attr("width", x.rangeBand())
          .attr("height", y.rangeBand())
          .style("stroke-width", 0);

        cell.append("text")
          .attr("dy", ".32em")
          .attr("x", x.rangeBand() / 2)
          .attr("y", y.rangeBand() / 2)
          .attr("text-anchor", "middle")
          .style("fill", function (d, i) { return d >= maxValue / 2 ? 'white' : 'black'; })
          .text(function (d, i) { return d; });

        row.selectAll(".cell")
          .data(function (d, i) { return data[i]; })
          .style("fill", colorMap);

        var labels = svg.append('g')
          .attr('class', "labels");

        var columnLabels = labels.selectAll(".column-label")
          .data(labelsData)
          .enter().append("g")
          .attr("class", "column-label")
          .attr("transform", function (d, i) { return "translate(" + x(i) + "," + height + ")"; });

        columnLabels.append("line")
          .style("stroke", "black")
          .style("stroke-width", "1px")
          .attr("x1", x.rangeBand() / 2)
          .attr("x2", x.rangeBand() / 2)
          .attr("y1", 0)
          .attr("y2", 5);

        columnLabels.append("text")
          .attr("x", 0)
          .attr("y", y.rangeBand() / 2)
          .attr("dy", ".82em")
          .attr("text-anchor", "end")
          .attr("transform", "rotate(-60)")
          .text(function (d, i) { return d; });

        var rowLabels = labels.selectAll(".row-label")
          .data(labelsData)
          .enter().append("g")
          .attr("class", "row-label")
          .attr("transform", function (d, i) { return "translate(" + 0 + "," + y(i) + ")"; });

        rowLabels.append("line")
          .style("stroke", "black")
          .style("stroke-width", "1px")
          .attr("x1", 0)
          .attr("x2", -5)
          .attr("y1", y.rangeBand() / 2)
          .attr("y2", y.rangeBand() / 2);

        rowLabels.append("text")
          .attr("x", -8)
          .attr("y", y.rangeBand() / 2)
          .attr("dy", ".32em")
          .attr("text-anchor", "end")
          .text(function (d, i) { return d; });

        var key = d3.select("#legend")
          .append("svg")
          .attr("width", widthLegend)
          .attr("height", height + margin.top + margin.bottom);

        var legend = key
          .append("defs")
          .append("svg:linearGradient")
          .attr("id", "gradient")
          .attr("x1", "100%")
          .attr("y1", "0%")
          .attr("x2", "100%")
          .attr("y2", "100%")
          .attr("spreadMethod", "pad");

        legend
          .append("stop")
          .attr("offset", "0%")
          .attr("stop-color", endColor)
          .attr("stop-opacity", 1);

        legend
          .append("stop")
          .attr("offset", "100%")
          .attr("stop-color", startColor)
          .attr("stop-opacity", 1);

        key.append("rect")
          .attr("width", widthLegend / 2 - 10)
          .attr("height", height)
          .style("fill", "url(#gradient)")
          .attr("transform", "translate(0," + margin.top + ")");

        var y = d3.scale.linear()
          .range([height, 0])
          .domain([minValue, maxValue]);

        var yAxis = d3.svg.axis()
          .scale(y)
          .orient("right");

        key.append("g")
          .attr("class", "y axis")
          .attr("transform", "translate(41," + margin.top + ")")
          .call(yAxis)
      }
    </script>
    </div>


    <div id="container" style="padding-left: 39px">
      <script type="text/javascript"> 
      </script>
    </div>

</body>


</html>