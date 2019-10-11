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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configuration</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="../lib/js/localforage.js"></script>
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2">
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="http://d3js.org/d3.v4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="../lib/js/ion.rangeSlider.js"></script>

    <script>
    localforage.config({
        driver: localforage.WEBSQL, // Force WebSQL; same as using setDriver()
        name: 'innoFit',
        version: 1.0,
        size: 4980736, // Size of database, in bytes. WebSQL-only for now.
    });
    </script>

    <link rel="stylesheet" href="../lib/css/ion.rangeSlider.css">
    <link rel="icon" href="/data/ico/innofit.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
    body {
        margin: 0 auto;
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
        font-size: 16px;
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

    .irs-handle,
    .irs-bar,
    .irs-single,
    .irs-from:before,
    .irs-to:before,
    .irs--flat {
        cursor: pointer;
        border-top-color: #336699 !important;
    }

    .irs-bar {
        background-color: #336699 !important;
    }

    .irs-single,
    .irs-from,
    .irs-to {
        background-color: #336699 !important;
        font-size: 12px;
    }

    .irs-handle,
    .irs--flat .irs-handle {
        width: 15px;
        height: 30px;
        left: -.6em;
    }

    .irs-grid-text {
        font-size: 12px;
        position: absolute;
        color: #585858 !important;
    }
    </style>
    <script type="text/javascript">

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
                    <li class="active"><a href="./configuration.php">Configuration <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li><a href="./about.php">About</a></li>
                    <li class><a href="./howto.php">How to Interpret Error Measures </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">Visualizations<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./finalorder.php">Final Order Amount </a></li>
                            <li><a href="./deliveryplans.php">Delivery Plans </a></li>
                            <li><a href="./forecasterror.php">Percentage Error</a></li>
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
    <div class="customContainer">
        <div class="row" style="margin-bottom: -2%;">
                <div class="col-md-10">
                <h1>Configuration</h1><br/>
                    <h4><?php   echo "Dear ";
                    print_r($_SESSION["session_username"]);
                    echo ",";?></h4>
                    <p>On this page you can find the instructions on the data format requirements and the filter
                        settings.
                    </p>
                </div>
                <div class="col-md-2">
                    <div id="filterInfo" class="alert alert-info" style="text-align: center" role="info">
                        <span style="font-size: 25px; vertical-align: middle; padding:0px 10px 0px 0px;"
                            class="glyphicon glyphicon-info-sign alert-info" aria-hidden="true"></span>
                        <div class="info-container">
                            <div class="row">
                                <span style="font-size: 14px; vertical-align: middle;" class="alert-info"
                                    role="info">Filters
                                    are applied!</span>
                            </div>
                            <div class="row">
                                <span style="font-size: 11px; vertical-align: middle;" class="alert-info" role="info">
                                    To
                                    change settings please visit <a href="./configuration.php"><u>Configuration</u></a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Product Selection</h3>
                    <p>Please select the product or products you want to visualize </p> <br />
                    <select name=productsList[] id="products" class="form-control" multiple="multiple" size="5">

                        <option value="">- Select None -</option>
                        <!-- <option value='1'>Software Development</option> -->
                    </select>

                </div>
            </div>

            <div class="row" style="margin-top: 5%;">
                <div class="col-md-12">
                    <h3>Actual Date Slider</h3>
                    <p>Please select the Actual Date range here: the data will be filtered from the selected range
                        onwards.
                    </p>
                    <br />
                    <input id="actualDateSlider" type="text" class="js-range-slider" name="my_range" value="" />
                </div>
            </div>
            <div class="row" style="margin-top: 5%;">
                <div class="col-md-12">
                    <h3>Due Date Slider</h3>
                    <p>Please select the Due Date range here: the data will be filtered until the selected time range.
                    </p>
                    <br />
                    <input id="forecastDateSlider" type="text" class="js-range-slider" name="my_range" value="" />
                </div>
            </div>
            <div class="row" style="margin-top: 5%;">
                <div class="col-md-2">
                    <button id="btnResetFilters" class="btn btn-secondary">Reset Filters</button>
                </div>
                <div class="col-md-10 pull-right">
                    <button id="btnApplyFilters" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>

        </div>

        <script>
        $(document).ready(function() {
            if (localStorage.getItem('checkFiltersActive') === 'true') {
                $('#filterInfo').show();
            } else {
                $('#filterInfo').hide();
            }
        });

        let lang = "en-GB";
        let actualDateMinValue = 0;
        let actualDateMaxValue = 0;
        let forecastDateMinValue = 0;
        let forecastDateMaxValue = 0;
        let newProductList = [];


        $(document).ready(function() {
            if (localStorage.getItem('checkFiltersActive') === 'true') {
                console.log('I WANT TO RESET');
                $('#btnResetFilters').prop('disabled', false);
            } else {
                d3.select('#btnResetFilters').attr('disabled', true);
            }
        });

        function dateToTS(date) {
            return date.valueOf();
        }

        function tsToDate(ts) {
            var d = new Date(ts);

            return d.toLocaleDateString(lang, {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        localforage.getItem('all_data').then(function(data) {
            data = JSON.parse(data);
            console.log('ORIGINAL DATA', data);

            // Get the unique names of our products
            const uniqueNames = [...new Set(data.map(i => i.Product))];
            console.log('Names array: ', uniqueNames);


            // Get min and max ActualDate
            const minADate = (data.reduce((m, v, i) => (v.ActualDate < m.ActualDate) && i ? v : m)
                .ActualDate).slice(0, -9);
            // console.log('Min ADate: ', minADate);
            const maxADate = (data.reduce((m, v, i) => (v.ActualDate > m.ActualDate) && i ? v : m)
                .ActualDate).slice(0, -9);
            // console.log('Max ADate: ', maxADate);

            // Get min and max ForecastDate
            const minFDate = (data.reduce((m, v, i) => (v.ForecastDate < m.ForecastDate) && i ? v : m)
                .ForecastDate).slice(0, -9);
            // console.log('Min FDate: ', minFDate);
            const maxFDate = (data.reduce((m, v, i) => (v.ForecastDate > m.ForecastDate) && i ? v : m)
                .ForecastDate).slice(0, -9);
            // console.log('Max FDate: ', maxFDate);

            $("#actualDateSlider").ionRangeSlider({
                type: "double",
                skin: 'round',
                step: 86400000,
                min: dateToTS(new Date(minADate)),
                max: dateToTS(new Date(maxADate)),
                from: dateToTS(new Date(minADate)),
                to: dateToTS(new Date(maxADate)),
                grid: true,
                prettify: tsToDate,
                onStart: function(data) {
                    actualDateMinValue = data.from;
                    actualDateMaxValue = data.to;
                },
                onFinish: function(data) {
                    actualDateMinValue = data.from;
                    actualDateMaxValue = data.to;
                },
            });

            $("#forecastDateSlider").ionRangeSlider({
                type: "double",
                skin: 'round',
                step: 86400000,
                min: dateToTS(new Date(minFDate)),
                max: dateToTS(new Date(maxFDate)),
                from: dateToTS(new Date(minFDate)),
                to: dateToTS(new Date(maxFDate)),
                grid: true,
                prettify: tsToDate,
                onStart: function(data) {
                    forecastDateMinValue = data.from;
                    forecastDateMaxValue = data.to;
                },
                onFinish: function(data) {
                    forecastDateMinValue = data.from;
                    forecastDateMaxValue = data.to;
                },
            });

            var options = '';
            for (var i = 0; i < uniqueNames.length; i++) {
                options += '<option value="' + uniqueNames[i] + '">' + uniqueNames[i] + '</option>';
            }
            $("#products").append(options);

            d3.select('#btnApplyFilters').on('click', function(e) {
                let productNames = $.map($(".form-control option:selected"), function(option) {
                    return option.value;
                });

                console.log('FILTERING STARTS HERE');
                console.log('Filter Parameters: ');
                console.log('Product Names', productNames);
                console.log('actual Min Date: ', actualDateMinValue);
                console.log('actual Max Date: ', actualDateMaxValue);
                console.log('forecast Min Date: ', forecastDateMinValue);
                console.log('forecast Max Date: ', forecastDateMaxValue);

                // 1. Filter by Product Name
                let filteredByProduct = data;
                if (productNames.length > 0 && productNames[0] !== "") {
                    filteredByProduct = data.filter(item => productNames.includes(item
                        .Product));
                    console.log('Product: ', filteredByProduct);
                }
                // 2. Filter by Actual Date based on filtered product
                let filteredByActualDate = filteredByProduct.filter((item) => {
                    const actualDateInt = new Date(item.ActualDate.slice(0, -9)).getTime();

                    return actualDateInt >= actualDateMinValue && actualDateInt <=
                        actualDateMaxValue;
                });
                console.log('Product and Actual Date filter applied: ', filteredByActualDate);

                // 3. Filter by Forecast Date based on filtered product and actual date
                let filteredByForecastDate = filteredByActualDate.filter((item) => {
                    const forecastDateInt = new Date(item.ForecastDate.slice(0, -9)).getTime();

                    return forecastDateInt >= forecastDateMinValue && forecastDateInt <=
                        forecastDateMaxValue;
                });

                console.log('Product, Actual Date and Forecast Date filters applied: ',
                    filteredByForecastDate);

                productNames = [];
                Swal.fire(
                    'Filters applied!',
                    'Your filters have been applied. Please visit the Visualizations.',
                    'success');
                localforage.setItem('viz_data', JSON.stringify(filteredByForecastDate));

                if (data.length === filteredByForecastDate.length) {
                    localStorage.setItem('checkFiltersActive', false);
                } else {
                    localStorage.setItem('checkFiltersActive', true);
                }
            });

            d3.select('#btnResetFilters').on('click', function(e) {
                Swal.fire(
                    'Filters reset!',
                    'Your filter settings have been reset. No Filters are applied!',
                    'info');
                localforage.setItem('all_data', JSON.stringify(data));
                localforage.setItem('viz_data', JSON.stringify(data));
            });

        });
        </script>

        <script src="/lib/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>

</body>

</html>