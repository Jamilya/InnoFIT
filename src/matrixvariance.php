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
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="../lib/js/localforage.js"></script>
    <script>
    localforage.config({
        driver: localforage.WEBSQL, // Force WebSQL; same as using setDriver()
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
    body {
        margin: 0px;
    }

    .domain {
        /* display: none; */
        stroke: #635F5D;
        stroke-width: 1;
    }

    .tick text,
    .legendCells text {
        fill: #635F5D;
        font-size: 12px;
        font-family: sans-serif;
    }

    .axis-label,
    .legend-label {
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

    div {
        padding-right: 10px;
        padding-left: 10px;
    }

    .info-container {
        display: inline-block;
        width: calc(100% + -50px);
        vertical-align: middle;
    }

    .customContainer {
        padding: 0 3% 0 3%;
    }

    a.gflag {
        vertical-align: middle;
        font-size: 12px;
        padding: 1px 0;
        background-repeat: no-repeat;
        background-image: url(//gtranslate.net/flags/16.png);
    }

    a.gflag img {
        border: 0;
    }

    a.gflag:hover {
        background-image: url(//gtranslate.net/flags/16a.png);
    }

    #goog-gt-tt {
        display: none !important;
    }

    .goog-te-banner-frame {
        display: none !important;
    }

    .goog-te-menu-value:hover {
        text-decoration: none !important;
    }

    body {
        top: 0 !important;
    }

    #google_translate_element2 {
        display: none !important;
    }
    </style>

</head>

<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="./configuration.php">Configuration</a></li>
                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
                            <li class="active"><a href="./matrixvariance.php">Delivery Plans Matrix with Percentage
                                    Error <span class="sr-only">(current)</span></a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Forecast Error Measures</li>
                            <li><a href="./mad_graph.php">Mean Absolute Deviation (MAD) </a></li>
                            <li> <a href="./mse_graph.php">Mean Square Error (MSE)</a></li>
                            <li><a href="./rmse_graph.php">Root Mean Square Error (RMSE)</a></li>
                            <li><a href="./normalized_rmse.php">Normalized Root Mean Square Error (RMSE*)</a></li>
                            <li><a href="./mpe.php">Mean Percentage Error (MPE) </a></li>
                            <li><a href="./mape.php">Mean Absolute Percentage Error (MAPE)</a></li>
                            <li><a href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <!-- GTranslate: https://gtranslate.io/ -->
                        <a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl"
                            style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="English" /></a><a href="#"
                            onclick="doGTranslate('en|de');return false;" title="German" class="gflag nturl"
                            style="background-position:-300px -100px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="German" /></a>

                        <div id="google_translate_element2"></div>
                        <script type="text/javascript">
                        function googleTranslateElementInit2() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                autoDisplay: false
                            }, 'google_translate_element2');
                        }
                        </script>
                        <script type="text/javascript"
                            src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
                        </script>


                        <script type="text/javascript">
                        /* <![CDATA[ */
                        eval(function(p, a, c, k, e, r) {
                            e = function(c) {
                                return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String
                                    .fromCharCode(c + 29) : c.toString(36))
                            };
                            if (!''.replace(/^/, String)) {
                                while (c--) r[e(c)] = k[c] || e(c);
                                k = [function(e) {
                                    return r[e]
                                }];
                                e = function() {
                                    return '\\w+'
                                };
                                c = 1
                            };
                            while (c--)
                                if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
                            return p
                        }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',
                            43, 43,
                            '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'
                            .split('|'), 0, {}))
                        /* ]]> */
                        </script>
                    </li>
                    <li><a href="/includes/logout.php">Logout</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-10">
                <h3>Percentage Error Matrix</h3>
                <small>
                    <?php
        echo "You are logged in as: ";
        print_r($_SESSION["session_username"]);
        echo ".";
        ?></small>
                <br>
            </div>
            <div class="col-md-2">
                <div id="filterInfo" class="alert alert-info" style="text-align: center" role="info">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-info" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-info"
                                role="info">Filters are applied!</span>
                        </div>
                        <div class="row">
                            <span style="font-size: 12px; vertical-align: middle;" class="alert-info" role="info"> To
                                change settings please visit <a href="./configuration.php">Configuration</a>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br />
                <p> <b>Graph Description:</b> Forecast (percentage) error matrix. </p>
            </div>
        </div>

        <div class="row">
            <div id="my_dataviz"></div>
        </div>
    </div>
    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
    <script>
    $(document).ready(function() {
        if (localStorage.getItem('checkFiltersActive') === 'true') {
            $('#filterInfo').show();
        } else {
            $('#filterInfo').hide();
        }
    });
    let array = [];

    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);
        let calcDeviation = function(orignalEl, finalOrder) {
            return (orignalEl.OrderAmount - finalOrder) / finalOrder;
        }

        let finalOrder = data.filter((el) => {
            return el.PeriodsBeforeDelivery == 0;
        });

        console.log("Final Orders: ", finalOrder);

        let valueMap = new Map();

        finalOrder.forEach((val) => {
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
        oneArray = finalArray.filter((el) => {
            return !isNaN(el.Deviation);
        })
        newFinalArray = oneArray.filter((el) => {
            return isFinite(el.Deviation) == true;
        })

        newFinalArray = newFinalArray.sort((a, b) => {
            return d3.ascending(a.ActualDate, b.ActualDate);
        });

        newFinalArray = newFinalArray.sort((a, b) => {
            return d3.ascending(a.ForecastDate, b.ForecastDate);
        });


        var margin = {
                top: 10,
                right: 90,
                bottom: 80,
                left: 60
            },
            width = 900 - margin.left - margin.right,
            height = 650 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        var svg = d3.select("#my_dataviz")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

        // Labels of row and columns
        var myColumns = d3.map(newFinalArray, function(d) {
            return d.ActualPeriod;
        }).keys();
        var myRows = d3.map(newFinalArray, function(d) {
            return d.ForecastPeriod;
        }).keys();


        var extent = d3.extent(newFinalArray.map(function(d) {
            return d.Deviation;
        }).filter(function(d) {
            return d;
        }));
        console.log("extent: ", extent);

        var x = d3.scaleBand()
            .range([0, width])
            .domain(myColumns)
            .padding(0.05);
        svg.append("g")
            .style("font-size", 12)
            .attr("dy", ".32em")
            .style("fill", "#000")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x).tickSize(0))
            .select(".domain").remove()


        // Build Y scales and axis:
        var y = d3.scaleBand()
            .range([height, 0])
            .domain(myRows)
            .padding(0.05);


        var LIKERT_NEUTRAL = Math.floor(1 / 7);
        var LIKERT_POS = Math.round(3 / 7);


        svg.append("g")
            .style("font-size", 12)
            .attr("dy", ".32em")
            .style("fill", "#000")
            .call(d3.axisLeft(y).tickSize(0))
            .select(".domain").remove()

        // Build color scale
        var myColor = d3.scaleSequential();
        myColor.interpolator(d3.interpolateRdBu);

        // myColor.domain([d3.min(newFinalArray, function(d) {
        //     return d.Deviation;
        // }), d3.max(newFinalArray, function(d) {
        //     return d.Deviation;
        // })]);

        myColor.domain([d3.min(newFinalArray, function(d) {
            return d.Deviation;
        }), d3.max(newFinalArray, function(d) {
            return d.Deviation;
        })]);
        var myOrders = newFinalArray.map(function(d) {
            return (d.Deviation);
        });

        var myColor2 = d3.scaleSequential()
            .interpolator(d3.interpolateBlues)
            .domain([d3.min(newFinalArray, function(d) {
                return d.Deviation
            }), d3.max(newFinalArray, function(d) {
                return d.Deviation
            })]);

        var tooltip = d3.select("#my_dataviz")
            .append("div")
            .style("opacity", 0)
            .attr("class", "tooltip")
            .style("background-color", "white")
            .style("border", "solid")
            .style("border-width", "2px")
            .style("border-radius", "5px")
            .style("padding", "2px")

        var mouseover = function(d) {
            tooltip
                .style("opacity", 1)
            d3.select(this)
                .style("stroke", "black")
                .style("opacity", 1)
        }
        var mousemove = function(d) {
            tooltip
            .html("Product: " + d.Product + "<br>"+ "Percentage error: " + d.Deviation  + "<br>" + "Actual Period: " + d.ActualPeriod + "<br>" + "Forecast Period: " +d.ForecastPeriod + "<br>")
                .style("left", (d3.event.pageX + 20) + "px")
                .style("top", (d3.event.pageY + 10) + "px")
        }
        var mouseleave = function(d) {
            tooltip
                .style("opacity", 0)
            d3.select(this)
                .style("stroke", "none")
                .style("opacity", 0.8)
        }


        svg.selectAll()
            .data(newFinalArray, function(d) {
                return d.ForecastPeriod + ':' + d.ActualPeriod;
            })
            .enter()
            .append("rect")
            .attr("x", function(d) {
                return x(d.ActualPeriod)
            })
            .attr("y", function(d) {
                return y(d.ForecastPeriod)
            })
            .attr("rx", 4)
            .attr("ry", 4)
            .attr("width", x.bandwidth())
            .attr("height", y.bandwidth())
            // .style("fill", function(d) {
            //     return myColor(d.Deviation)
            // })
            .style("fill", function(d) {
                if (d.Deviation >= 0) {
                    return myColor2(d.Deviation);
                } else {
                    return myColor(d.Deviation);
                }
            })
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
            .attr("transform", function(d, i) {
                return "translate(" + (width + 20) + "," + (20 + i * 20) + ")";
            });

        legend.append("rect")
            .attr("width", 20)
            .attr("height", 20)
            .attr("x", 5)
            .attr("y", 10)
            .style("fill", myColor);

        legend.append("text")
            .attr("x", 28)
            .attr("y", 10)
            .attr("dy", ".35em")
            .text(String);

        svg.append("text")
            .attr("class", "label")
            .attr("x", width - 10)
            .attr("y", 10)
            .attr("dy", ".35em")
            .text("");

        svg.append("text")
            .attr("x", 345)
            .attr("y", 610)
            .attr("text-anchor", "left")
            .style("font-size", "12px sans-serif")
            .style("fill", "#000")
            .text("Actual Period");

        svg.append("text")
            .attr("x", -320)
            .attr("y", -45)
            .attr("text-anchor", "left")
            .style("font-size", "12px sans-serif")
            .style("fill", "#000")
            .attr("transform", "rotate(-90)")
            .text("Forecast Period");

        svg.append("text")
            .attr("x", 0)
            .attr("y", -20)
            .attr("text-anchor", "left")
            .style("font-size", "12px sans-serif")
            .style("fill", "#000")
            .style("max-width", 400);

        svg.selectAll(".tile")
            .style("fill", function(d) {
                return myColor(d.Deviation);
            });

        svg.selectAll(".legend rect")
            .style("fill", myColor);

    });
    </script>

    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

</body>


</html>