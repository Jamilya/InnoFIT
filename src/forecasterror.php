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
        
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src ="../lib/js/crossfilter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-tip/0.7.1/d3-tip.min.js"></script>
    <script src ="../lib/js/dc.js"></script>
    <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dc/1.7.5/dc.css"/>

	<style>


      body {
        margin: 0px;
      }

    .dc-chart .axis text {
    font: 12px sans-serif; }

    .dc-chart .brush rect.selection {
    fill: #4682b4;
    fill-opacity: .125; }

    .dc-chart .symbol {
    stroke: #000; 
    stroke-width: 0.5px;}

      .domain {
       /* display: none; */
        stroke: #635F5D;
        stroke-width: 1;
      }
      .tick text, .legendCells text {
        fill: #635F5D;
        font-size: 12px;
        font-family: sans-serif;
      }
      .axis-label, .legend-label {
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

    .d3-tip {
        line-height: 1;
        font-weight: bold;
        padding: 12px;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        border-radius: 2px;
    }

    /* Creates a small triangle extender for the tooltip */
        .d3-tip:after {
        box-sizing: border-box;
        display: inline;
        font-size: 10px;
        width: 100%;
        line-height: 1;
        color: rgba(0, 0, 0, 0.8);
        content: "\25BC";
        position: absolute;
        text-align: center;
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a  href="./finalorder.php">Final Order Amount</a></li>
                    <li><a href="./deliveryplans.php">Delivery Plans</a></li>
                     <li class = "active"><a href="./forecasterror.php">Forecast Error  <span class="sr-only">(current)</span></a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Error Measures</li>                            
                    <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.24.0/d3-legend.min.js"></script>
   <!-- <script src="https://cdn.rawgit.com/mozilla/localForage/master/dist/localforage.js"></script> -->
   
   <div style="padding-left:39px">
   <div id ="scatter">
   <!-- <p style="text-align:center;"><strong>Forecast Error graph</strong></p> -->
   <!-- <span class ="reset" style="display: none;">Range:<span class="filter"></span></span> -->
   <a class="reset" href="javascript:forecastErrorChart.filterAll(); dc.redrawAll();" style="display: none;">reset</a>
   <div class="clearfix"></div>
   </div>

<div id ="actuallist">
<p style="text-align:center;"> <strong>Actual Period</strong></p>
   <div>
      <!-- <a class='reset' href='javascript:actuallist.filterAll();dc.redrawAll();' style='visibility: hidden;'>reset</a> -->
    </div>
    <div class="clearfix"></div>
  </div>

  <div id ="product">
  <p style="text-align:center;"><strong>Product</strong></p>
   <div>
      <!-- <a class='reset' href='javascript:product.filterAll();dc.redrawAll();' style='visibility: hidden;'>reset</a> -->
    </div>
    <div class="clearfix"></div>
  </div>
  <div id ="pbd">
  <p style="text-align:center;"><strong>Periods Before Delivery</strong></p>
   <div>
      <!-- <a class='reset' href='javascript:pbd.filterAll();dc.redrawAll();' style='visibility: hidden;'>reset</a> -->
    </div>
  </div>
  <div style="clear: both"></div>
<br/>

   <div>
    <div class="dc-data-count">
    <span class="filter-count"></span> selected out of <span class="total-count"></span>records |  
    <a href ="javascript:dc.filterAll(); dc.renderAll();"> Reset all </a>
    </div><br/><br/>
    <button onclick="myFunction()">Data table display</button>
    <table class="table table-hover dc-data-table" id="myTable" style="display:none">
    </table>
    </div>
    <div id="test"></div>
    <br/>
    <div><br/>
    <svg width="960" height="500"></svg><br/>
    </div>
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
    var finalOrder = JSON.parse(localStorage['finalOrder']);
    var data = JSON.parse(localStorage['data']);

       const xValue = d => d.PeriodsBeforeDelivery;
      const xLabel = 'Periods Before Delivery';
      const yValue = d => d.Deviation * 100;
      const yLabel = 'Deviation';
      const colorValue = d => d.ActualPeriod;
      const colorLabel = 'Actual Period';
      const margin = { left: 55, right: 25, top: 20, bottom: 30 };
      const legendOffset = 52;

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
      
    const xAxis = d3.axisBottom(xScale);
    const yAxis = d3.axisLeft(yScale);


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
            let deviation = calcDeviation(el, valueMap.get(el.ForecastPeriod))
            return {
                ActualDate: el.ActualDate,
                ForecastDate: el.ForecastDate,
                ActualPeriod: el.ActualPeriod,
               ForecastPeriod: el.ForecastPeriod,
               OrderAmount: el.OrderAmount,
               Product: el.Product,
              FinalOrder: valueMap.get(el.ForecastPeriod),
               PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
               Deviation: deviation.toFixed(2)
            };
         })
         console.log("FINAL Array with deviation: ", finalArray);

      d3.json("/includes/getdata.php", function (error, data2) {
        
        xScale
            .domain([
                d3.min([0, d3.min(finalArray, function (d) { return d.PeriodsBeforeDelivery })]),
                d3.max([0, d3.max(finalArray, function (d) { return d.PeriodsBeforeDelivery })])
            ])
            .range([0, innerWidth])
            .nice();
        
          yScale
          .domain([
               d3.min(finalArray, function (d) { return (d.Deviation * 100) }),
               d3.max(finalArray, function (d) { return (d.Deviation * 100) })
               ])
          .range([innerHeight, 0])
          .nice();

   var actuallist = dc.selectMenu("#actuallist"),
    productChart = dc.selectMenu("#product"),
    periodsBeforeDeliveryChart = dc.selectMenu("#pbd"),
    visCount = dc.dataCount(".dc-data-count"),
    forecastErrorChart = dc.scatterPlot("#scatter"),
    visTable= dc.dataTable(".dc-data-table");


       fetch("/includes/getdata.php")
         .then(response => response.json())
         .then(json => {
        console.log("LOADED: ", json.length);

        finalArray.forEach(function(d){
            d.ActualDate= new Date(d.ActualDate);
        });

            var ndx = crossfilter (finalArray);
            var all = ndx.groupAll();
            var actualPeriodDim = ndx.dimension(function (d) { return +d.ActualPeriod;});
            var ndxDim = ndx.dimension(function (d) { return  [+d.PeriodsBeforeDelivery, +d.Deviation, +d.ActualPeriod];});
            var productDim = ndx.dimension(function(d) { return d.Product;}) ;
            var periodsBeforeDeliveryDim = ndx.dimension(function(d) { return +d.PeriodsBeforeDelivery;}) ;
            var forecastErrorDim = ndx.dimension(function(d) { return +d.Deviation ;}) ;
            var dateDim = ndx.dimension(function(d) { return +d.ActualDate;}) ;
            console.log("final array: ", finalArray);
            

            var actualPeriodGroup = actualPeriodDim.group();
            var productGroup = productDim.group();
            var ndxGroup = ndxDim.group().reduceSum(function(d) { return +d.Deviation;});
            var forecastErrorGroup = forecastErrorDim.group(function(d) { return d.Deviation;});
            var periodsBeforeDeliveryGroup = periodsBeforeDeliveryDim.group();
            var dateGroup = dateDim.group();
            console.log("ndxDim: ", ndxGroup.top(Infinity));
            

            actuallist
                .dimension(actualPeriodDim)
                .group(actualPeriodGroup)
                .multiple(true)
                .numberVisible(15);
                // .elasticX(true);

            productChart
                //.height(800)
                .dimension(productDim)
                .group(productGroup)
                .multiple(true)
                .numberVisible(15);

            periodsBeforeDeliveryChart
                .dimension(periodsBeforeDeliveryDim)
                .group(periodsBeforeDeliveryGroup)
                .multiple(true)
                .numberVisible(15);
                // .elasticX(true);
            var plotColorMap = d3.scaleOrdinal(d3.schemeCategory10);

            forecastErrorChart
                .width(768)
                .height(480)
                .dimension(ndxDim)
                .symbolSize(9)
                .group(ndxGroup)
                .data(function(group) {
                    return group.all()
                    .filter(function(d) { return d.key !== NaN || d.key !== Infinity || d.key !== undefined ; }); 
                })
                // .excludedSize(2)
                .excludedOpacity(0.5)
                .keyAccessor(function (d) { return d.key[0]; })
                .valueAccessor(function (d) { return d.key[1]; })
                .colorAccessor(function(d) { 
                    return d.key[2];
                 })
                .colors(function(colorKey) { 
                    return plotColorMap(colorKey); })
                .x(d3.scaleLinear().domain([0,100]))
                // .x(d3.scaleLinear().domain(d3.extent(finalArray, function(d){return d.PeriodsBeforeDelivery}))) 
                // .brushOn(true)
                .clipPadding(8)
                .xAxisLabel("Periods Before Delivery")
                .yAxisLabel("Deviation")
                .renderTitle(true)
                .title(function (d) {
                    return [
                        'Periods Before Delivery: ' + d.key[0],
                        'Deviation: ' + d.key[1],
                        'Actual Period: ' + d.key[2]
                ].join('\n');
                })
                .transitionDuration(500)
                // .mouseZoomable(true)
                .elasticX(true)
                .elasticY(true);

                forecastErrorChart.symbol(d3.symbolCircle);
                forecastErrorChart.margins().left = 50;
        
            visCount
                .dimension(ndx)
                .group(all);
            
            visTable
                .dimension(dateDim)
                .group(function(d){
                    var format = d3.format('02d');
                    return d.ActualDate.getFullYear() + '/'+ format((d.ActualDate.getMonth() + 1));
                })
                .columns([
                    "Product",
                    "ActualPeriod",
                    "ForecastPeriod",
                    "PeriodsBeforeDelivery",
                    "OrderAmount",
                    "Deviation" 
                    ]);


            dc.renderAll();

         }); 
    // var finalOrder = localforage['finalOrder'];
    // console.log(finalOrder);
    // var data = localforage['data'];

    

  
    


      
     

  
      const colorScale = d3.scaleOrdinal()
        .range(d3.schemeCategory10);


      const colorLegend = d3.legendColor()
        .scale(colorScale)
        .shape('circle');
   

        var Deviation = function (d) {
            return d.Deviation === (d.OrderAmount - d.FinalOrder) / d.FinalOrder;
        };




         //Specify Deviation
    
        var circle = g.selectAll('circle').data(finalArray)
          .enter().append('circle')

            .attr('cx', d => xScale(xValue(d)))
            .attr('cy', d => yScale(yValue(d)))
            .attr('fill', d => colorScale(colorValue(d)))
            .attr('fill-opacity', 1)
            .attr('r', 8)
            .attr('stroke','black')
             .attr('stroke-width',1)
             .style("display", function(d) { return d.Deviation == NaN ? "none" : "NaN"; })
             

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
          //.sort(d3.ascending(function(d) { return d.ActualPeriod; }))
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

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>