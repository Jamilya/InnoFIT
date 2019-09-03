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


  <title>Delivery Plans Matrix With Variance </title>

  <!-- <link href="/lib/css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
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



  <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script> -->


</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.php">Web tool home</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                    <!--  <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li > -->
            <li><a href="./about.php">About InnoFIT Web-tool</a></li>
            <li class><a href="./howto.php">How to Interpret Error Measures </a></li>
            <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a  href="./finalorder.php">Final Order Amount</a></li>
                    <li><a href="./deliveryplans.php">Delivery Plans</a></li>
                     <li><a href="./forecasterror.php">Forecast Error</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Error Measures</li>                            
                    <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD)</a></li>
                    <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                    <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                    <li><a href="./mpe.php">Mean Percentage Error (MPE)</a></li>
                    <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                    <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Matrices</li>
                    <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                    <li class = "active"><a href="./matrixvariance.php">Delivery Plans Matrix - With Variance <span class="sr-only">(current)</span></a></li>
                            <!-- <li role="separator" class="divider"></li>
                            <li class="dropdown-header">New Graphs</li>
                            <li>
                                <a class="dropdown-item" href="./boxplot.php">Box Plot</a>
                            </li> -->
                </ul>
            </li>
          <!-- </ul> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                </li>
        </ul>  
                <ul class="nav navbar-nav navbar-right">
                <li>
<!-- GTranslate: https://gtranslate.io/ -->
<a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl" style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png" height="12" width="12" alt="English" /></a><a href="#" onclick="doGTranslate('en|de');return false;" title="German" class="gflag nturl" style="background-position:-300px -100px;"><img src="//gtranslate.net/flags/blank.png" height="12" width="12" alt="German" /></a>

