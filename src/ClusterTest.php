<?php
if(session_id() == "" || !isset($_SESSION)) {
    // session isn"t started
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
    <link rel="icon" href="../data/ico/innofit.ico">
    <title>Forecast Quality Visualization - Clustering</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/clustertest.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="../lib/js/localforage.js"></script>
    <script src="../lib/js/crossfilter.js"></script>
    <!-- <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script> -->
    <!-- <script src="../lib/js/dc.js"></script> -->
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <style>

    </style>

    <script>
    localforage.config({
        driver: localforage.INDEXEDDB,
        name: "innoFit",
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>
    <script src="./js/calculateErrorMeasures.js"></script>
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
                    <li><a class="specialLine" href="./configuration.php">Configuration</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false"> Dashboard and Viz <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li class="dropdown-header">Dashboard</li>
                        <li><a href="./dashboard.php">Dashboard</a></li>
                            <li class="dropdown-header">Basic Order Analysis</li>
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./matrix.php">Delivery Plans Matrix</a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
                            <li><a href="./matrixvariance.php">Delivery Plans Matrix with Percentage Error </a></li>
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
                    <!-- <li><a href="./dashboard.php">Dashboard</a></li> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="./cor_rmse.php">Corrected Root Mean Square Error (CRMSE) </a></li>
                        </ul>
                    </li>
                    <li class="active"><a href="./ClusterTest.php">Clustering <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <!-- GTranslate: https://gtranslate.io/ -->
                        <!-- <a href="#" onclick="doGTranslate(" en|en");return false;" title="English" class="gflag nturl"
                            style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="English" /></a><a href="#" onclick="doGTranslate("
                            en|de");return false;" title="German" class="gflag nturl"
                            style="background-position:-300px -100px;"><img src="//gtranslate.net/flags/blank.png"
                                height="12" width="12" alt="German" /></a>
                        <div id="google_translate_element2"></div>
                        <script type="text/javascript">
                        function googleTranslateElementInit2() {
                            new google.translate.TranslateElement({
                                pageLanguage: "en",
                                autoDisplay: false
                            }, "google_translate_element2");
                        }
                        </script>
                        <script type="text/javascript"
                            src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
                        </script>
                        <script type="text/javascript">
                        /* <![CDATA[ */
                        eval(function(p, a, c, k, e, r) {
                            e = function(c) {
                                return (c < a ? "" : e(parseInt(c / a))) + ((c = c % a) > 35 ? String
                                    .fromCharCode(c + 29) : c.toString(36))
                            };
                            if (!"".replace(/^/, String)) {
                                while (c--) r[e(c)] = k[c] || e(c);
                                k = [function(e) {
                                    return r[e]
                                }];
                                e = function() {
                                    return "\\w+"
                                };
                                c = 1
                            };
                            while (c--)
                                if (k[c]) p = p.replace(new RegExp("\\b" + e(c) + "\\b", "g"), k[c]);
                            return p
                        }("6 7(a,b){n{4(2.9){3 c=2.9("
                            o ");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\"t\"+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\"\")v;3 b=a.w(\"|\")[1];3 c;3 d=2.x(\"y\");z(3 i=0;i<d.5;i++)4(d[i].A==\"B-C-D\")c=d[i];4(2.j(\"k\")==E||2.j(\"k\").l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\"m\");7(c,\"m\")}}",
                            43, 43,
                            "||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500"
                            .split("|"), 0, {}))
                        /* ]]> */
                        </script> -->
                    </li>
                    <li><a id="btnLogout" href="/includes/logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            Logout</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="customContainer text-center">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-6">
                <h2>Forecast Error Measures - Clustering</h2>
                <small>
                    <?php
            echo "You are logged in as: ";
            print_r($_SESSION["session_username"]);
            echo ".";
            ?></small>
            </div>

        </div>
    </div>
    <hr>
    <!-- <b>IMPORT DATA</b> -->
    <textarea id='distance' cols='1' rows='1' style='visibility:hidden'></textarea>

    <!-- <input type='file' id='upload' accept='.csv' style='display: none;' onchange='showfileprops()' />
    <input type='button' value='Choose file...' onclick="document.getElementById('upload').click();"
        style='background-color:orange;border-radius:5px;margin: 10px 10px 10px 10px' /> -->

    <br>
    <div id='PBDmin' class='info'></div>
    <div id='PeriodsBeforeDelivery' class='info'></div>
    <div id='productNumber' class='info'></div>
    <div id='fileLength' class='info'></div>
    <div id='fileText' class='content'></div><br>
    <div id='showdata'   class='content'></div><br>
    <button class="btn btn-secondary" id="exportFunction"><strong>Export Data</strong></button>


    <script>
    localforage.getItem("viz_data", function(error, data) {
        data = JSON.parse(data);

        function pivot(arr) {
            var mp = new Map();

            function setValue(a, path, val) {
                if (Object(val) !== val) { // primitive value
                    var pathStr = path.join('.');
                    var i = (mp.has(pathStr) ? mp : mp.set(pathStr, mp.size)).get(pathStr);
                    a[i] = val;
                } else {
                    for (var key in val) {
                        setValue(a, key == '0' ? path : path.concat(key), val[key]);
                    }
                }
                return a;
            }
            var result = arr.map(obj => setValue([], [], obj));
            return [
                [...mp.keys()], ...result
            ];
        }

        function toCsv(arr) {
            return arr.map(row =>
                row.map(val => isNaN(val) ? JSON.stringify(val) : +val).join(',')
            ).join(' \n');
        }
        /** Calculation of MAD and MD*/
        // Define function of absolute difference of forecast and final orders (needed for MAD graph)
        // let absDiff = function(orignalEl, finalOrder) {
        //     return Math.abs(orignalEl.OrderAmount - finalOrder);
        // }
        // let mdDiff = function(orignalEl, finalOrder) {
        //     return orignalEl.OrderAmount - finalOrder;
        // }
        // // Define final orders: PBD = 0 means Final Orders
        // let finalOrder = data.filter((el) => {
        //     return el.PeriodsBeforeDelivery == 0;
        // });
        // // Define forecast orders (which are not final orders)
        // let uniqueArray = data.filter(function(obj) {
        //     return finalOrder.indexOf(obj) == -1;
        // });
        // let valueMap = new Map();
        // finalOrder.forEach((val) => {
        //     let keyString = val.ActualPeriod;
        //     let valueString = val.OrderAmount;
        //     valueMap.set(keyString, valueString);
        // });
        // //Absolute values array (needed for MAD calculation)
        // let absValuesArray = uniqueArray.map((el) => {
        //     let value = absDiff(el, valueMap.get(el.ForecastPeriod));
        //     let value2 = mdDiff(el, valueMap.get(el.ForecastPeriod));
        //     return {
        //         ActualPeriod: el.ActualPeriod,
        //         ForecastPeriod: el.ForecastPeriod,
        //         Product: el.Product,
        //         PeriodsBeforeDelivery: el.PeriodsBeforeDelivery,
        //         MAD: value,
        //         MD: value2
        //     };
        // });
        // let newAbsValuesArray = absValuesArray.filter((el) => {
        //     return !isNaN(el.MAD);
        // });
        // var newSeparatedByPBD = d3.nest()
        //     .key(function(d) {
        //         return d.PeriodsBeforeDelivery;
        //     })
        //     .key(function(d) {
        //         return d.Product;
        //     })
        //     .entries(newAbsValuesArray);

        // let MADarray = [];

        // let MADcalc = newSeparatedByPBD.map((el) => {
        //     for (var i = 0; i < newSeparatedByPBD.length; i++) { //length 29   47
        //         var length1 = el.values;
        //         for (var j = 0; j < el.values.length; j++) { //length 15   4
        //             for (var k = 0; k < length1[j].values.length - 1; k++) { //length 76    19
        //                 let meanValue = d3.mean(length1[j].values, function(d) {
        //                     return d.MAD;
        //                 });
        //                 let meanValue5 = d3.mean(length1[j].values, function(d) {
        //                     return d.MD;
        //                 });
        //                 MADarray.push({
        //                     Product: length1[j].values[k].Product,
        //                     PeriodsBeforeDelivery: el.key,
        //                     MAD: meanValue,
        //                     MD: meanValue5,
        //                     MFB: 0,
        //                     MPE: 0,
        //                     MAPE: 0,
        //                     MSE: 0,
        //                     NRMSE: 0,
        //                     RMSE: 0
        //                 })
        //             }
        //         }
        //     }
        // });

        // /**** Remove duplicates from the MAD array */
        // let myNewarray = MADarray;
        // MADarray = Array.from(new Set(myNewarray.map(JSON.stringify))).map(JSON.parse);
        // console.log("unique array", MADarray);
        let nested = d3.nest().key(function(d) {
                return d.Product
            })
            .entries(data);

        console.log(nested);

        const calculationErrorMeasures = [];

        for (let i = 0; i < nested.length; i++) {
            // for (let j = 0; j < nested[i].values.length; j++) {
            const currentData = nested[i].values;
            const currentProduct = nested[i].key;
            // const currentPBD = nested[i].values[j].PeriodsBeforeDelivery;

            let mapeResult = calculateMape(currentData);
            let madResult = calculateMAD(currentData);
            let mdResult = calculateMD(currentData);
            let mseResult = calculateMSE(currentData);
            let rmseResult = calculateRMSE(currentData);
            let norm_rmseResult = calculateNormRMSE(currentData);
            let mpeResult = calculateMPE(currentData);
            let mfbResult = calculateMFB(currentData);

            for (let j = 0; j < mfbResult.length; j++) {
                const currentPBD = mfbResult[j].PeriodsBeforeDelivery;
                calculationErrorMeasures.push({
                    Product: currentProduct,
                    PeriodsBeforeDelivery: mfbResult[j].PeriodsBeforeDelivery,
                    MAD: madResult[j].MAD,
                    MD: mdResult[j].MD,
                    MFB: mfbResult[j].MFB,
                    MPE: mpeResult[j].MPE,
                    MAPE: mapeResult[j].MAPE,
                    MSE: mseResult[j].MSE,
                    NRMSE: norm_rmseResult[j].NRMSE,
                    RMSE: rmseResult[j].RMSE,
                });
            }
        }
        // console.log('final error measures:', calculationErrorMeasures);
        let newCsvContent2 = toCsv(pivot(calculationErrorMeasures));

         /** Export script */
         $("#exportFunction").click(function() {
            saveFile("Export_data.csv", "data:attachment/csv", newCsvContent2);
        });

        /** Function to save file as csv */
        function saveFile(name, type, data) {
            if (data != null && navigator.msSaveBlob)
                return navigator.msSaveBlob(new Blob([data], {
                    type: type
                }), name);
            var a = $("<a style='display: none;'/>");
            var url = window.URL.createObjectURL(new Blob([data], {
                type: type
            }));
            a.attr("href", url);
            a.attr("download", name);
            $("body").append(a);
            a[0].click();
            window.URL.revokeObjectURL(url);
            a.remove();
        }
        /** End of export function */

        /**** Identify unique product names in the array */
        const uniqueNames = [...new Set(calculationErrorMeasures.map(i => i.Product))];
        // console.log('File length: ', calculationErrorMeasures.length);


        let countPBD = calculationErrorMeasures.map(function(d) {
            return d.PeriodsBeforeDelivery
        });
        let periodsMax = Math.max(...countPBD);
        let periodsMin = Math.min(...countPBD);


        function insertOption() {
            var text1 = [];
            text1 = newCsvContent2;

            document.getElementById('fileText').innerHTML = text1;
            document.getElementById('fileText').style.display = 'inline-block';
            document.getElementById('fileText').style.height = '80px';
            document.getElementById('PBDmin').innerHTML = "Min PBD: " + periodsMin;
            document.getElementById('PBDmin').style.display = 'inline-block';
            document.getElementById('PeriodsBeforeDelivery').innerHTML = "Max PBD: " + periodsMax;
            document.getElementById('PeriodsBeforeDelivery').style.display = 'inline-block';
            document.getElementById('productNumber').innerHTML = "Products Number: " + uniqueNames.length;
            document.getElementById('productNumber').style.display = 'inline-block';
            document.getElementById('fileLength').innerHTML = "File length: " + calculationErrorMeasures.length + " lines (data points)";
            document.getElementById('fileLength').style.display = 'inline-block';
            // console.log("text1: ", text1);
        }

        insertOption();
    })
    </script>
    <div class="customContainer text-center">
        <div class="row" style="margin-bottom: -2%;">
            <div class="col-md-6">
                <hr>
                <b style="margin-top: 15px;"> PARAMETER</b>
                <br>

                <select id='series' name='series' class='main'>
                    <option value="2 MAD: Mean Absolute Deviation">MAD: Mean Absolute Deviation</option>
                    <option value="3 MD: Mean Deviation">MD: Mean Deviation</option>
                    <option value="4 MFB: Mean Forecast Bias">MFB: Mean Forecast Bias</option>
                    <option value="5 MPE: Mean Percentage Error">MPE: Mean Percentage Error</option>
                    <option value="6 MAPE: Mean Absolute Percentage">MAPE: Mean Absolute Percentage</option>
                    <option value="7 MSE: Mean Squared Error">MSE: Mean Squared Error</option>
                    <option value="8 NRMSE: Norm Root Mean Squared Error">NRMSE: Normalized Root Mean Squared Error</option>
                    <option value="9 RMSE: Root Mean Squared Error">RMSE: Root Mean Squared Error</option>
                </select>

                <select id='method' name='method' class='main' onchange='showmethod()'>
                    <option value="kMeans">k Means</option>
                    <option value="Agglomerative">Agglomerative</option>
                    <option value="Affinity">AffinityPropagation</option>
                </select>
                <br>




                <!-- PARAMETER KMEANS -->
                <div id='km_k_text' class='text'>Number Clusters =</div>
                <!--  <input  id='km_k' type='text' maxlength=1 value=3 size=1 style='width:30px'>
<input type="number" id="km_k" name="km_k" min="1" max="10" step="1" value="3" style='width:50px;height:25px'>
-->
                <select id='km_k' name='km_k' class='sub' style='width:60px;height:24px;'>
                    <option value="1"> 1</option>
                    <option value="2">2</option>
                    <!-- <option value="3" selected>3</option> -->
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <div id='km_rs_text' class='text' style='display:none;'>random_state =</div>
                <input id='km_rs' type='text' maxlength=5 value=42 size=4 style='width:80px;display:none;'>
                <div id='km_init_text' class='text' style='display:none;'>init =</div>
                <select id='km_init' name='km_init' class='sub' style='width:100px;height:24px;display:none;'>
                    <option value='k-means++'>k-means++</option>
                    <option value="random">random</option>
                </select>
                <div id='km_ninit_text' class='text' style='display:none;'>n_init =</div>
                <input id='km_ninit' type='text' maxlength=2 value=1 size=1 style='width:40px;display:none;'>
                <div id='km_maxiter_text' class='text' style='display:none;'>max_iter =</div>
                <input id='km_maxiter' type='text' maxlength=3 value=1 size=1 style='width:50px;display:none;'>
                <div id='km_tol_text' class='text' style='display:none;'>tol =</div>
                <input id='km_tol' type='text' maxlength=5 value=0.0001 size=3 maxlength=7
                    style='width:80px;display:none;'>


                <!-- PARAMETER AGGLOMERATIVE -->
                <div id='ag_k_text' class='text' style='display:none;'>Number Clusters =</div>
                <!-- <input  id='ag_k' type='test' maxlength=1 value=3 size=1 style='width:30px;display:none;'>
<input  id='ag_k' type='number' min="1" max="10" step="1" value="3" style='width:50px;height:25px;display:none;'>
-->
                <select id='ag_k' name='ag_k' class='sub' style='width:60px;height:24px;display:none;'>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <!-- <option value="3" selected>3</option> -->
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>

                <div id='ag_linkage_test' class='text' style='display:none;'>linkage =</div>
                <select id='ag_linkage' name='ag_linkage' class='sub' style='display:none;width:100px;height:24px;'>
                    <option value="ward">ward</option>
                    <option value="complete">complete</option>
                    <option value="average">average</option>
                    <option value="single">single</option>
                </select>
                <div id='ag_metric_test' class='text' style='display:none;'>metric =</div>
                <select id='ag_metric' name='ag_metric' class='sub' style='display:none;width:100px;height:24px;'>
                    <option value="euclidean">euclidean</option>
                    <option value="l1">l1</option>
                    <option value="l2">l2</option>
                    <option value="manhattan">manhattan</option>
                    <option value="cosine">cosine</option>
                </select>

                <!-- PARAMETER AffinityPropagation -->
                <div id='af_damping_text' class='text' style='display:none;'>damping =</div>
                <input id='af_damping' type='text' maxlength=3 value=0.5 size=1 style='width:40px;display:none;'>
                <div id='af_maxiter_text' class='text' style='display:none;'>max_iter =</div>
                <input id='af_maxiter' type='text' maxlength=4 value=200 size=1 style='width:40px;display:none;'>
                <div id='af_conviter_text' class='text' style='display:none;'>conv_iter =</div>
                <input id='af_conviter' type='text' maxlength=2 value=15 size=1 style='width:40px;display:none;'>

                <!-- PARAMETER MEANSHIFT -->
                <div id='ms_bin_text' class='text' style='display:none;'>conv_iter =</div>
                <select id='ms_bin' name='ms_bin' class='sub' style='display:none;width:100px;height:24px;'>
                    <option value="False">False</option>
                    <option value="True">True</option>
                </select>

                <hr>
                <button type="button" id="startclustering">Start Clustering</button>

                <label id="minsectext">Loading Python:</label>
                <label id="min">00</label><label id="minsec">:</label><label id="sec">00</label>

                <nobr>
                    <button id="create">Create file</button>
                    <a download="IF-result.csv" id="downloadlink" style="display: none">Download</a>
                </nobr>

                <hr>
                <textarea style="display: none" width="50" height="10" id="textbox">Type something here</textarea>

                <div id='resulthead' class='reshead'></div><br>
                <div id='clusterkpi' class='kpi'></div><br>

                <table>
                    <tr>
                        <td><canvas id="plotarea0" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea1" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea2" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea3" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea4" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                    </tr>
                    <tr>
                        <td valign=top colspan="2">
                            <div id='c00' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c01' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c02' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c03' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c04' class='ccc'></div>
                        </td>
                    </tr>
                    <tr>
                        <td><canvas id="plotarea5" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea6" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea7" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea8" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                        <td><canvas id="plotarea9" width="300" height="350"></canvas></td>
                        <td><canvas width="10" height="350"></canvas></td>
                    </tr>
                    <tr>
                        <td valign=top colspan="2">
                            <div id='c05' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c06' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c07' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c08' class='ccc'></div>
                        </td>
                        <td valign=top colspan="2">
                            <div id='c09' class='ccc'></div>
                        </td>
                </table>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script type="text/javascript">
    (function(download) {
        var textFile = null,
            makeTextFile = function(text) {
                var data = new Blob([text], {
                    type: 'text/plain'
                });
                // If we are replacing a previously generated file we need to
                // manually revoke the object URL to avoid memory leaks.
                if (textFile !== null) {
                    window.URL.revokeObjectURL(textFile);
                }
                textFile = window.URL.createObjectURL(data);
                return textFile;
            };

        var create = document.getElementById('create'),
            textbox = document.getElementById('textbox');

        create.addEventListener('click', function(download) {
            var link = document.getElementById('downloadlink');
            link.href = makeTextFile(textbox.value);
            link.style.display = 'inline';
        }, false);
    })();

    function fehlerbehandlung(errorEvent) {
        var fehler = "Fehlermeldung:\n" + errorEvent.message + "\n" + errorEvent.filename + "\n" + errorEvent
            .lineno;
        alert(fehler);
        errorEvent.preventDefault();
    }

    // Show properties loaded file
    function showfileprops() {
        var selectedFile = document.getElementById('upload').files[0];
        var reader = new FileReader();
        reader.readAsText(selectedFile, "UTF-8");
        reader.onload = function(evt) {
            document.getElementById("fileText").innerHTML = evt.target.result;
            document.getElementById('fileText').style.display = 'inline-block';

            document.getElementById("fileLength").innerHTML = (evt.target.result.split(/\r\n|\r|\n/)
                    .length - 2)
                .toString().concat('Items');
            document.getElementById('fileLength').style.display = 'inline-block';
            document.getElementById('fileName').innerHTML = selectedFile.name;
            document.getElementById('fileName').style.display = 'inline-block';
            document.getElementById('fileDate').innerHTML = selectedFile.lastModifiedDate.toString()
                .substring(0,
                    25);
            document.getElementById('fileDate').style.display = 'inline-block';
            document.getElementById('fileSize').innerHTML = Math.round(selectedFile.size / 1024).toString()
                .concat(
                    'kB');
            document.getElementById('fileSize').style.display = 'inline-block';
        }
    }

    // hide all DOMs with parameters
    function hide_all() {
        document.getElementById('km_k_text').style.display = "none";
        document.getElementById('km_k').style.display = "none";
        document.getElementById('km_rs_text').style.display = "none";
        document.getElementById('km_rs').style.display = "none";
        document.getElementById('km_init_text').style.display = "none";
        document.getElementById('km_init').style.display = "none";
        document.getElementById('km_ninit_text').style.display = "none";
        document.getElementById('km_ninit').style.display = "none";
        document.getElementById('km_maxiter_text').style.display = "none";
        document.getElementById('km_maxiter').style.display = "none";
        document.getElementById('km_tol_text').style.display = "none";
        document.getElementById('km_tol').style.display = "none";

        document.getElementById('ag_k_text').style.display = "none";
        document.getElementById('ag_k').style.display = "none";
        document.getElementById('ag_linkage_test').style.display = "none";
        document.getElementById('ag_linkage').style.display = "none";
        document.getElementById('ag_metric_test').style.display = "none";
        document.getElementById('ag_metric').style.display = "none";

        document.getElementById('af_damping_text').style.display = "none";
        document.getElementById('af_damping').style.display = "none";
        document.getElementById('af_maxiter_text').style.display = "none";
        document.getElementById('af_maxiter').style.display = "none";
        document.getElementById('af_conviter_text').style.display = "none";
        document.getElementById('af_conviter').style.display = "none";

        document.getElementById('ms_bin_text').style.display = "none";
        document.getElementById('ms_bin').style.display = "none";
    }

    // show DOMs with parameters meanshift
    function show_ms() {
        document.getElementById('ms_bin_text').style.display = "inline-block";
        document.getElementById('ms_bin').style.display = "inline-block";
    }

    // show DOMs with parameters affinity propagation
    function show_af() {
        document.getElementById('af_damping_text').style.display = "inline-block";
        document.getElementById('af_damping').style.display = "inline-block";
        //  document.getElementById('af_maxiter_text').style.display = "inline-block";
        //  document.getElementById('af_maxiter').style.display = "inline-block";
        //  document.getElementById('af_conviter_text').style.display = "inline-block";
        //  document.getElementById('af_conviter').style.display = "inline-block";
    }

    // show DOMs with parameters agglomerative
    function show_ag() {
        document.getElementById('ag_k_text').style.display = 'inline-block';
        document.getElementById('ag_k').style.display = 'inline-block';
        document.getElementById('ag_linkage_test').style.display = 'inline-block';
        document.getElementById('ag_linkage').style.display = 'inline-block';
        document.getElementById('ag_metric_test').style.display = 'inline-block';
        document.getElementById('ag_metric').style.display = 'inline-block';
    }

    // show DOMs with parameters k Means
    function show_km() {
        document.getElementById('km_k_text').style.display = "inline-block";
        document.getElementById('km_k').style.display = "inline-block";
        //  document.getElementById('km_rs_text').style.display = "inline-block";
        //  document.getElementById('km_rs').style.display = "inline-block";
        //  document.getElementById('km_init_text').style.display = "inline-block";
        //  document.getElementById('km_init').style.display = "inline-block";
        //  document.getElementById('km_ninit_text').style.display = "inline-block";
        //  document.getElementById('km_ninit').style.display = "inline-block";
        //  document.getElementById('km_maxiter_text').style.display = "inline-block";
        //  document.getElementById('km_maxiter').style.display = "inline-block";
        //  document.getElementById('km_tol_text').style.display = "inline-block";
        //  document.getElementById('km_tol').style.display = "inline-block";
    }

    // show DOMs with parameters
    function showmethod() {
        var e = document.getElementById("method");
        var text = e.options[e.selectedIndex].text;

        hide_all()

        if (text == "k Means") {
            show_km()
        };
        if (text == "Agglomerative") {
            show_ag()
        };
        if (text == "AffinityPropagation") {
            show_af()
        };
    }
    </script>

    <!-- get Pyodide files from internet -->

    <script type="text/javascript">
    window.languagePluginUrl = 'https://pyodide-cdn2.iodide.io/v0.15.0/full/';
    </script>
    <script src="https://pyodide-cdn2.iodide.io/v0.15.0/full/pyodide.js"></script>


    <!-- get Pyodide files from localhost -->
    <!--   <script src="pyodide_dev.js"></script>  -->

    <script type="text/javascript">
    // Start after Button Clustering!
    document.getElementById("startclustering").onclick = function() {
        checks()
    };

    function checks() {
        document.getElementById('downloadlink').style.display = 'none';
        document.getElementById('c00').style.display = "none";
        document.getElementById('c01').style.display = "none";
        document.getElementById('c02').style.display = "none";
        document.getElementById('c03').style.display = "none";
        document.getElementById('c04').style.display = "none";
        document.getElementById('c05').style.display = "none";
        document.getElementById('c06').style.display = "none";
        document.getElementById('c07').style.display = "none";
        document.getElementById('c08').style.display = "none";
        document.getElementById('c09').style.display = "none";
        document.getElementById('textbox').innerHTML = '';

        var totalSeconds = 0;
        setInterval(setTime, 1000);

        document.getElementById('minsectext').style.display = "inline-block";
        document.getElementById('min').style.display = "inline-block";
        document.getElementById('minsec').style.display = "inline-block";
        document.getElementById('sec').style.display = "inline-block";

        function setTime() {
            ++totalSeconds;
            document.getElementById('sec').innerHTML = pad(totalSeconds % 60);
            document.getElementById('min').innerHTML = pad(parseInt(totalSeconds / 60));
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }


        window.addEventListener("error", fehlerbehandlung);

        // hide DOM results
        document.getElementById('plotarea0').style.display = "none";
        document.getElementById('plotarea1').style.display = "none";
        document.getElementById('plotarea2').style.display = "none";
        document.getElementById('plotarea3').style.display = "none";
        document.getElementById('plotarea4').style.display = "none";
        document.getElementById('plotarea5').style.display = "none";
        document.getElementById('plotarea6').style.display = "none";
        document.getElementById('plotarea7').style.display = "none";
        document.getElementById('plotarea8').style.display = "none";
        document.getElementById('plotarea9').style.display = "none";

        // file loaded?
        if (document.getElementById('fileLength').innerHTML.length == 0) {
            alert('Please load file !');
            return;
        }

        console.log('Method for parameter check: ', document.getElementById('method').value);

        // CHECK PARAMETER KMEANS
        if (document.getElementById('method').value == 'kMeans') {
            var numbers = /[1-9]/;
            if (!document.getElementById('km_k').value.match(numbers)) {
                alert('Number of clusters (k) muss be integer and between 1 and 9.')
                return;
            }

            var temp = document.getElementById('km_rs').value
            if (!(temp >>> 0 === parseFloat(temp))) {
                alert('Use an integer for random state.')
                return;
            }

            var temp = document.getElementById('km_ninit').value
            if ((!(temp >>> 0 === parseFloat(temp))) || temp == '0') {
                alert('Use an integer >0 for n_init.')
                return;
            }

            var temp = document.getElementById('km_maxiter').value
            if ((!(temp >>> 0 === parseFloat(temp))) || (temp == '0')) {
                alert('Use an integer >0 for max_iter.')
                return;
            }

            var temp = document.getElementById('km_tol').value
            if (isNaN(temp) || parseFloat(temp) <= 0) {
                alert('Use a float >0 for tol.')
                return;
            }
        }

        // CHECK PARAMETER AGGLOMERATIVE
        if (document.getElementById('method').value == 'Agglomerative') {
            console.log('check para agglomerative.')

            var numbers = /[1-9]/;
            if (!document.getElementById('ag_k').value.match(numbers)) {
                alert('Number of clusters (k) muss be integer and between 1 and 9.')
                return;
            }

            if (document.getElementById('ag_metric').value == 'cosine') {
                alert("An error can occur with the metric 'cosine'. Should be investigated. Try other metric.")
                return;
            }
        }

        // CHECK PARAMETER AFFINITY PROPAGATION
        if (document.getElementById('method').value == 'Affinity') {
            console.log('check para affinity propagation.')

            var temp = document.getElementById('af_damping').value
            if (isNaN(temp) || parseFloat(temp) < 0.5 || parseFloat(temp) >= 1) {
                alert('Use a float >=0.5 und < 1 for damping.')
                return;
            }

            var temp = document.getElementById('af_maxiter').value
            if ((!(temp >>> 0 === parseFloat(temp))) || temp == '0') {
                alert('Use an integer >0 for max_iter.')
                return;
            }

            var temp = document.getElementById('af_conviter').value
            if ((!(temp >>> 0 === parseFloat(temp))) || temp == '0') {
                alert('Use an integer >0 for conv_iter.')
                return;
            }
        }

        // PARAMETER ARE OK
        clustering()

    }

    function clustering() {
        languagePluginLoader.then(() => {
            pyodide.loadPackage(['joblib']).then(() => {
                pyodide.loadPackage(['numpy']).then(() => {
                    pyodide.loadPackage(['scipy']).then(() => {
                        pyodide.loadPackage(['scikit-learn']).then(() => {
                            console.log(
                                "All libraries loaded. Pyodide started."
                            )

                            document.getElementById('minsectext').style
                                .display = "none";
                            document.getElementById('min').style
                                .display =
                                "none";
                            document.getElementById('minsec').style
                                .display =
                                "none";
                            document.getElementById('sec').style
                                .display =
                                "none";
                            document.getElementById('resulthead').style
                                .display = "inline-block";
                            document.getElementById('clusterkpi').style
                                .display = "inline-block";
                            document.getElementById('showdata').style.display = "inline-block";

                            // **********************************************************
                            // ********************START PYTHON *************************
                            // **********************************************************

                            pyodide.runPython(`
print('Start Python.')

import numpy as np, itertools, sklearn
from sklearn.cluster import KMeans
from sklearn.cluster import AgglomerativeClustering
from sklearn.cluster import AffinityPropagation
from sklearn.cluster import MeanShift, estimate_bandwidth

from sklearn.metrics import davies_bouldin_score, silhouette_score

from io import StringIO
from js import document, alert

#print('Scikit-learn version: {}.'.format(sklearn.__version__))

# ******************** CREATE GRAPH *************************
def graph(ctx,x0,x1,y0,y1,week,y,cent,y_range):
	week = week.astype('int32')
	xmin,xmax = 0,max(week)
	figure_y_values(ctx,x0,x1,y0,y1,y_range)
	figure_x_values(ctx,x0,x1,y0,xmin,xmax)
	x = week.copy()

	if xmax//1000 == xmin//1000:
		xwerte = xmax-xmin+1
		for i in range(len(week)):
			x[i] = week[i] - xmin
	else:
		xwerte = xmax-xmin-47
		for i in range(len(week)):
			if xmax//1000 == 1:
				x[i] = week[i] - xmin
			else:
				if week[i]//1000 == 1:
					x[i] = week[i] - xmin
				else:
					x[i] = week[i] - xmin - 50

	xmin,xmax = min(x),max(x)

	# plot line
	for j in y:
		for i in range(len(x)):
			xpoint, ypoint = change_ref_system(x0,x1,y0,y1,xmax,y_range,x[i], j[i])
			#ctx.fillRect(xpoint-5,ypoint-5,9,9)
			if i>0:  draw_line(ctx, xold, yold, xpoint, ypoint, linethick = 1)
			xold, yold = xpoint, ypoint

	# plot centroids
	for i in range(len(x)):
		xpoint, ypoint = change_ref_system(x0,x1,y0,y1,xmax,y_range,x[i], cent[i])
		ctx.fillStyle = '#FF0000'
		ctx.fillRect(xpoint-5,ypoint-5,9,9)

# ******************** PLOT x,y AXIS *************************
def axis(ctx,y_range,x0,x1,y0,y1,color = "black", linethick = 3):

	draw_line(ctx, x0, y0, x0, y1, linethick = 2.0) # y left
	draw_line(ctx, x1, y0, x1, y1, linethick = 0.5) # y right
	draw_line(ctx, x0, y1, x1, y1, linethick = 0.5) # x top
	draw_line(ctx, x0, y1, x1, y1, linethick = 0.5) # x bottom

	# Null-Achse
	if y_range[0] == 0:
		y = y0
	else:
		y = (y1 - y0*y_range[1]/y_range[0]) / (1-y_range[1]/y_range[0])
	draw_line(ctx, x0, y, x1, y, linethick = 2.0)

# ******************** PLOT TITLE *************************
def figure_title(ctx,title,c_size,y_range):
	ctx.fillStyle = 'black'
	ctx.font = "bold 16px Arial"
	ctx.fillText(title, c_size[0]/2 - len(title)/2, 12)

# ******************** PLOT TITLE Y AXIS ********************
def figure_y_title(ctx,title,c_size,y_range):
	x = 4
	y = c_size[1]/2 - len(title)*1.1
	lineHeight = 15
	ctx.save()
	ctx.fillStyle = 'black'
	ctx.translate(x, y)
	ctx.rotate(-3.14142 / 2)
	ctx.textAlign = 'center'
	ctx.font = "bold 16px Arial, sans-serif";
	ctx.fillText(title, 0, lineHeight / 2)
	ctx.restore()

# ******************** PLOT TITLE X AXIS ********************
def figure_x_title(ctx,title,x0,c_size):
	x = x0 + (c_size[0]-x0) /2
	y = c_size[1] - 25
	lineHeight = 15
	ctx.save()
	ctx.fillStyle = 'black'
	ctx.translate(x, y)
	ctx.textAlign = 'center'
	ctx.font = "bold 12px Arial, sans-serif";
	ctx.fillText('Periods Before Delivery', 0, lineHeight / 2)
	ctx.restore()

# ******************** VALUES Y AXIS ********************
def figure_y_values(ctx,x0,x1,y0,y1,y_range):
	for i in range(6):
		ctx.save()
		ctx.font = "bold 12px Arial"
		ctx.fillStyle = "black"
		ctx.textAlign = 'right'
		
		yrange = abs(y_range[1]-y_range[0])
		
		if yrange <1:
			y = '{:.3f}'.format(y_range[1]-i*(y_range[1]-y_range[0])/5 )
		elif yrange <10:
			y = '{:.2f}'.format(y_range[1]-i*(y_range[1]-y_range[0])/5 )
		elif yrange <10000:
			y = '{:,.0f}'.format(y_range[1]-i*(y_range[1]-y_range[0])/5 )
		elif yrange <100000:
			y = '{:.0f}'.format((y_range[1]-i*(y_range[1]-y_range[0])/5)/1000 ) + "T"
		else:
			y = '{:.1f}'.format((y_range[1]-i*(y_range[1]-y_range[0])/5)/1000000 ) + "M"
		ctx.fillText(y, 50, y1+6+(y0-y1)*i/5)
		ctx.restore()
		draw_line(ctx, x0, y1+(y0-y1)*i/5, x1,  y1+(y0-y1)*i/5, linethick = 0.3)
	
# ******************** VALUES X AXIS ********************
def	figure_x_values(ctx,x0,x1,y0,xmin,xmax):
	xoff = 10     # x=0 starts xoff points right from y-axis
	interval = 1  # distance between two x-values
	ctx.save()
	ctx.font = "bold 12px Arial"
	ctx.fillStyle = "black"
	ctx.textAlign = 'center'	
	values = xmax//interval - xmin//interval + 1

	for i in range(values):
		value = xmin + interval*i
		xloc = x0 + xoff + (value-xmin)*(x1-x0-2*xoff)/(xmax-xmin)
		ctx.fillText(value, xloc, y0+20)
		draw_line(ctx,xloc,y0,xloc,y1, linethick = 0.3)
		
	ctx.restore()

# ******************** DRAW ONE LINE ********************
def draw_line(ctx, x1, y1, x2, y2, linethick = 1, color = "black", dash = False):
	ctx.beginPath()
	ctx.lineWidth = linethick
	ctx.moveTo(x1, y1)
	ctx.lineTo(x2, y2)#
	ctx.strokeStyle = color
	if dash:
		ctx.setLineDash([5, 15])
	else:
		ctx.setLineDash([])
	ctx.stroke()

# ******************** MAP x,y to COORDINATES ********************
def change_ref_system(x0,x1,y0,y1,xmax,y_range,x, y):
	xoff = 10
	return (x0+xoff + x/xmax *(x1-x0-2*xoff),
			y0 - (y-y_range[0]) * (y0-y1) / (y_range[1]-y_range[0])  )

# ******************** CALCULATE CENTROIDS ************************
def clustercenter(X,labels,k):
	centroids = []
	for i in range(k):
		points = [X[j] for j in range(len(X)) if labels[j] == i]
		centroids.append(np.mean(points, axis=0))
	return centroids

# *****************************************************************
# ******************** MAIN PROGRAM PYTHON ************************
# *****************************************************************

print('Start Clustering')

clustermethod = document.getElementById('method').value
timeseries    = document.getElementById('series').value[2:100]
colnr         = int(document.getElementById('series').value[0])

# Add line break
newLine = chr(10)
mystring = document.getElementById('fileText').innerHTML.replace(' "',newLine + '"')

myarray = np.loadtxt(StringIO(mystring), skiprows = 1, delimiter = ',', usecols = (0,1,2,3,4,5,6,7,8,9),
          dtype={'names': ('PR','PBD', 'MAD', 'MD', 'MFB', 'MPE', 'MAPE', 'MSE', 'NRMSE', 'RMSE'),
                 'formats': ('S30','i4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4')})

myarray = np.array(myarray.tolist())

u_pr  = np.unique(np.array(myarray[:,0]))
print('u_pr',u_pr)

# add final order amount
for p in u_pr:
	add = np.array([p,0,0,0,1,0,0,0,0,0])
	myarray = np.append(myarray,[add],axis=0)

# pbd: strings must be sorted as numbers
u_pbd = np.array(sorted(list(set(myarray[:,1])),key=int))
print('u_pbd',u_pbd)

# create pivot table - data for clustering
D = dict(zip(map(tuple, myarray[:,[0,1]]), myarray[:,[colnr]].ravel().tolist()))
X = np.array(list(map(D.get, itertools.product(u_pr, u_pbd)))).reshape(len(u_pr),len(u_pbd))
X = X.astype(np.float)
print('X',X)

# K MEANS
if clustermethod == 'kMeans':
	print('k Means Clustering started.')
	n_clusters   = int(document.getElementById("km_k").value)
	print('aaa')
	init         = document.getElementById("km_init").value	
	print('bbb')
	n_init       = int(document.getElementById("km_ninit").value)
	print('ccc')
	max_iter     = int(document.getElementById("km_maxiter").value)
	print('dddd')
	tol          = float(document.getElementById("km_tol").value)
	print('eee')
	random_state = int(document.getElementById("km_rs").value)
	print('fff')
	model = KMeans(n_clusters=n_clusters, init=init,n_init=n_init, max_iter= max_iter, tol= tol, random_state=random_state)
	print('ggg')
	y_model = model.fit_predict(X)
	print('hhh')
	clustercenters = model.cluster_centers_
	print('iii')
	parameters = 'n_clusters= ' + str(n_clusters) + ';init= ' + str(init) + ';n_init= ' + str(n_init) + ';max_iter= ' + str(max_iter) + ';tol= ' + str(tol)
	print('k Means Clustering finished.')

# AGGLOMERATIVE
if clustermethod == 'Agglomerative':
	print('Agglomerative Clustering started.')
	n_clusters   = int(document.getElementById('ag_k').value)
	linkage      = document.getElementById('ag_linkage').value	
	if linkage == 'ward':
		metric = 'euclidean'
		document.getElementById('ag_metric').value = 'euclidean'
	metric = document.getElementById('ag_metric').value
	model = AgglomerativeClustering(n_clusters=n_clusters,linkage= linkage, affinity=metric)
	print('Agglomerative Clustering finished.')
	y_model = model.fit_predict(X)
	parameters = 'n_clusters= ' + str(n_clusters) + ';linkage= ' + str(linkage) + ';metric= ' + str(metric)
	clustercenters = clustercenter(X,y_model,n_clusters)

# AFFINITY PROPAGATION
if clustermethod == 'Affinity':
	print('AffinityPropagation Clustering started.')
	damping   = float(document.getElementById('af_damping').value)
	max_iter  = int(document.getElementById("af_maxiter").value)
	conv_iter = int(document.getElementById("af_conviter").value)
	af = AffinityPropagation(damping=damping, max_iter= max_iter, convergence_iter = conv_iter).fit(X)
	y_model = af.labels_
	n_clusters = len(af.cluster_centers_indices_)
	print('AffinityPropagation Clustering finished.')
	parameters = 'damping= ' + str(damping) + ';max_iter= ' + str(max_iter) + ';conv_iter= ' + str(conv_iter)
	clustercenters = []
	for i in af.cluster_centers_indices_:
		clustercenters.append(X[i])

# MEANSHIFT
if clustermethod == 'MeanShift':
	print('MeanShift started.')
	binseed = document.getElementById('binseed').value
	# The following bandwidth can be automatically detected using
	bandwidth = estimate_bandwidth(X, quantile=0.2, n_samples=10)
	#ms = MeanShift(bandwidth=2,bin_seeding=binseed).fit(X)
	ms = MeanShift().fit(X)
	y_model = ms.labels_
	clustercenters = ms.cluster_centers_
	n_clusters = len(np.unique(ms.labels_))
	dbs = davies_bouldin_score(X,y_model)
	print('MeanShift finshed.')

# column values identical => possibly less clusters than expected
n_clusters = len(np.unique(y_model))

print('jjj')

if (n_clusters > 1) and (n_clusters < len(u_pr)):
	dbs = davies_bouldin_score(X,y_model)
	sil = silhouette_score(X,y_model)
else:
	dbs, sil = 0, 0

print('kkk')

# number of clusters is partly a result
if clustermethod == 'Affinity':
	my_string = 'Number Clusters: ' + str(n_clusters) + '<br>'
elif document.getElementById('method').value == 'MeanShift':
	my_string = 'Number Clusters: ' + str(n_clusters) + '<br>'
else:
	my_string = ''

print('lll')

# CALCULATE KPI AS STRING
if (n_clusters > 1) and (n_clusters != len(u_pr)):
	dbs_str, sil_str = str(dbs)[0:6], str(sil)[0:6]
elif n_clusters == 1:
	dbs_str, sil_str = 'n.a. for 1 cluster', 'n.a. for 1 cluster'
else:
	dbs_str, sil_str = 'n.a. for for all items in different clusters', 'n.a. for for all items in different clusters'



my_string += 'Davies-Bouldin Score: ' + dbs_str + '<br>'
my_string += 'Silhouette-Score: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' + sil_str



document.getElementById("clusterkpi").innerHTML = my_string
document.getElementById("resulthead").innerHTML = 'RESULTS: ' + timeseries + ' and ' + clustermethod

myarray = myarray[myarray[:,1].argsort()] # First sort doesn't need to be stable.
myarray = myarray[myarray[:,0].argsort(kind='mergesort')]

mystring  = '<table border=0><tr><th> Product </th><th style="text-align: center"> PBD </th>'
mystring += '<th style="text-align: center"> MAD </th><th style="text-align: center"> MD </th><th style="text-align: center"> MFB  </th><th style="text-align: center">  MPE  </th><th style="text-align: center"> MAPE </th>'
mystring += '<th style="text-align: center"> MSE </th><th style="text-align: center"> NRMSE </th><th style="text-align: center"> RMSE </th></tr>'

for line in myarray:
	mystring += '<tr>'
	mystring += '<td>' + str(line[0].decode('UTF-8').replace('"','')) + '</td>'
	mystring += '<td style="text-align:center">' + str(line[1].decode('UTF-8')) + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[2].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[3].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[4].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[5].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[6].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[7].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[8].decode().strip('"')),'.2f') + '</td>'
	mystring += '<td style="text-align:right">' + format(float(line[9].decode().strip('"')),'.2f') + '</td>'	
	mystring += '</tr>'
mystring += '</table>'

document.getElementById("showdata").innerHTML = mystring

# SHOW CLUSTERS
if n_clusters >0:
	c_string  = ['']*n_clusters
	c_string2 = ['']*n_clusters
	i = 0
	for j in y_model:
		c_string[j] += u_pr[i].decode("utf-8") + chr(10)
		c_string2[j] += u_pr[i].decode("utf-8") + '<br>'		
		i += 1
	for i in range(n_clusters):
		my_string += "Cluster " + str(i) + ": " + c_string[i] + '<br>'
else:
	my_string = 'ConvergenceWarning: Affinity propagation did not converge, this model will not have any cluster centers.'

print('ppp')

for i in range(n_clusters):
	document.getElementById("c0" + str(i)).style.display = "inline-block"
	document.getElementById("c0" + str(i)).style.background = '#eee'
	document.getElementById("c0" + str(i)).innerHTML = c_string2[i].replace('"','')

print('qqq')

# create file export
from datetime import datetime
timestamp = str(datetime.now().isoformat(' ', 'seconds'))
filecontent = ''
filecontent += 'Time Stamp'           + ',' + timestamp        + chr(10)
filecontent += 'Error Measure'        + ',' + timeseries       + chr(10)
filecontent += 'Clustering Method'    + ',' + clustermethod    + chr(10)
filecontent += 'Parameter'            + ',' + parameters       + chr(10)
filecontent += 'Number Clusters'      + ',' + str(n_clusters)  + chr(10)
filecontent += 'Davies-Bouldin Score' + ',' + dbs_str          + chr(10)
filecontent += 'Silhouette-Score'     + ',' + sil_str          + chr(10) + chr(10)
filecontent += 'Cluster'              + ',' + 'Product / Periods before delivery'        + ','

for i in range(len(u_pbd)):  filecontent += str(u_pbd[i].decode("utf-8")) + ','
filecontent	+= chr(10)

# clusternumber + product
i = 0 # 1.product
for j in y_model:

	filecontent += str(j) + ',' + u_pr[i].decode("utf-8").replace('"','') + ','
	for k in range(len(u_pbd)): filecontent += str('{:.4f}'.format(X[i][k])).replace('.','.') + ','
	filecontent += chr(10)
	i += 1

document.getElementById("textbox").innerHTML = filecontent

# CALCULATE y1: UPPER VALUE PLOT
y_max, y_min = np.amax(X), np.amin(X)
x = len(str(int(y_max)))-1
if int(y_max) == 0:
	y1 = round(y_max*10/(10**x)+0.5,0)*10**x/10
elif (y_max < 0.5):
	y1 = round(y_max+0.1,1)
if (y_max >1) and (y_max<=1000):   y1 = round(y_max/(10**x)+0.05,1)*10**x
if (y_max > 1000):                 y1 = round(y_max/(10**x)+0.5,0)*10**x

y_min = min(0,y_min)
if y_min == 0:
	y0 = 0
else:
	x = len(str(int(y_min)))-2
	y0 = round(y_min/(10**x)-0.5,0)*10**x

y_range = [round(min(y0,0),3), y1]

c_size = [300,350] # canvas width, height

# CLEAR ALL PLOTS
for cnr in range(10):
	canvas = document.getElementById('plotarea' + str(cnr))
	ctx = canvas.getContext("2d")
	ctx.clearRect(0, -10, c_size[0], c_size[1]-10)

# PLOT FOR ALL CLUSTERS
for cnr in range(min(n_clusters,10)):
	document.getElementById('plotarea' + str(cnr)).style.display = "inline-block"
	canvas = document.getElementById('plotarea' + str(cnr))
	ctx = canvas.getContext("2d")

	# Axes
	x0, y0 = 65, c_size[1]-50
	x1, y1 = c_size[0]-5, 25

	axis(ctx,y_range,x0,x1,y0,y1,color = "black", linethick = '3')

	title = 'Cluster ' + str(cnr)
	figure_title(ctx, title, c_size, y_range)
	
	if cnr in [0,5]: figure_y_title(ctx,timeseries, c_size, y_range)
	figure_x_title(ctx, 'Time',x0,c_size)

	cluster = X[y_model == cnr]

	graph(ctx,x0,x1,y0,y1,u_pbd,cluster,clustercenters[cnr],y_range)

print('Finished Python.')
`);

                        });
                    });
                });
            });
        });
    } // end myfunction
    </script>

    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>


</body>

</html>