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
    <title>Corrected Root Mean Square Error (RMSE) </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
        crossorigin="anonymous">

    <style>
      body {
        margin: 0px;
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
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
            <li><a href="./about.php">About this tool</a></li>
            <li class="dropdown" class = "active">
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
                    <li ><a href="./matrixvariance.php">Delivery Plans Matrix - With Variance </a></li>
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
                            <li class = "active"><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) <span class="sr-only">(current)</span></a></li>
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

    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>

    
       <div style="padding-left:3px"> 

            <h3>Corrected Root Mean Square Error (CRMSE)</h3>
            <small>
                <?php
                echo "You are logged in as: ";
                print_r($_SESSION["session_username"]);
                echo ".";
                ?></small>
                <br><br>
            <p> <b>Graph Description:</b>  This graph shows an corrected estimation of Root Mean Square Error (RMSE) with respect to periods before delivery (PBD).
                <br> The Formula of the Corrected Root Mean Square Error (CRMSE) is: <img src="https://latex.codecogs.com/gif.latex?CRMSE_{j} = \sqrt{\frac{1}{n}\sum_{1}^{n}(x_{i,0}-(x_{i,j}*\frac{1}{MFB_{j}}))^{2}}" title="Corrected RMSE_1" /> , <br>
                 where MFB (Mean Forecast Bias) = <img src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}" title="Mean Forecast Bias formula"/>
                </p> 
        </div>

        <script>
        d3.json("/includes/getdata.php", function (error, data) {
            if (error) throw error;
            //console.log(data);

                let finalOrder = data.filter((el) => {
                    return el.PeriodsBeforeDelivery == 0;
                });
               // console.log("FINAL ORDERS: ", finalOrder);

                /*             let squaredVal = function (absDiff){
                                    return Math.sqrt(absDiff);
                            };
                            console.log("SQUARED VAL: ", squaredVal); */

            let uniqueArray = data.filter(function (obj) { return finalOrder.indexOf(obj) == -1; });
              //  console.log("Unique array: ", uniqueArray);

            let sumOfAllFinalOrders = finalOrder.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
            console.log('Sum of all final Orders: ', sumOfAllFinalOrders);

                let dataGroupedByPBD = d3.nest()
                    .key(function(d) { return d.PeriodsBeforeDelivery; })
                    .entries(uniqueArray);
               // console.log('Grouped data: ', dataGroupedByPBD);

               

            let finalForecastBias = dataGroupedByPBD.map((val) => {
                let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
                    //console.log('sum for pbd: ', val.key, ' sum: ', sum);
                    let finalForecastBiasPBD = sum / sumOfAllFinalOrders;
                    //console.log('Final Forecast Bias by PBD: ', finalForecastBiasPBD);

                    return {
                        PeriodsBeforeDelivery: val.key,
                        ForecastBiasPBD: finalForecastBiasPBD
                    };
                });

            console.log('Final Forecast Bias: ', finalForecastBias);

            var dataMean = d3.mean(finalForecastBias, function (d) { //Define mean value of Order Amount, i.e. Avg. Order Amount
                return d.ForecastBiasPBD;
            });

                // let finalMFB = dataGroupedByPBD.map((val) => {
                //     let sum = val.values.map(item => item.OrderAmount).reduce((a, b) => +a + +b);
                //       //  console.log('sum for pbd: ', val.key, ' sum: ', sum);
                //         let finalForecastBiasPBD = sum / sumOfAllFinalOrders;
                //       //  console.log('MFB by PBD: ', finalForecastBiasPBD);

                //         return {
                //             PeriodsBeforeDelivery: val.key,
                //             ForecastBiasPBD: finalForecastBiasPBD
                //         };
                //     });

            let newValueMap = new Map();
            finalForecastBias.forEach((val) => {
                let keyString = val.PeriodsBeforeDelivery;
                let valueString = val.ForecastBiasPBD;
                newValueMap.set(keyString, valueString);
            });

                let divisionArray = uniqueArray.map((el) => {
                let divisionOne = (el.OrderAmount/ newValueMap.get(el.ForecastPeriod));
                return {
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    Product: el.Product,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    AbsoluteDiff: divisionOne
                };
            });

            
            let seperatedByPeriods = d3.nest()
                .key(function (d) { return d.PeriodsBeforeDelivery })
                .entries(divisionArray);

                let squaredDiff = function (orignalEl, divisionArray) {
                return Math.pow((orignalEl.OrderAmount - divisionArray), 2);
                }

                let squaredDifference = uniqueArray.map((el) => {
                let value = squaredDiff(el, newValueMap.get(el.PeriodsBeforeDelivery));
                return {
                    ActualPeriod: el.ActualPeriod,
                    ForecastPeriod: el.ForecastPeriod,
                    OrderAmount: el.OrderAmount,
                    Product: el.Product,
                    PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                    SquaredDiff: value
                };
            });
                console.log("squared Diff: ", squaredDifference);

                let newCalcMap = new Map();
                let divisionCalc = finalForecastBias.forEach((el) =>{
                    uniqueArray.forEach((val) => {
                    let keyString = val.PeriodsBeforeDelivery;
                    let valueString = val.OrderAmount / el.ForecastBiasPBD;
                    newCalcMap.set(keyString, valueString);

                })
                });

                let seperatedByPeriodsTwo = d3.nest()
                    .key(function (d) { return d.PeriodsBeforeDelivery })
                    .entries(squaredDifference);

                let bubu = seperatedByPeriodsTwo.map((el) => {
                    let meanValue = Math.sqrt (d3.mean(el.values, function (d) { return d.SquaredDiff; }),2);
                    return {
                        Product: el.Product,
                        ActualPeriod: el.ActualPeriod,
                        ForecastPeriod: el.ForecastPeriod,
                        OrderAmount: el.OrderAmount,
                        PeriodsBeforeDelivery: el.key,
                        MeanOfThisPeriod: meanValue
                    };
                });
                console.log("final Array: ", bubu);

                // let absValuesArray = newArr.map((el) => {
                // let difference = squaredDiff(el, finalOrder.get(el.PeriodsBeforeDelivery));
                // console.log(el);
                // return {
                //     ActualPeriod: el.ActualPeriod,
                //     ForecastPeriod: el.ForecastPeriod,
                //     OrderAmount: el.OrderAmount,
                //     Product: el.Product,
                //     PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                //     DifferenceCalc: difference
                // };
                // });


                // console.log("valueMap: ", bubu2);

                
                //var newArr = bubu.map(({ value }) => value);

            //     let dataGrouped = d3.nest()
            //     .key(function(d) { return d.PeriodsBeforeDelivery; })
            //     .entries(newCalcMap);
            //     console.log("difference: ", dataGrouped);

            //     let absValuesArray = dataGrouped.map((el) => {
            //              finalOrder.forEach((val) => {
            //         let difference =  val.OrderAmount / el.key.value;
            //         console.log("difference: ", difference);
            //     return {
            //         ActualPeriod: val.ActualPeriod,
            //         ForecastPeriod: val.ForecastPeriod,
            //         OrderAmount: val.OrderAmount,
            //         Product: val.Product,
            //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            //         DifferenceCalc: difference
            //     };
            //     })
            // });
            //     console.log("absValuesArray: ", absValuesArray);


                
                // let divisionCalc = function (orignalEl, finalForecastBias) {
                // return orignalEl.OrderAmount / ForecastBiasPBD;
                // }
 
            //     let finalMFBgroup = new Map();
            //     finalForecastBias.forEach((val) => {
            //      let keyString = val.PeriodsBeforeDelivery;
            //      let valueString = val.ForecastBiasPBD;
            //      finalMFBgroup.set(keyString, valueString);
            //     });
            //     //console.log('Final MFB: ', finalMFBgroup);

            //     let dataGroupedByPBD = d3.nest()
            //     .key(function(d) { return d.PeriodsBeforeDelivery; })
            //     .entries(uniqueArray);
            //    // console.log('Grouped data: ', dataGroupedByPBD);


            //    let divCalc = uniqueArray.map((el) => {
            //     let division = divis(el, finalMFBgroup.get(el.PeriodsBeforeDelivery));
            //     return {
            //         ActualPeriod: el.ActualPeriod,
            //         ForecastPeriod: el.ForecastPeriod,
            //         OrderAmount: el.OrderAmount,
            //         Product: el.Product,
            //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
            //         Division: division

            //     };
            //  });
            //  console.log('Division calculation: ', divCalc);

        //              let divisionGroup = new Map();
        //              divCalc.forEach((value) => {
        //              let keyString = value.ForecastPeriod;
        //              let valueString = value.Division;
        //              divisionGroup.set(keyString, valueString);
        //               });
        //               console.log('Division group: ', divisionGroup);

                    //   let powerDiff = function (orignalEl, finalOrder) {
                    //     return Math.pow((finalOrder - orignalEl.Division ), 2);
                    //   }

                    // let powerDiff = function (orignalEl, newCalcMap) {
                    // return Math.pow((orignalEl.OrderAmount - newCalcMap), 2);
                    // }

        //              let valueMap = new Map();
        //             finalOrder.forEach((val) => {
        //             let keyString = val.ActualPeriod;
        //             let valueString = val.OrderAmount;
        //             valueMap.set(keyString, valueString);
        //             });

                //     let squaredDiffArray = divCalc.map((el) => {
                //     let difference = powerDiff(el, finalOrder.get(el.PeriodsBeforeDelivery));
                //     return {
                //         ActualPeriod: el.ActualPeriod,
                //         ForecastPeriod: el.ForecastPeriod,
                //         OrderAmount: el.OrderAmount,
                //         Product: el.Product,
                //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
                //         Difference: difference
                //     };
                // });


            //     let finalCrmse = seperatedByPeriods.map((el) => {
            //         let crmseCalc = Math.sqrt (d3.mean(el.values, function (d) { return d.Difference; }),2);
            //         return {
            //             PeriodsBeforeDelivery: el.key,
            //             CRMSEOfThisPeriod: crmseCalc
            //         };
            //     });
            //    console.log("Final CRMSE: ", finalCrmse);

                        

            //     });
                    


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


                var legendOffset = 140;

                var margin = { top: 20, right: 25, bottom: 30, left: 55 },
                    width = 960 - margin.left - margin.right,
                    height = 590 - margin.top - margin.bottom - legendOffset;

                var x = d3.scale.linear()
                    .domain([
                        d3.min([0, d3.min(bubu, function (d) { return d.PeriodsBeforeDelivery })]),
                        d3.max([0, d3.max(bubu, function (d) { return d.PeriodsBeforeDelivery })])
                    ])
                    .range([0, width])

                var y = d3.scale.linear()
                    .domain([
                        d3.min([0, d3.min(bubu, function (d) { return (d.MeanOfThisPeriod) })]),
                        d3.max([0, d3.max(bubu, function (d) { return (d.MeanOfThisPeriod) })])
                    ])
                    .range([height, 0])

                var PeriodsBeforeDelivery = function (d) { return d.PeriodsBeforeDelivery; },
                    color = d3.scale.category10();

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
                    .data(bubu)
                    .enter()
                    .append('circle')
                    .attr('cx', function (d) { return x(d.PeriodsBeforeDelivery) })
                    .attr('cy', function (d) { return y(d.MeanOfThisPeriod) })
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
                        return 'Periods Before Delivery: ' + d.PeriodsBeforeDelivery +
                            '\nCRMSE of this period: ' + d.MeanOfThisPeriod
                        //'\nPeriods Before Delivery: ' + d.PeriodsBeforeDelivery 
                        //'\nOrder Amount: ' + d.OrderAmount
                    })

                svg.append("g")
                    .attr("class", "x axis")
                    .attr("transform", "translate(0," + height + ")")
                    .call(xAxis)
                    .append("text")
                    .attr("class", "label")
                    .attr("x", width)
                    .attr("y", 2)
                    .attr('dy', '.60em')
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
                    .attr("dy", ".45em")
                    .style("text-anchor", "end")
                    .text("Corrected Root Mean Square Error (CRMSE)")


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
      </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

</body>

</html>