<style type="text/css">
a.gflag {vertical-align:middle;font-size:16px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/16.png);}
a.gflag img {border:0;}
a.gflag:hover {background-image:url(//gtranslate.net/flags/16a.png);}
#goog-gt-tt {display:none !important;}
.goog-te-banner-frame {display:none !important;}
.goog-te-menu-value:hover {text-decoration:none !important;}
body {top:0 !important;}
#google_translate_element2 {display:none!important;}
</style>

<div id="google_translate_element2"></div>
<script type="text/javascript">
function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
</script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


<script type="text/javascript">
/* <![CDATA[ */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
/* ]]> */
</script>
                </li>
                    <li><a href="/includes/logout.php">Logout</a></li>

            </ul>
        </div> <!--/.nav-collapse -->
    </div> <!--/.container-fluid -->
    </nav>


  <!-- <div class="container"> -->
  <script src="http://d3js.org/d3.v4.min.js"></script>
    <div style="padding-left:39px">
      <br>
      <h3>Delivery Plans Matrix With Forecast Error</h3>

      <small>
        <?php
        echo "You are logged in as: ";
        print_r($_SESSION["session_username"]);
        echo ".";
        ?></small>
      <br><br>
      <p> <b>Graph Description:</b> Forecast error matrix. </p>

    </div>
    <!-- <div style="display:inline-block;" id="legend"></div>
    <div style="display:inline-block; float:left" id="container"></div> -->
<div style="padding-left:39px">
<div id="my_dataviz"></div>
</div>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
    <script>
    
    let array = [];
    var deviation = JSON.parse(localStorage['deviation']);
    console.log("deviation array:", deviation);
    
    
    d3.json("/includes/getdata.php", function (error, data) {
        
        // let actualPeriods = d3.nest()
        // .key(function (d) { return d.ActualPeriod })
        // .entries(deviation);
        
        // console.log("actual periods length:", actualPeriods.length);

// set the dimensions and margins of the graph
var margin = {top: 30, right: 30, bottom: 30, left: 30},
  width = 450 - margin.left - margin.right,
  height  = 450 - margin.top - margin.bottom;

// append the svg object to the body of the page
var svg = d3.select("#my_dataviz")
.append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
.append("g")
  .attr("transform",
        "translate(" + margin.left + "," + margin.top + ")");

// Labels of row and columns
var myColumns = d3.map(deviation, function(d){return d.ActualPeriod;}).keys();
  var myRows = d3.map(deviation, function(d){return d.ForecastPeriod;}).keys();

  var x = d3.scaleBand()
    .range([ 0, width ])
    .domain(myColumns)
    .padding(0.05);
  svg.append("g")
    .style("font-size", 12 )
    .attr("dy", ".32em")
    .style("fill", "#000")
    .attr("transform", "translate(0," + height + ")")
    .call(d3.axisBottom(x).tickSize(0))
    .select(".domain").remove()
    

  // Build Y scales and axis:
  var y = d3.scaleBand()
    .range([ height, 0 ])
    .domain(myRows)
    .padding(0.05);
    

var LIKERT_NEUTRAL = Math.floor(1/7);
var LIKERT_POS = Math.round(3/7);


  svg.append("g")
    .style("font-size", 12)
    .attr("dy", ".32em")
    .style("fill", "#000")
    .call(d3.axisLeft(y).tickSize(0))
    .select(".domain").remove()

  // Build color scale
  var myColor = d3.scaleSequential()
    .interpolator(d3.interpolateRdBu)
    .domain([d3.min(deviation, function (d) { return d.Deviation }), d3.max(deviation, function (d) { return d.Deviation})  ]);

  var myColor2 = d3.scaleSequential()
    .interpolator(d3.interpolateBlues)
    .domain([d3.min(deviation, function (d) { return d.Deviation }), d3.max(deviation, function (d) { return d.Deviation})  ]);

var tooltip = d3.select("#my_dataviz")
    .append("div")
    .style("opacity", 0)
    .attr("class", "tooltip")
    .style("background-color", "white")
    .style("border", "solid")
    .style("border-width", "2px")
    .style("border-radius", "5px")
    .style("padding", "5px")
var mouseover = function(d) {
    tooltip
      .style("opacity", 1)
    d3.select(this)
      .style("stroke", "black")
      .style("opacity", 1)
  }
var mousemove = function(d) {
    tooltip
      .html("Deviation (Forecast error):<br> " + d.Deviation)
      .style("left", (d3.mouse(this)[0]+25) + "px")
      .style("top", (d3.mouse(this)[0]+25) + "px")
  }
  var mouseleave = function(d) {
    tooltip
      .style("opacity", 0)
    d3.select(this)
      .style("stroke", "none")
      .style("opacity", 0.8)
  }


  svg.selectAll()
    .data(deviation, function(d) {return d.ForecastPeriod+':'+d.ActualPeriod;})
    .enter()
    .append("rect")
      .attr("x", function(d) { return x(d.ActualPeriod) })
      .attr("y", function(d) { return y(d.ForecastPeriod) })
      .attr("rx", 4)
      .attr("ry", 4)
      .attr("width", x.bandwidth() )
      .attr("height", y.bandwidth() )
    //   .style("fill", function(d) { return myColor(d.Deviation)})
      .style("fill", function(d) { if (d.Deviation>=0) {  return myColor2(d.Deviation); } else { return myColor(d.Deviation);  } } )
      .style("stroke-width", 4)
      .style("stroke", "none")
      .style("opacity", 0.8)
    .on("mouseover", mouseover)
    .on("mousemove", mousemove)
    .on("mouseleave", mouseleave)

 var legend = svg.selectAll(".legend")
      .data(myColor.ticks(7).slice(1).reverse())
    .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(" + (width + 20) + "," + (20 + i * 20) + ")"; });

  legend.append("rect")
      .attr("width", 20)
      .attr("height", 20)
      .style("fill", myColor);

  legend.append("text")
      .attr("x", 26)
      .attr("y", 10)
      .attr("dy", ".41em")
      .text(String);

  svg.append("text")
      .attr("class", "label")
      .attr("x", width + 20)
      .attr("y", 10)
      .attr("dy", ".41em")
      .text("");


// Add title to graph
svg.append("text")
        .attr("x", 150)
        .attr("y", 420)
        .attr("text-anchor", "left")
        .style("font-size", "12px sans-serif")
        .style("fill", "#000")
        .text("Actual Period");

svg.append("text")
        .attr("x", -230)
        .attr("y", -17)
        .attr("text-anchor", "left")
        .style("font-size", "12px sans-serif")
        .style("fill", "#000")
        .attr("transform", "rotate(-90)")
        .text("Forecast Period");

// Add subtitle to graph
svg.append("text")
        .attr("x", 0)
        .attr("y", -20)
        .attr("text-anchor", "left")
        .style("font-size", "12px sans-serif")
        .style("fill", "#000")
        .style("max-width", 400);
        // .text("This is a chart of forecast error distribution per each period.");

svg.selectAll(".tile")
    // .transition().duration(transitionDuration)
    .style("fill", function(d) { return myColor(d.Deviation); });

svg.selectAll(".legend rect")
    .style("fill", myColor);

});

        
    
//          var row;
//          var matrix = [];
         
//          var k,j, i ;
         
//          var item, max;
//         //  var max = Object.keys(deviation).length;
//         // for (i=0; i<=deviation.length; i ++){
//         //     max = deviation[i].ActualPeriod.reduce((a, b)=> Math.max(a, b));
//         // };
//         function getMaxActual() {
//             return deviation.reduce((max, p) => p.ActualPeriod > max ? p.ActualPeriod : max, deviation[0].ActualPeriod);
//         };
//         function getMinActual() {
//             return deviation.reduce((min, p) => p.ActualPeriod < min ? p.ActualPeriod : min, deviation[0].ActualPeriod);
//         };
//         function getMaxForecast() {
//             return deviation.reduce((max, p) => p.ForecastPeriod > max ? p.ForecastPeriod : max, deviation[0].ForecastPeriod);
//         };
//         function getMinForecast() {
//             return deviation.reduce((min, p) => p.ForecastPeriod < min ? p.ForecastPeriod : min, deviation[0].ForecastPeriod);
//         };
//             console.log("Max number of Aperiods: ", getMaxActual());
//             console.log("min number of Aperiods: ", getMinActual());
//             console.log("Max number of Fperiods: ", getMaxForecast());
//             console.log("min number of Fperiods: ", getMinForecast());
         
//         //  var max = deviation.keys.ActualPeriod.reduce (function (a, b){
//         //      return Math.max(a, b);
//         //  });

//         var APmax=getMaxActual();
//         var APmin=getMinActual();
//         var FPmax=getMaxForecast();
//         var FPmin=getMinForecast();

//          k=-1;    
//         for ( i=0; i<actualPeriods.length; i++){
//                 var tempArray = [];
   
//             for (j=0; j<=actualPeriods.length; j++ ){
               
//                 if(i<=j) {
//                     k++; 
//                 tempArray.push((deviation[k].Deviation));
//                  } else {
//                     tempArray.push(0);
//                  }
//             }
//                  matrix.push(tempArray);
//         }
                  
//             function transposeArray(array, arrayLength){
//                 var newArray = [];
//                 for(var i = 0; i < array.length; i++){
//                     newArray.push([]);
//                 };
//                 for(var i = 0; i < array.length; i++){
//                     for(var j = 0; j < arrayLength; j++){
//                         newArray[j].push(array[i][j]);
//                     };
//                 };
//                 return newArray;
//             }
//             var matrixLen = matrix.length;
//             var newMatrix;
//             newMatrix = transposeArray(matrix, matrixLen);
//                // tempArray[i].push(data[i].OrderAmount);
//                 //matrix[i].push(0);
//               //  tempArray.push(data[i][j].OrderAmount);
//                 // const matrix = new Array(columns).fill(tempArray[j]);  
//                 //matrix[j].push(data[j].OrderAmount);
//                 //}
//                 //tempArray.push(data[j].OrderAmount);   
//                 //tempArray  = [];
          
//              //   matrix[j].push(data[k].OrderAmount);
//               //  matrix[j].push(data[i].OrderAmount);
//                 //matrix[j]=0;
//             //    const matrix = new Array(9).fill(tempArray[i]);
//             //   for (var j=0; i<data.length; j++){
//             //     tempArray.push(data[j].OrderAmount);
//             //     matrix.fill(tempArray[j]);
//             //   }
 
                 
//         console.log ("matrix:", newMatrix);
//         console.log ("tempArray:", tempArray);
//         console.log ("data[10]:", d3.max(deviation[10].ActualPeriod));
//         console.log ("data[10].OrderAmount:", deviation[10].OrderAmount);
//         console.log ("data:", data);
        
//         // function labelGen(){
//         //     labels = FPmax;
//         // }

//     var labels = ['CW1', 'CW2', 'CW3', 'CW4', 'CW5', 'CW6', 'CW7', 'CW8', 'CW9', 'CW10'];
    
//     Matrix({
//         container : '#container',
//         data      : newMatrix,
//         labels    : labels,
//         start_color : '#8B0000', //red 
//         middle_color : '#ffffff',
//         end_color : '#3498db' //blue color
//     });
//     function Matrix(options) {
// 	var margin = {top: 50, right: 50, bottom: 100, left: 100},
// 	    width = 450,
// 	    height = 450,
// 	    data = options.data,
// 	    container = options.container,
// 	    labelsData = options.labels,
// 	    startColor = options.start_color,
//         middleColor = options.middle_color,
// 	    endColor = options.end_color;
// 	var widthLegend = 100;
// 	if(!tempArray){
// 		throw new Error('Please pass data');
// 	}
// 	if(!Array.isArray(newMatrix) || !newMatrix.length || !Array.isArray(newMatrix[0])){
// 		throw new Error('It should be a 2-D array');
// 	}
//     var maxValue = d3.max(data, function(layer) { return d3.max(layer, function(d) { return d; }); });
//     var minValue = d3.min(data, function(layer) { return d3.min(layer, function(d) { return d; }); });
// 	var numrows = FPmax-FPmin +1 ;
// 	var numcols = FPmax-FPmin +1 ;
// 	var svg = d3.select(container).append("svg")
// 	    .attr("width", width + margin.left + margin.right)
// 	    .attr("height", height + margin.top + margin.bottom)
// 		.append("g")
// 	    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
// 	var background = svg.append("rect")
// 	    .style("stroke", "black")
// 	    .style("stroke-width", "2px")
// 	    .attr("width", width)
// 	    .attr("height", height);
// 	var x = d3.scale.ordinal()
// 	    .domain(d3.range(numcols))
// 	    .rangeBands([0, width]);
// 	var y = d3.scale.ordinal()
// 	    .domain(d3.range(numrows))
// 	    .rangeBands([0, height]);
// 	var colorMap = d3.scale.linear()
// 	    .domain([minValue, 0, maxValue])
// 	    .range([startColor, middleColor, endColor]);
  
// 	var row = svg.selectAll(".row")
// 	    .data(data)
// 	  	.enter().append("g")
// 	    .attr("class", "row")
// 	    .attr("transform", function(d, i) { return "translate(0," + y(i) + ")"; });
// 	var cell = row.selectAll(".cell")
// 	    .data(function(d) { return d; })
// 			.enter().append("g")
// 	    .attr("class", "cell")
// 	    .attr("transform", function(d, i) { return "translate(" + x(i) + ", 0)"; });
// 	cell.append('rect')
// 	    .attr("width", x.rangeBand())
// 	    .attr("height", y.rangeBand())
// 	    .style("stroke-width", 0);
//     cell.append("text")
// 	    .attr("dy", ".32em")
// 	    .attr("x", x.rangeBand() / 2)
// 	    .attr("y", y.rangeBand() / 2)
// 	    .attr("text-anchor", "middle")
// 	    .style("fill", function(d, i) { return d >= 0 ? 'blue' : 'white'; })
// 	    .text(function(d, i) { return d; });
// 	row.selectAll(".cell")
// 	    .data(function(d, i) { return data[i]; })
// 	    .style("fill", colorMap);
// 	var labels = svg.append('g')
// 		.attr('class', "labels");
// 	var columnLabels = labels.selectAll(".column-label")
// 	    .data(labelsData)
// 	    .enter().append("g")
// 	    .attr("class", "column-label")
// 	    .attr("transform", function(d, i) { return "translate(" + x(i) + "," + height + ")"; });
// 	columnLabels.append("line")
// 		.style("stroke", "black")
// 	    .style("stroke-width", "1px")
// 	    .attr("x1", x.rangeBand() / 2)
// 	    .attr("x2", x.rangeBand() / 2)
// 	    .attr("y1", 0)
// 	    .attr("y2", 5);
// 	columnLabels.append("text")
// 	    .attr("x", 0)
// 	    .attr("y", y.rangeBand() / 2)
// 	    .attr("dy", ".82em")
// 	    .attr("text-anchor", "end")
// 	    .attr("transform", "rotate(-60)")
// 	    .text(function(d, i) { return d; });
// 	var rowLabels = labels.selectAll(".row-label")
// 	    .data(labelsData)
// 	  .enter().append("g")
// 	    .attr("class", "row-label")
// 	    .attr("transform", function(d, i) { return "translate(" + 0 + "," + y(i) + ")"; });
// 	rowLabels.append("line")
// 		.style("stroke", "black")
// 	    .style("stroke-width", "1px")
// 	    .attr("x1", 0)
// 	    .attr("x2", -5)
// 	    .attr("y1", y.rangeBand() / 2)
// 	    .attr("y2", y.rangeBand() / 2);
// 	rowLabels.append("text")
// 	    .attr("x", -8)
// 	    .attr("y", y.rangeBand() / 2)
// 	    .attr("dy", ".32em")
// 	    .attr("text-anchor", "end")
// 	    .text(function(d, i) { return d; });
//     var key = d3.select("#legend")
//     .append("svg")
//     .attr("width", widthLegend)
//     .attr("height", height + margin.top + margin.bottom);

//     var legend = key
//     .append("defs")
//     .append("svg:linearGradient")
//     .attr("id", "gradient")
//     .attr("x1", "50%")
//     .attr("y1", "50%")
//     .attr("x2", "50%")
//     .attr("y2", "100%")
//     .attr("spreadMethod", "pad");
//     legend
//     .append("stop")
//     .attr("offset", "0%")
//     .attr("stop-color", endColor)
//     .attr("stop-opacity", 1);
//     legend
//     .append("stop")
//     .attr("offset", "33%")
//     .attr("stop-color", endColor)
//     .attr("stop-opacity", 0.1);
//     legend
//     .append("stop")
//     .attr("offset", "66%")
//     .attr("stop-color", middleColor)
//     .attr("stop-opacity", 0.5);
//     // legend
//     // .append("stop")
//     // .attr("offset", "0%")
//     // .attr("stop-color", startColor)
//     // .attr("stop-opacity", 0.1);
//     // legend
//     // .append("stop")
//     // .attr("offset", "100%")
//     // .attr("stop-color", startColor)
//     // .attr("stop-opacity", 1);
//     key.append("rect")
//     .attr("width", widthLegend/2-10)
//     .attr("height", height)
//     .style("fill", "url(#gradient)")
//     .attr("transform", "translate(0," + margin.top + ")");
//     var y = d3.scale.linear()
//     .range([height, 0])
//     .domain([minValue, maxValue]);
//     var yAxis = d3.svg.axis()
//     .scale(y)
//     .orient("right");
//     key.append("g")
//     .attr("class", "y axis")
//     .attr("transform", "translate(41," + margin.top + ")")
//     .call(yAxis)
// };
// //};
//     });
//     </script>
    

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>


</html>