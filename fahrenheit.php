<?php
/* Include the `../src/fusioncharts.php` file that contains functions to embed the charts.*/
include("wrappers 2/php-wrapper/fusioncharts.php");
/* The following 4 code lines contains the database connection information. Alternatively, you can move these code lines to a separate file and include the file here. You can also modify this code based on your database connection.   */
$hostdb = "localhost";  // MySQl host
$userdb = "root";  // MySQL username
$passdb = "";  // MySQL password
$namedb = "project";  // MySQL database name
// Establish a connection to the database
$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);
/*Render an error message, to avoid abrupt failure, if the database connection parameters are incorrect */
if ($dbhandle->connect_error) {
  exit("There was an error with your connection: ".$dbhandle->connect_error);
}
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="refresh" content="300">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link href="web.css" rel="stylesheet">
  <script src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
  <script src="http://static.fusioncharts.com/code/latest/fusioncharts.charts.js"></script>
  <script src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.ocean.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Smart home</title>
</head>
  <body  id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="celsius.php">Celsius</a></li>
            <li><a href="fahrenheit.php">Fahrenheit</a></li>
            <li><a href="humidity.php">Humidity</a></li>
            <li><a href="light.php">Light</a></li>
            
          </ul>
    </div>
  </div>
  </nav>
   <div class="container">



       <?php
       $sql = "SELECT * FROM(SELECT * FROM fahrenheit ORDER BY datetime DESC LIMIT 1) AS c ORDER BY datetime ASC; ";
       $data = $dbhandle->query($sql);
       if($data->num_rows>0){
         while($row = $data->fetch_assoc()) {
           echo "<h3>"."Current TEMP: ".$row["fahrenheit"]."°F"."</h3>"."<br>";
       }
     }


 $strQuery = "SELECT * FROM(SELECT * FROM fahrenheit ORDER BY datetime DESC LIMIT 24) AS c ORDER BY datetime ASC; ";
 $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
 if ($result) {

 $arrData = array(
       "chart" => array(
           "caption"=> "TEMP",

           "xAxisname"=> "time",
           "yAxisName"=> "Fahrenheit(°F)",
           "numberSuffix" => "°F",
           "theme"=> "ocean"
           )
         );
         // creating array for categories object
         $categoryArray=array();
         $dataseries1=array();

         // pushing category array values
         while($row = mysqli_fetch_array($result)) {
           array_push($categoryArray, array(
           "label" => $row["datetime"]
         )
       );
       array_push($dataseries1, array(
         "value" => $row["fahrenheit"]
         )
     );
     }
     $arrData["categories"]=array(array("category"=>$categoryArray));
     // creating dataset object
     $arrData["dataset"] = array(array("seriesName"=> "datetime", "data"=>$dataseries1, "renderas"=>"line","showvalues"=>"0"));
     /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */
     $jsonEncodedData = json_encode($arrData);
     // chart object
     $msChart = new FusionCharts("mscombi2d", "chart1" , "960", "600", "chart-container", "json", $jsonEncodedData);
     // Render the chart
     $msChart->render();
     // closing db connection
     $dbhandle->close();
  }
?>
    <div id="chart-container">Chart will render here!</div>


  </div><br>
  <div class="footer" id="footer"><hr>
             <h4>Smart home project</h4>
           </div>
           <!-- Bootstrap core JavaScript
   ================================================== -->
   <!-- Placed at the end of the document so the pages load faster -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>



   </script>
 </body>
</html>
