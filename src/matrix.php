<?php
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
else {
    header("Location: includes/login.php");
};?>


<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/data/ico/innofit.ico">


    <title>Delivery Plans Matrix</title>

    <link rel="stylesheet" href="/lib/css/bootstrap.min.css">
    <style>
      body {
        margin: 0px;
      }
        td,
        th {
            padding: 2px 4px;
        }

        th {
            font-weight: bold;
        }
        .axis text {
            font: 10px sans-serif;
        }

        .axis line, .axis path {
            fill: none;
            stroke: #000;
            shape-rendering: crispEdges;
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
                                <a class="dropdown-item active" href="./matrix.php">Delivery Plans Matrix</a>
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
    <!-- <script src="http://d3js.org/d3.v4.min.js"></script> -->
    <!-- <div class="container"> -->

        <div style="padding-left:39px">
            <br>
            <h3>Delivery Plans Matrix</h3>
            <small>
                <?php
                echo "You are logged in as: ";
                print_r($_SESSION["session_username"]);
                echo ".";
                ?></small>

            <br><br>
            <p>  <b>Graph Description:</b> Delivery plans matrix. </p>
    
        </div>
        <div style="display:inline-block;" id="legend"></div>
    <div style="display:inline-block; float:left" id="container"></div>

        <script>

        // d3.json("/includes/getdata.php", function (error, data) {
        //     if (error) throw error;
            //console.log(data);
            // var n = 10; //Create an empty array first in the structure of a triangular matrix
            // var newArray = new Array [n];
            // for (var i=1; i<n; i++){
            //     newArray [i] = new Array [n-1];
            // }


    let array = [];
    d3.json("/includes/getdata.php", function (error, data) {
    if (error) throw error;
         var row;
         var matrix = [];
         
         var k,j, i ;
         
         var item;
         k=-1;    

        for ( i=0; i<10; i++){
                var tempArray = [];
    
                //matrix.push( [] );
               // item = matrix[j] || (matrix[j] = []);

            for (j=0; j<10; j++ ){
    
                if(i<=j) {
                    k++; 
              //  tempArray[i][j]
                tempArray.push((data[k].OrderAmount));
                 } else { 
                    tempArray.push(0);
                 //tempArray[i][j] = data[i-1][j].OrderAmount + data[i-1][j-1].OrderAmount;
                  }
            }
                matrix.push(tempArray);
                 
        }
                //transpose = matrix => matrix[0].map((i,j) => matrix.map(i => i[j]))
                // matrix[0].map((j, i) => matrix.map(row => row[i]));
                // console.log("hello user we are here:", matrix);
                
            function transposeArray(array, arrayLength){
                var newArray = [];
                for(var i = 0; i < array.length; i++){
                    newArray.push([]);
                };

                for(var i = 0; i < array.length; i++){
                    for(var j = 0; j < arrayLength; j++){
                        newArray[j].push(array[i][j]);
                    };
                };

                return newArray;
            }
            var matrixLen = matrix.length;
            var newMatrix;
            newMatrix = transposeArray(matrix, matrixLen);

               // tempArray[i].push(data[i].OrderAmount);
                //matrix[i].push(0);
              //  tempArray.push(data[i][j].OrderAmount);
                // const matrix = new Array(columns).fill(tempArray[j]);  
                //matrix[j].push(data[j].OrderAmount);
                //}
                //tempArray.push(data[j].OrderAmount);   
                //tempArray  = [];
          
             //   matrix[j].push(data[k].OrderAmount);
              //  matrix[j].push(data[i].OrderAmount);
                //matrix[j]=0;
            //    const matrix = new Array(9).fill(tempArray[i]);
            //   for (var j=0; i<data.length; j++){
            //     tempArray.push(data[j].OrderAmount);
            //     matrix.fill(tempArray[j]);
            //   }
                 
        console.log ("matrix:", newMatrix);
        console.log ("tempArray:", tempArray);
        console.log ("data[10]:", d3.max(data[10].ActualPeriod));
        console.log ("data[10].OrderAmount:", data[10].OrderAmount);
        console.log ("data:", data);
        
    //     for (let i = 0; i < data.length; i++) {
    //     if (i === 3) {
    //     break;
    //     }
    //     const tempArray = [];
    //     tempArray.push(data[i]);
    
    //     const finalArray = fillZeros(tempArray, maxLen);
    //     array.push(finalArray);
    //     }

    // function fillZeros(array, maxLen) {
    //    let realLength = maxLen - array.length;
    
    //     for (let k = 0; k < realLength; k++) {
    //     array.push(0);
    //     }
    // return array;
    // }

    // console.log('Array: ', array);


    var labels = ['CW1', 'CW2', 'CW3', 'CW4', 'CW5', 'CW6', 'CW7', 'CW8', 'CW9', 'CW10'];

    Matrix({
        container : '#container',
        data      : newMatrix,
        labels    : labels,
        start_color : '#ffffff',
        end_color : '#3498db'
    });

    function Matrix(options) {
	var margin = {top: 50, right: 50, bottom: 100, left: 100},
	    width = 450,
	    height = 450,
	    data = options.data,
	    container = options.container,
	    labelsData = options.labels,
	    startColor = options.start_color,
	    endColor = options.end_color;

	var widthLegend = 100;

	if(!tempArray){
		throw new Error('Please pass data');
	}

	if(!Array.isArray(newMatrix) || !newMatrix.length || !Array.isArray(newMatrix[0])){
		throw new Error('It should be a 2-D array');
	}

    var maxValue = d3.max(data, function(layer) { return d3.max(layer, function(d) { return d; }); });
    var minValue = d3.min(data, function(layer) { return d3.min(layer, function(d) { return d; }); });

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
	    .domain([minValue,maxValue])
	    .range([startColor, endColor]);

	var row = svg.selectAll(".row")
	    .data(data)
	  	.enter().append("g")
	    .attr("class", "row")
	    .attr("transform", function(d, i) { return "translate(0," + y(i) + ")"; });

	var cell = row.selectAll(".cell")
	    .data(function(d) { return d; })
			.enter().append("g")
	    .attr("class", "cell")
	    .attr("transform", function(d, i) { return "translate(" + x(i) + ", 0)"; });

	cell.append('rect')
	    .attr("width", x.rangeBand())
	    .attr("height", y.rangeBand())
	    .style("stroke-width", 0);

    cell.append("text")
	    .attr("dy", ".32em")
	    .attr("x", x.rangeBand() / 2)
	    .attr("y", y.rangeBand() / 2)
	    .attr("text-anchor", "middle")
	    .style("fill", function(d, i) { return d >= maxValue/2 ? 'white' : 'black'; })
	    .text(function(d, i) { return d; });

	row.selectAll(".cell")
	    .data(function(d, i) { return data[i]; })
	    .style("fill", colorMap);

	var labels = svg.append('g')
		.attr('class', "labels");

	var columnLabels = labels.selectAll(".column-label")
	    .data(labelsData)
	    .enter().append("g")
	    .attr("class", "column-label")
	    .attr("transform", function(d, i) { return "translate(" + x(i) + "," + height + ")"; });

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
	    .text(function(d, i) { return d; });

	var rowLabels = labels.selectAll(".row-label")
	    .data(labelsData)
	  .enter().append("g")
	    .attr("class", "row-label")
	    .attr("transform", function(d, i) { return "translate(" + 0 + "," + y(i) + ")"; });

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
	    .text(function(d, i) { return d; });

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
    .attr("width", widthLegend/2-10)
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
};
//};

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
