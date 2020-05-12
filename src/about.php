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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/about.css">
    <link rel="stylesheet" href="./css/header.css">
    <title>About This Tool</title>
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
                    <li><a class="specialLine" href="./configuration.php">Configuration</a>
                    </li>
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
                    <!-- </ul> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle specialLine" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">Corrections <span class="caret"></span> </a>
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
                    <li><a id="btnLogout" href="/includes/logout.php"><span class="glyphicon glyphicon-log-out"></span>
                            Logout</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

    <div class="customContainer">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12">
                <h2><strong>About the research project</strong></h2><br>
                <small>
                    <?php
                                echo "You are logged in as: ";
                                print_r($_SESSION["session_username"]);
                                echo ".";
                                ?></small><br />
            </div>
        </div>
        <hr />
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-6">
                <h4><strong>Introduction</strong></h4>
                <p class="class-text">
                    This tool was created as a part of the <strong>InnoFIT research project</strong>,
                    which aims at
                    developing innovative forecasting tools for improved production
                    planning. The project is funded by the Austrian Research Promotion Agency
                    <a href="https://www.ffg.at/en/content/about-ffg"
                        title="Austrian Research Promotion Agency">(FFG)</a> and runs from 1 June 2018
                    until 31 May
                    2021.
                </p>
            </div>
            <div class="col-md-6">
                <picture><img src="/data/img/Logo_transparent.png" sizes="35vw" srcset="/data/img/Logo_transparent.png 100w, /data/img/Logo_transparent.png 900w,
				/data/img/Logo_transparent.png 7000w">
                </picture>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <h4><strong> Project Partners</strong>
                    <br />
                    <br />
                    <small>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" style="background: #F8F8F8;">
                                <strong>Academic Project Partners:</strong>
                            </li>
                            <li class="list-group-item">University of Applied Sciences Upper Austria, Campus Steyr
                                <ul class="list-group inner">
                                    <li class="list-group-item">UAS Steyr Project leader: <a
                                            href="http://research.fh-ooe.at/en/staff/3584">Priv.
                                            Doz.
                                            FH-Prof. DI (FH) Klaus Altendorfer PhD</a></li>
                                </ul>
                            </li>
                            <li class="list-group-item">St. Pölten University of Applied Sciences
                                <ul class="list-group inner">
                                    <li class="list-group-item"> UAS St. Pölten Project leader: <a
                                            href="https://www.fhstp.ac.at/en/about-us/staff-a-z/felberbauer-thomas">Dr.
                                            Thomas
                                            Felberbauer, MSc</a></li>
                                </ul>
                            </li>
                            <li class="list-group-item" style="background: #F8F8F8;">
                                <strong>Industrial Project Partners:</strong>
                            </li>
                            <li class="list-group-item">
                                RISC Software GmbH
                            </li>
                            <li class="list-group-item">
                                NKE Austria GmbH
                            </li>
                            <li class="list-group-item">
                                ZF Steyr
                            </li>
                            <li class="list-group-item">
                                MWS
                            </li>
                            <li class="list-group-item">
                                Hightec GmbH
                            </li>
                            <li class="list-group-item">
                                Hightec GmbH
                            </li>
                            <li class="list-group-item">
                                Lecapell GmbH
                            </li>
                        </ul>
                    </small>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <h4><strong>Download section</strong></h4>
                <strong><i>InnoFit Project Poster:</i></strong>
                <br />
                Office 365 access: <a
                    href="https://fhstp.sharepoint.com/sites/InnoFIT/Freigegebene%20Dokumente/General/Posters/InnoFIT_one%20version.pdf"
                    target="_blank">Download link 1</a><br>
                External access: <a href="https://www.dropbox.com/s/c2a2ew6o48wdubs/InnoFIT_one%20version.pdf?dl=0"
                    target="blank"> Download link 2 </a>
            </div>
        </div>
        
        <div class="row" style="margin-top: 40px;">
        <div class="col-md-12">
            <h4><strong>Project Team Photo</strong></h4>
            <div class="card">
                <img class="card-img-top" src="/data/img/Projektteam.jpg" alt="Team Picture" style="max-width:100%;height:auto;">
                <div class="card-body">
                    <p class="card-text"><small>Image source: UAS Upper Austria / Andreas Schober</small></p>
                </div>
            </div>
        </div>
    </div>


    <div id="footer" class="text-center" style="margin-top: 20px;">
        <!-- Copyright -->
            <br>
            <p> Copyright © 2019 St. Pölten University of Applied Sciences <u>
                <ul><a href="https://projekte.ffg.at/projekt/3042801">InnoFIT Research Project </a></ul>
            </u></p>
        <!-- Copyright -->
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
</body>

</html>