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
		<title>About This Tool</title>
		<link href="/lib/css/bootstrap.min.css" rel="stylesheet">
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
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> 
<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
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
								<a class="nav-link active" href="./about.php">About this tool</a>
							</li>
							<div class="nav-link dropdown">
								<a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizations
									<span class="caret"></span>
								</a>
								<ul class="nav-link dropdown-menu" aria-labelledby="dropdownMenu1">
									<li>
										<a class="dropdown-item" href="./finalorder.php">Final Order Amount</a>
									</li>
									<li>
										<a class="dropdown-item"  href="./deliveryplans.php">Delivery Plans</a>
									</li>
									<li>
										<a class="dropdown-item" href="./forecasterror.php">Forecast Error</a>
									</li>
									<li>
										<a class="dropdown-item" href="./mad_graph.php">Mean Absolute Deviation (MAD)</a>
									</li>
									<li>
										<a class="dropdown-item" href="./mse_graph.php">Mean Square Error (MSE)</a>
									</li>
									<li>
										<a class="dropdown-item" href="./rmse_graph.php">Root Mean Square Error (RMSE)</a>
									</li>
									<li>
										<a class="dropdown-item " href="./mpe.php">Mean Percentage Error (MPE)</a>
									</li>
									<li>
										<a class="dropdown-item " href="./mape.php">Mean Absolute Percentage Error (MAPE)</a>
									</li>
									<li>
                                <a class="dropdown-item" href="./meanforecastbias.php">Mean Forecast Bias (MFB)</a>
                            </li>
                            <li class="dropdown-header">Matrices</li>
                            <li>
                                <a class="dropdown-item" href="./matrix.php">Delivery Plans Matrix</a>
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



<div class="row1" style="padding-left:39px">
<div class="col-sm-8"> 
<small>
<?php
echo "You are logged in as: ";
print_r($_SESSION["session_username"]);
echo ".";
?></small>
<br><br>
		<h5 class = "card-title"><strong>Background</strong></h5><br>
		<div class = "row1"> 
		<div class="col-sm-6">
		<p class = "class-text"> 
		<br>
		This tool was created as a part of the <strong>InnoFIT research project</strong>, which aims at developing innovative forecasting tools for improved production
		planning. The project is funded by the Austrian Research Promotion Agency 
		<a href="https://www.ffg.at/en/content/about-ffg" title="Austrian Research Promotion Agency">(FFG)</a> and runs from 1 June 2018 until 31 May 2021.
		<br></p>
	</div>
	<div class="col-sm-6">
			<picture><img src="/data/img/Logo_transparent.png" sizes="50vw"
				srcset="/data/img/Logo_transparent.png 100w, /data/img/Logo_transparent.png 900w,
				/data/img/Logo_transparent.png 7000w">
			</picture>
			</div>
</div>
</div>
</div>
	<div style="padding-left:39px">
			<br><br><h5><strong> Project Partners</strong> </h5><br>
				<small><ul>
				<li>University of Applied Sciences Upper Austria, Campus Steyr (Steyr) 
					<ul><li>Project leader: <a href="http://research.fh-ooe.at/en/staff/3584">Priv. Doz. FH-Prof. DI (FH) Klaus Altendorfer PhD</a></li></ul></li>
				<li>St. Pölten University of Applied Sciences (St. Pölten) 
						<ul><li>Project leader: <a href="https://www.fhstp.ac.at/en/about-us/staff-a-z/felberbauer-thomas">Dr. Thomas Felberbauer, MSc</a></li></ul></li>
                <li>RISC Software GmbH</li>
        		<li>NKE Austria GmbH</li>
        		<li>ZF Steyr</li>
		        <li>MWS Hightec GmbH</li>
		        <li>Lecapell GmbH</li>
    			</ul></small>
	</div><br><br>
	<div style="padding-left:39px">
			<br><br><h5><i>Download a poster of the InnoFIT project:</i> </h5>
For Office 365:	<a href="https://fhstp.sharepoint.com/sites/InnoFIT/Freigegebene%20Dokumente/General/Posters/InnoFIT_one%20version.pdf" target="_blank">Download link 1</a><br>
For other: <a href="https://www.dropbox.com/s/c2a2ew6o48wdubs/InnoFIT_one%20version.pdf?dl=0" target="blank"> Download link 2 </a>
			</div>
			<br><br>
<div style="padding-left:39px">
	<h5><strong>Project Team Photo</strong></h5><br>
	<img src="/data/img/Projektteam.jpg" style="max-width:100%;height:auto;">
	<br>
	<small>Image source: UAS Upper Austria / Andreas Schober</small>
	</div>
<!-- 	<div style="padding-left:39px">
		<br>
		<br>
		<h5><strong>Contact us:</strong></h5>
		<br>
		<p>For questions regarding the project and general information (St. Pölten UAS):
			<br> <b>Dr. Thomas Felberbauer, MSc</b>
			<br> Lecturer Industry 4.0
			<br>Deputy Academic Director Smart Engineering (BA)
			<br>Department of Media and Digital Technologies
			<br>St.Pölten University of Applied Sciences
			<br>M: <a href="tel:43676847228693">+43/676/847 228 693</a>
			<br>E: <a href="mailto:thomas.felberbauer@fhstp.ac.at">thomas.felberbauer@fhstp.ac.at</a>
			<br>I: <a href="https://www.fhstp.ac.at" title="St.Pölten University of Applied Sciences Home Page"> https://www.fhstp.ac.at</a></p>
	
	</div> -->
	

	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
	 crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
	 crossorigin="anonymous"></script>
<!-- 	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
	 crossorigin="anonymous"></script>
 -->	
	 <footer style="padding-left:39px">
			<a href="#">Imprint</a><br><br>
			<small>&copy; Copyright 2018 St.Pölten University of Applied Sciences</small>
		   </footer>
	</body>
	
	</html>