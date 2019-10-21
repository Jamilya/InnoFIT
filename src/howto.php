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
		<title>How to Use Error Measures</title>
		
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
        div.minimalistBlack {
  border: 0px solid #000000;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
.divTable.minimalistBlack .divTableCell, .divTable.minimalistBlack .divTableHead {
  border: 1px solid #000000;
  padding: 5px 1px;
}
.divTable.minimalistBlack .divTableBody .divTableCell {
  font-size: 15px;
}
.divTable.minimalistBlack .divTableHeading {
  background: #CFCFCF;
  background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
  background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
}
.divTable.minimalistBlack .divTableHeading .divTableHead {
  font-size: 15px;
  font-weight: bold;
  color: #000000;
  text-align: left;
}
.minimalistBlack .tableFootStyle {
  font-size: 14px;
  font-weight: bold;
  color: #000000;
  border-top: 3px solid #000000;
}
.minimalistBlack .tableFootStyle {
  font-size: 14px;
}
/* DivTable.com */
.divTable{ display: table; }
.divTableRow { display: table-row; }
.divTableHeading { display: table-header-group;}
.divTableCell, .divTableHead { display: table-cell;}
.divTableHeading { display: table-header-group;}
.divTableFoot { display: table-footer-group;}
.divTableBody { display: table-row-group;}
		</style>

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
            <!-- <li class><a href="./about.php">About</a></li>
            <li class = "active"><a href="./howto.php">How to Interpret Error Measures   <span class="sr-only">(current)</span></a></li> -->
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li ><a href="./finalorder.php">Final Order Amount </a></li>
                    <li ><a href="./deliveryplans.php">Delivery Plans </a></li>
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

<div class="row1" style="padding-left:39px">
<div class="col-sm-8"> 
<small>
<?php
echo "You are logged in as: ";
print_r($_SESSION["session_username"]);
echo ".";
?></small>
<br><br>
		<h5 class = "card-title"><strong>Description and guidelines on how to interpret and use the error measures</strong></h5>
	<div class = "row1"> 
		<div class="col-sm-6">
		    <p class = "class-text"> 
	    	
	    	<!-- This page will help you to understand how to use and analyze the error measures shown in this web tool.</p> -->
	    </div>

<div class="divTable minimalistBlack">
<div class="divTableHeading">
<div class="divTableRow">
<div class="divTableHead">Error Measures&nbsp;</div>
<div class="divTableHead">Description and How to use error measures&nbsp;</div>
<div class="divTableHead">Formula&nbsp;</div>
</div>
</div>
<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell">Mean Absolute Deviation (MAD)</div>
<div class="divTableCell">The mean absolute deviation describes the absolute average error between the forecasted and the final order amounts. MAD represents the average error of forecast deviation from the final order. Since the estimation is in absolute values, <b> it does not show whether there was over- or under-booking in the forecast. </b></div>
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?MAD_{j} = \frac{1}{n}\sum_{i=1}^{n}{\left | x_{i,j}-x_{i,0} \right |}" title="MAD_formula"></div>
</div>
<div class="divTableRow">
<div class="divTableCell">Mean Squared Error (MSE) </div>
<div class="divTableCell">Mean Squared Error (the mean/average of the squared errors) measures the quality of forecast estimation (zero meaning perfect accuracy) with respect to periods before delivery, and the values closer to zero are better.
MSE measures the variance and the bias of forecasts to the final customer orders, and <b> it is very sensitive to outliers in data. </b><br>
<b>The linear regression measure of MSE provides information on performance of the forecasting behaviour and the extent to which the data gets close to the final order estimation.</b></div>
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?MSE_{j} = \frac{1}{n}\sum_{i=1}^{n}(x_{i,j}-x_{i,0})^{2}" title="MSE formula"></div>
</div>
<div class="divTableRow">
<div class="divTableCell">Root Mean Square Error (RMSE)</div>
<div class="divTableCell">Root Mean Square Error (square root of the squared errors), like the Mean Squared error,  measures forecast accuracy representing difference between forecasted and final (observed) customer orders (zero meaning perfect score) with respect to periods before delivery. 
RMSE should always be non-negative, and lower RMSE is better than a higher one. Different forecast horizons would result in different RMSE, since the measure is dependent on the scale of data used. <b>It is also very sensitive to outliers in data.</b> </div>
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?RMSE_{j} = \sqrt{\frac{1}{n}\sum_{i=1}^{n} ( x_{i,j} - x_{i,0})^{2}}" title="RMSE formula"></div>
</div>
<div class="divTableRow">
<div class="divTableCell">Mean Percentage Error (MPE)</div>
<div class="divTableCell">MPE represents the evaluation of forecasting accuracy, calculated by the difference between forecasted customer orders and the final customer orders, divided by the final customer orders. It represents the bias in the forecast behaviour with respect to periods before delivery. In our visualization, we provide a weighted mean estimation of MPE.
<br> <b>Positive or negative estimation represents whether there was over- or under-booking in forecasts.</b></div> 
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?MPE_{j} = \frac {\sum_{i=1}^{n}x_{i,j}-x_{i,0}}{\sum_{i=1}^{n}x_{i,0}}" title="MAPE formula"></div>
</div>
<div class="divTableRow">
<div class="divTableCell">Mean Absolute Percentage Error (MAPE) </div>
<div class="divTableCell">MAPE represents the error measure to evaluate forecasting accuracy with respect to periods before delivery, which is calculated by the difference between 
forecasted customer orders and the final customer orders and divided by the final customer orders. The forecast accuracy is represented in percentage estimation. In our visualization, we provide a weighted mean estimation of MAPE.<br>
However, <b> it does not provide good measure of "good" and "bad" forecasts.</b> For example, it can be interpreted differently for stable vs. unstable demand, having the same estimation, 
it can have different meangings, therefore, there is a risk of overlooking some contexts when the optimal forecast can deviate significantly from a least-mean-percentage-error prediction. 
Since it only represents the "demand range", the possible solution is to apply this error measure to evaluate to what extent the forecast satisfies the company's objectives (Danese and Kalchschmidt, 2011). </div>
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?MAPE_{j} = \frac {\sum_{i=1}^{n}|x_{i,j}-x_{i,0}|}{\sum_{i=1}^{n}x_{i,0}}" title="MAPE formula"></div>
</div>
<div class="divTableRow">
<div class="divTableCell">Mean Forecast Bias (MFB)</div>
<div class="divTableCell">MFB is the measure describing the <b>mean forecast error</b>, or the expected value of forecast errors over a defined time horizon, which is defined by <b>consistent differences between forecasted and final customer order estimations</b>. <br>In our visualization, MFB is calculated as a weighted mean forecast error estimation with respect to periods before delivery.</div>
<div class="divTableCell"><img src="https://latex.codecogs.com/gif.latex?MFB_{j} = \frac {\sum_{i=1}^{n}x_{i,j}}{\sum_{i=1}^{n}x_{i,0}}" title="Mean Forecast Bias formula"></div>
<br>
</div>
<!-- <div class="divTableRow">
<div class="divTableCell">cell1_7</div>
<div class="divTableCell">cell2_7</div>
<div class="divTableCell">cell3_7</div>
</div> -->
</div>
</div>
<br>

    </div>
</div>
</div>


    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="/lib/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
		
	
	 <footer style="padding-left:39px">
			<!-- <a href="#">Imprint</a><br><br> -->
			<!-- <small>&copy; Copyright 2019  St.Pölten University of Applied Sciences</small> -->
		   </footer>
	</body>
	
	</html>