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
    <link rel="icon" href="data/ico/innofit.ico">
    <title>Forecast Quality Visualization</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/clustertest.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="../lib/js/localforage.js"></script>
    <script src="//d3js.org/d3-scale-chromatic.v0.3.min.js"></script>
    <script src="./js/util.js"></script>
    <script src="../lib/js/dc.js"></script>
    <script src="http://d3js.org/d3.v4.min.js"></script> 
    <title> Clustering
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
        </script>
    </title>
    <script>
    localforage.config({
        driver: localforage.INDEXEDDB,
        name: "innoFit",
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>
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
                            aria-haspopup="true" aria-expanded="false">Visualizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
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
                    <li><a href="./dashboard.php">Dashboard</a></li>
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
                        <a href="#" onclick="doGTranslate(" en|en");return false;" title="English" class="gflag nturl"
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
                        </script>
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
                <!-- <p style="margin-top: 15px;">
                    On this page you find a overview about the available error measures this tool provides. Each error
                    measure has a dedicated page itself with a bigger view and
                    the possiblity to adjust some further elements or view specific items and compare them. This view is
                    mainly for a quick comparison and has only the main filters
                    applied from the <a href="./configuration.php"><strong>Configuration</strong></a> page. <button
                        class="btn btn-secondary" id="exportFunction"><strong>Export Data</strong></button>
                </p> -->
            </div>
            <!-- <div class="col-md-2">
                <div id="filterInfo" class="alert alert-info" style="text-align: center" role="info">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-info" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-info"
                                role="info">Filters are applied!</span>
                        </div>
                        <div class="row">
                            <span style="font-size: 12px; vertical-align: middle;" class="alert-info" role="info">
                                To
                                change settings please visit <a href="./configuration.php">Configuration</a>.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div id="filter2Info" class="alert alert-danger" style="text-align: center" role="alert">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-danger" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-danger"
                                role="info">Filters have not been applied!</span>
                        </div>
                        <div class="row">
                            <span style="font-size: 11px; vertical-align: middle;" class="alert-danger" role="alert">
                                Please adjust the Date Filters so that Actual Date <= Forecast Date.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div id="filter3Info" class="alert alert-danger" style="text-align: center" role="alert">
                    <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                        class="glyphicon glyphicon-info-sign alert-danger" aria-hidden="true"></span>
                    <div class="info-container">
                        <div class="row">
                            <span style="font-size: 14px; vertical-align: middle;" class="alert-danger"
                                role="danger">More
                                than one product have been selected.</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <hr>
    <b>IMPORT DATA</b>
    <textarea id='distance' cols='1' rows='1' style='visibility:hidden'></textarea>

    <input type='file' id='upload' accept='.csv' style='display: none;' onchange='showfileprops()' />
    <input type='button' value='Choose file...' onclick="document.getElementById('upload').click();"
        style='background-color:orange;border-radius:5px;margin: 10px 10px 10px 10px' />

    <br>
    <div id='fileName' class='info''></div>
<div id=' fileLength' class='info''></div>
<div id=' fileSize' class='info''></div>
<div id=' fileDate' class='info''></div><br>
<div id=' fileText' class='content''></div><br>

<hr>
<b>CLUSTERING PARAMETER</b>
<br>

<select id=' series' name='series' class='main'>
        <option value="AVG">AVG: Average</option>
        <option value="MAD">MAD: Mean Absolute Deviation</option>
        <option value="MAPE">MAPE: Mean Absolute Percentage</option>
        <option value="MD">MD: Mean Deviation</option>
        <option value="MFB">MFB: Mean Forecast Bias</option>
        <option value="MPE">MPE: Mean Percentage Error</option>
        <option value="MSE">MSE: Mean Squared Error</option>
        <option value="RMSE">RMSE: Rot Mean Squared Error</option>
        </select>
        <select id='method' name='method' class='main' onchange='showmethod()'>
            <option value="kMeans">k Means</option>
            <option value="Agglomerative">Agglomerative</option>
            <option value="Affinity">AffinityPropagation</option>
            <option value="DBSCAN">DBSCAN</option>
        </select>
        <br>



        <!-- PARAMETER KMEANS -->
        <div id='km_k_text' class='text'>k =</div>
        <input id='km_k' type='text' maxlength=1 value=3 size=1 style='width:30px'>
        <div id='km_rs_text' class='text'>random_state =</div>
        <input id='km_rs' type='text' maxlength=5 value=42 size=4 style='width:80px'>
        <div id='km_init_text' class='text'>init =</div>
        <select id='km_init' name='km_init' class='sub' style='width:100px;height:24px;'>
            <option value='k-means++'>k-means++</option>
            <option value="random">random</option>
        </select>
        <div id='km_ninit_text' class='text'>n_init =</div>
        <input id='km_ninit' type='text' maxlength=2 value=1 size=1 style='width:40px'>
        <div id='km_maxiter_text' class='text'>max_iter =</div>
        <input id='km_maxiter' type='text' maxlength=3 value=1 size=1 style='width:50px'>
        <div id='km_tol_text' class='text'>tol =</div>
        <input id='km_tol' type='text' maxlength=5 value=0.0001 size=3 maxlength=7 style='width:80px'>


        <!-- PARAMETER AGGLOMERATIVE -->
        <div id='ag_k_text' class='text' style='display:none;'>k =</div>
        <input id='ag_k' type='text' maxlength=1 value=3 size=1 style='width:30px;display:none;'>
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
        <input id='af_damping' type='text' maxlength=3 value=0.5 size=1 style='width:40px;display:none;''>
<div id=' af_maxiter_text' class='text' style='display:none;'>max_iter =
    </div>
    <input id='af_maxiter' type='text' maxlength=4 value=200 size=1 style='width:40px;display:none;'>
    <div id='af_conviter_text' class='text' style='display:none;'>conv_iter =</div>
    <input id='af_conviter' type='text' maxlength=2 value=15 size=1 style='width:40px;display:none;'>

    <!-- PARAMETER MEANSHIFT -->
    <div id='ms_bin_text' class='text' style='display:none;'>conv_iter =</div>
    <select id='ms_bin' name='ms_bin' class='sub' style='display:none;width:100px;height:24px;'>
        <option value="False">False</option>
        <option value="True">True</option>
    </select>

    <!-- PARAMETER DBSCAN -->
    <div id='db_eps_text' class='text'>eps =</div>
    <input id='db_eps' type='text' maxlength=5 value=0.5 size=3 maxlength=4 style='width:80px'>



    <hr>
    <button type="button" id="startclustering">Start Clustering</button>
    <textarea cols="70" rows="2" id="status" style="border: none"></textarea>


    <hr>
    <div id='results' style='display:none;'><b>RESULTS</b></div>
    <br>
    <div id='clusterresult' class='result'></div><br>


    <canvas id="plotarea0" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea1" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea2" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea3" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea4" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea5" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea6" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea7" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea8" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>
    <canvas id="plotarea9" width="300" height="400"></canvas>
    <canvas width="10" height="400"></canvas>


    <!-- JAVASCRIPT -->
    <script type="text/javascript">
    function fehlerbehandlung(errorEvent) {
        var fehler = "Fehlermeldung:\n" + errorEvent.message + "\n" + errorEvent.filename + "\n" + errorEvent.lineno;
        alert(fehler);
        errorEvent.preventDefault();
    }

    // Show properties loaded file
    function showfileprops() {
        var selectedFile = document.getElementById('upload').files[0];
        var reader = new FileReader();
        reader.readAsText(selectedFile, "UTF-8");
        reader.onload = function(evt) {
            document.getElementById('fileText').style.height = '80px';
            document.getElementById("fileText").innerHTML = evt.target.result;
            document.getElementById('fileText').style.display = 'inline-block';

            document.getElementById("fileLength").innerHTML = (evt.target.result.split(/\r\n|\r|\n/).length - 2)
                .toString().concat(' Items');
            document.getElementById('fileLength').style.display = 'inline-block';
            document.getElementById('fileName').innerHTML = selectedFile.name;
            document.getElementById('fileName').style.display = 'inline-block';
            document.getElementById('fileDate').innerHTML = selectedFile.lastModifiedDate.toString().substring(0,
                25);
            document.getElementById('fileDate').style.display = 'inline-block';
            document.getElementById('fileSize').innerHTML = Math.round(selectedFile.size / 1024).toString().concat(
                ' kB');
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

        document.getElementById('db_eps_text').style.display = "none";
        document.getElementById('db_eps').style.display = "none";
    }

    // show DOMs with parameters DBSCAN
    function show_db() {
        document.getElementById('db_eps_text').style.display = "inline-block";
        document.getElementById('db_eps').style.display = "inline-block";
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
        document.getElementById('af_maxiter_text').style.display = "inline-block";
        document.getElementById('af_maxiter').style.display = "inline-block";
        document.getElementById('af_conviter_text').style.display = "inline-block";
        document.getElementById('af_conviter').style.display = "inline-block";
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
        document.getElementById('km_rs_text').style.display = "inline-block";
        document.getElementById('km_rs').style.display = "inline-block";
        document.getElementById('km_init_text').style.display = "inline-block";
        document.getElementById('km_init').style.display = "inline-block";
        document.getElementById('km_ninit_text').style.display = "inline-block";
        document.getElementById('km_ninit').style.display = "inline-block";
        document.getElementById('km_maxiter_text').style.display = "inline-block";
        document.getElementById('km_maxiter').style.display = "inline-block";
        document.getElementById('km_tol_text').style.display = "inline-block";
        document.getElementById('km_tol').style.display = "inline-block";
    }

    // show DOMs with parameters
    function showmethod() {
        var e = document.getElementById("method");
        var value = e.options[e.selectedIndex].value;
        var text = e.options[e.selectedIndex].text;
        console.log(text);

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
        if (text == "DBSCAN") {
            show_db()
        };
    }
    </script>


    <!-- get Pyodide files from internet -->

    <script type="text/javascript">
    window.languagePluginUrl = 'https://pyodide-cdn2.iodide.io/v0.15.0/full/';
    </script>
    <script src="https://pyodide-cdn2.iodide.io/v0.15.0/full/pyodide.js"></script>


    <!-- get Pyodide files from localhost -->
    <!--
<script src="pyodide_dev.js"></script>
-->


    <script type="text/javascript">
    // Start after Button Clustering!
    document.getElementById("startclustering").onclick = function() {
        checks()
    };

    function checks() {


        document.getElementById("clusterresult").value = 'Calculation started.'


        window.addEventListener("error", fehlerbehandlung);
        document.getElementById('results').style.display = "none";

        // hide DOM results
        document.getElementById('clusterresult').style.display = "none";
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

        // CHECK PARAMETER DBSCAN
        if (document.getElementById('method').value == 'DBSCAN') {
            console.log('check para DBSCAN.')

            var temp = document.getElementById('db_eps').value
            if (isNaN(temp) || parseFloat(temp) <= 0) {
                alert('Use a float >=0 for eps.')
                return;
            }

            alert(
                "DBSCAN cannot be exectued with pyodide. The same code works in Jupyter Notebooks. Errormessages: .1. File sklearn/cluster/_dbscan_inner.pyx, line 38, in sklearn.cluster._dbscan_inner.dbscan_inner .2. ValueError: Buffer dtype mismatch, expected npy_intp but got long long"
                )
            return;
        }

        // PARAMETER ARE OK
        clustering()

    }

    function clustering() {
        document.getElementById("status").value = 'Loaded:\nLoading: pyodide'
        languagePluginLoader.then(() => {

            document.getElementById("status").value = 'Loaded: pyodide.\nLoading: joblib......';
            pyodide.loadPackage(['joblib']).then(() => {
                document.getElementById("status").value =
                    "Loaded: pyodide, joblib.\nLoading numpy......";
                pyodide.loadPackage(['numpy']).then(() => {
                    document.getElementById("status").value =
                        "Loaded: pyodide, joblib, numpy.\nLoading: scipy......";
                    pyodide.loadPackage(['scipy']).then(() => {
                        document.getElementById("status").value =
                            "Loaded: pyodide, joblib, numpy, scipy.\nLoading scikit-learn......";
                        pyodide.loadPackage(['scikit-learn']).then(() => {
                            document.getElementById("status").value =
                                "Loaded: pyodide, joblib, numpy, scipy, scikit-learn.\nLoading Python code."

                            console.log(
                                "All libraries loaded. Pyodide started.")

                            document.getElementById('results').style.display =
                                "inline-block";
                            document.getElementById('clusterresult').style
                                .display = "inline-block";




                            // START PYTHON
                            pyodide.runPython(`
print('Start Python.')


import numpy as np
import itertools
import sklearn
from sklearn.cluster import KMeans
from sklearn.cluster import AgglomerativeClustering
from sklearn.cluster import AffinityPropagation
from sklearn.cluster import MeanShift, estimate_bandwidth
from sklearn.cluster import DBSCAN

from sklearn.metrics import davies_bouldin_score
from sklearn.metrics import silhouette_score

from io import StringIO
from js import document, alert

#print('The scikit-learn version is {}.'.format(sklearn.__version__))

def graph(ctx,x0,x1,y0,y1,week,y,cent,y_range):
	figure_y_values(ctx,x0,x1,y0,y1,y_range)
	week = week.astype('int32') 
	xmin,xmax = min(week),max(week)
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

	# Converting string to list
	for j in y:
		for i in range(len(x)):
			xpoint, ypoint = change_ref_system(x0,x1,y0,y1,xmax,y_range,x[::-1][i], j[i])
			#ctx.fillRect(xpoint-5,ypoint-5,9,9)
			if i>0:
				draw_line(ctx, xold, yold, xpoint, ypoint, linethick = 1)
			xold, yold = xpoint, ypoint

	# plot centroids
	for i in range(len(x)):
		xpoint, ypoint = change_ref_system(x0,x1,y0,y1,xmax,y_range,x[::-1][i], cent[i])
		ctx.fillStyle = '#FF0000'
		ctx.fillRect(xpoint-5,ypoint-5,9,9)

def axis(ctx,y_range,x0,x1,y0,y1,color = "black", linethick = 3):
	#Draw of x,y axis
	draw_line(ctx, x0, y0, x0, y1, linethick = 2.0) # y left
	draw_line(ctx, x1, y0, x1, y1, linethick = 0.5) # y right
	draw_line(ctx, x0, y1, x1, y1, linethick = 0.3) # x top
	draw_line(ctx, x0, y1, x1, y1, linethick = 0.3) # x bottom

	#y = y0 + 0.5*(y1-y0)*y_range[1]/y_range[0])
	if y_range[0] == 0:
		y = y0
	else:
		y = (y1 - y0*y_range[1]/y_range[0]) / (1-y_range[1]/y_range[0])
	draw_line(ctx, x0, y, x1, y, linethick = 2.0) # x Null		

def figure_title(ctx,title,c_size,y_range):
	#ctx.clearRect(c_size[0]/2 - 20, 0, c_size[0]/2 + 30, 18)
	ctx.fillStyle = 'black'
	ctx.font = "bold 16px Arial"
	ctx.fillText(title, c_size[0]/2 - len(title)*3, 12)

def figure_y_title(ctx,title,c_size,y_range):
	x = 4
	y = c_size[1]/2 - 50
	lineHeight = 15
	ctx.save()
	ctx.fillStyle = 'black'
	ctx.translate(x, y)
	ctx.rotate(-3.14142 / 2)
	ctx.textAlign = 'center'
	#ctx.font = "bold 14px verdana, sans-serif";
	ctx.font = "bold 16px Arial, sans-serif";
	ctx.fillText(title, 0, lineHeight / 2)
	ctx.restore()

def figure_y_values(ctx,x0,x1,y0,y1,y_range):

	for i in range(6):
		ctx.save()
		ctx.font = "bold 12px Arial"
		ctx.fillStyle = "black"
		ctx.textAlign = 'right'
		if y_range[1]<1:
			y = round(y_range[1]-i*(y_range[1]-y_range[0])/5,1)
		else:
			y = y_range[1]-i*(y_range[1]-y_range[0])/5
		ctx.fillText(y, 50, y1+6+(y0-y1)*i/5)
		ctx.restore()
		draw_line(ctx, x0, y1+(y0-y1)*i/5, x1,  y1+(y0-y1)*i/5, linethick = 0.3)
		
def draw_line(ctx, x1, y1, x2, y2, linethick = 1, color = "black", dash = False):
	ctx.beginPath()
	ctx.lineWidth = linethick
	ctx.moveTo(x1, y1)
	ctx.lineTo(x2, y2)
	ctx.strokeStyle = color
	if dash:
		ctx.setLineDash([5, 15])
	else:
		ctx.setLineDash([])
	ctx.stroke()

def change_ref_system(x0,x1,y0,y1,xmax,y_range,x, y):
	xoff = 10
	return (x0+xoff + x/xmax *(x1-x0-2*xoff),
			y0 - (y-y_range[0]) * (y0-y1) / (y_range[1]-y_range[0])  )

def clustercenter(X,labels,k):
	centroids = []
	for i in range(k):
		points = [X[j] for j in range(len(X)) if labels[j] == i]
		centroids.append(np.mean(points, axis=0))
	return centroids


print('Start Clustering')

mystring = document.getElementById('fileText').innerHTML.replace(',', '.')
myarray = np.loadtxt(StringIO(mystring), skiprows = 1, delimiter = ';', usecols = (0,1,2,3,4,5,6,7,8,9),
                    dtype={'names': ('PR','PBD', 'AVG', 'MSE', 'RMSE', 'MAPE', 'MPE', 'MAD', 'MD', 'MFB'),
                           'formats': ('S3','S2','i4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4', 'f4')})

myarray = np.array(myarray.tolist())
u_pr  = np.unique(np.array(myarray[:,0]))
# pbd: strings must be sorted as numbers
u_pbd = np.array(sorted(list(set(myarray[:,1])),key=int))

#print('Creating lookup dictionary')

#colnr=2
if document.getElementById('series').value == 'AVG':
	colnr=2
if document.getElementById('series').value == 'MAD':
	colnr=7
if document.getElementById('series').value == 'MAPE':
	colnr=5
if document.getElementById('series').value == 'MD':
	colnr=8
if document.getElementById('series').value == 'MFB':
	colnr=9
if document.getElementById('series').value == 'MPE':
	colnr=6
if document.getElementById('series').value == 'MSE':
	colnr=3
if document.getElementById('series').value == 'RMSE':
	colnr=4
#if colnr == 2:
#	document.getElementById('series').value = 'AVG'


D = dict(zip(map(tuple, myarray[:,[0,1]]), myarray[:,[colnr]].ravel().tolist()))

X = np.array(list(map(D.get, itertools.product(u_pr, u_pbd)))).reshape(len(u_pr),len(u_pbd))
X = X.astype(np.float)


print('Pivot Table created.')

print('Method selected',document.getElementById('method').value)

# K MEANS
if document.getElementById('method').value == 'kMeans':
	print('k Means Clustering started.')
	n_clusters   = int(document.getElementById("km_k").value)
	init         = document.getElementById("km_init").value	
	n_init       = int(document.getElementById("km_ninit").value)
	max_iter     = int(document.getElementById("km_maxiter").value)
	tol          = float(document.getElementById("km_tol").value)
	random_state = int(document.getElementById("km_rs").value)
	model = KMeans(n_clusters=n_clusters, init=init,n_init=n_init, max_iter= max_iter, tol= tol, random_state=random_state)
	y_model = model.fit_predict(X)
	clustercenters = model.cluster_centers_
	print('k Means Clustering finished.')

# AGGLOMERATIVE
if document.getElementById('method').value == 'Agglomerative':
	print('Agglomerative Clustering started.')
	n_clusters   = int(document.getElementById('ag_k').value)
	linkage      = document.getElementById('ag_linkage').value	
	if linkage == 'ward':
		metric = 'euclidean'
		document.getElementById('ag_metric').value = 'euclidean'
	metric = document.getElementById('ag_metric').value
	print(n_clusters,linkage,metric)
	model = AgglomerativeClustering(n_clusters=n_clusters,linkage= linkage, affinity=metric)
	#model = AgglomerativeClustering(n_clusters=n_clusters,linkage="average", affinity='cosine')
	print('Agglomerative Clustering finished.')
	y_model = model.fit_predict(X)
	clustercenters = clustercenter(X,y_model,n_clusters)
	
# AFFINITY PROPAGATION
if document.getElementById('method').value == 'Affinity':
	print('AffinityPropagation Clustering started.')
	#print(float(document.getElementById('damping').value))
	damping   = float(document.getElementById('af_damping').value)
	max_iter  = int(document.getElementById("af_maxiter").value)
	conv_iter = int(document.getElementById("af_conviter").value)
	af = AffinityPropagation().fit(X)
	af = AffinityPropagation(damping=damping, max_iter= max_iter, convergence_iter = conv_iter).fit(X)
	y_model = af.labels_
	n_clusters = len(af.cluster_centers_indices_)
	print('AffinityPropagation Clustering finished.')
	clustercenters = []
	for i in af.cluster_centers_indices_:
		clustercenters.append(X[i])

# MEANSHIFT
if document.getElementById('method').value == 'MeanShift':
	print('MeanShift started.')
	binseed = document.getElementById('binseed').value
	# The following bandwidth can be automatically detected using
	bandwidth = estimate_bandwidth(X, quantile=0.2, n_samples=10)
	print(binseed)
	#ms = MeanShift(bandwidth=2,bin_seeding=binseed).fit(X)
	ms = MeanShift().fit(X)
	print('aaa')
	y_model = ms.labels_
	print('aaa')
	clustercenters = ms.cluster_centers_
	print('aaa')
	n_clusters = len(np.unique(ms.labels_))
	print('aaa')
	dbs = davies_bouldin_score(X,y_model)
	print('aaa')
	sil = silhouette_score(X,y_model)
	print('MeanShift finshed.')

# DBSCAN
if document.getElementById('method').value == 'DBSCAN':
	print('DBSCAN started.')
	eps = float(document.getElementById('db_eps').value)
	db = DBSCAN(eps=eps).fit(X)
	#core_samples_mask = np.zeros_like(db.labels_, dtype=bool)
	#core_samples_mask[db.core_sample_indices_] = True
	y_model = db.labels_
	print('y_model DBSCAN',y_model)
	# Number of clusters in labels, ignoring noise if present.
	n_clusters = len(set(y_model))
	#n_noise_ = list(labels).count(-1)
	#dbs = davies_bouldin_score(X,y_model)
	#sil = silhouette_score(X,y_model)
	dbs=0
	sil=0
	clustercenters = clustercenter(X,y_model,n_clusters)



if (n_clusters > 1) and (n_clusters < len(u_pr)):
	dbs = davies_bouldin_score(X,y_model)
	sil = silhouette_score(X,y_model)
else:
	dbs, sil = 0, 0

print('Clustering labels created.')

# number of clusters is partly a result
if document.getElementById('method').value == 'Affinity':
	my_string = 'Number Clusters: ' + str(n_clusters) + '<br>'
elif document.getElementById('method').value == 'MeanShift':
	my_string = 'Number Clusters: ' + str(n_clusters) + '<br>'
else:
	my_string = ''


# CALCULATE KPIs
if (n_clusters > 1) and (n_clusters != len(u_pr)):
	# '\\r\\n'
	my_string = my_string + 'Davies-Bouldin Score: ' + str(dbs)[0:6] + '<br>'
	my_string = my_string + 'Silhouette-Score:     ' + str(sil)[0:6] + '<br>'
elif n_clusters == 1:
	my_string = my_string + 'Davies-Bouldin Score: n.a. for 1 cluster <br>'
	my_string = my_string + 'Silhouette-Score:     n.a. for 1 cluster <br>'
else:
	my_string = my_string + 'Davies-Bouldin Score: n.a. for all items in different clusters<br>'
	my_string = my_string + 'Silhouette-Score:     n.a. for for all items in different clusters<br>'


# SHOW RESULTS
if n_clusters >0:
	c_string = ['']*n_clusters
	i = 0
	for j in y_model:
		#c_string[j] += products[i].decode("utf-8") + ' '
		c_string[j] += u_pr[i].decode("utf-8") + ' '
		i += 1
	for i in range(n_clusters):
		#my_string += "Cluster " + str(i) + ": " + c_string[i] + '\\r\\n'
		my_string += "Cluster " + str(i) + ": " + c_string[i] + '<br>'
else:
	my_string = 'ConvergenceWarning: Affinity propagation did not converge, this model will not have any cluster centers.'

document.getElementById("clusterresult").innerHTML = my_string


# CREATE PLOTS
y_max = np.amax(X)
y_min = np.amin(X)

x = len(str(int(y_max)))-1
if int(y_max) == 0:
	y1 = round(y_max*10/(10**x)+0.5,0)*10**x/10
if (y_max < 0.5):
	y1 = round(y_max+0.1,1)
if (y_max >1) and (y_max<=2):
	y1 = round(y_max/(10**x)+0.05,1)*10**x
if (y_max > 2):
	y1 = round(y_max/(10**x)+0.5,0)*10**x

y_min = min(0,y_min)
if y_min == 0:
	y0 = 0
else:
	x = len(str(int(y_min)))-2
	y0 = round(y_min/(10**x)-0.5,0)*10**x

y_range = [round(min(y0,0),3), y1]

c_size = [300,400] # canvas width, height


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
	x0, y0 = 65         , c_size[1]-100
	x1, y1 = c_size[0]-5, 30
	axis(ctx,y_range,x0,x1,y0,y1,color = "black", linethick = '3')

	#title = 	my_string = document.getElementById('series').value
	title = document.getElementById('method').value + ': Cluster ' + str(cnr)
	figure_title(ctx, title, c_size, y_range)
	
	#figure_y_title(ctx,doc['errortype'].value, c_size, y_range)
	figure_y_title(ctx,document.getElementById('series').value, c_size, y_range)

	week = []
	for i in range(14):
		week.append(i)

	cluster = X[y_model == cnr]

	graph(ctx,x0,x1,y0,y1,u_pbd,cluster,clustercenters[cnr],y_range)

document.getElementById("status").textcontent = 'Loaded: pyodide, joblib, numpy, scipy, scikit-learn, Python Code.\\nDone.'


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