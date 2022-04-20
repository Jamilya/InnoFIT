# reposit
Source code for the InnoFIT visualization (web) tool.

The tool was created as part of the InnoFIT research project funded by the Austrian Research Promotion Agency (FFG): 
https://research.fhstp.ac.at/projekte/innofit-informationstechnologie-in-forecastwerkzeugen
https://projekte.ffg.at/projekt/3042801

The duration of the project was 01.06.2018-28.02.2022.

The tool was designed to visualize customer order forecast quality with time series data via a MySQL database. Clustering feature was added to conduct a multiple-product analysis with web-based python libraries of scikit learn and tslearn (pyodide.js).

The visualization tool was designed mostly with Javascript (d3.js, crossfilter.js libraries), PHP and python (for clustering).

The main content of the InnoFIT visualization tool includes: 
- Basic order analysis
- Forecast error measures
- Dashboard
- Clustering
- Correction visualization (RMSE and corrected RMSE)
