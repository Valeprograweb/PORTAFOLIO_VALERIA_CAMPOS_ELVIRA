<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
		<title>Continentes</title>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>


<?php
  
  $l1=array(0,0,0,0);
  $l2=array(0,0,0,0);
  $l3=array(0,0,0,0);
  $l4=array(0,0,0,0);
  $l5=array(0,0,0,0);
  $i=0; 

$servername = "fdb1031.runhosting.com";
$username = "4687073_basededatos";
$password = "tuzymR+8AN}DQ/o";
$database = "4687073_basededatos";
    
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);
  // Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

  // sql to delete a record

  $sql = "SELECT continente,SUM(gold) AS orotot, SUM(silver) AS platatot, SUM(bronze) AS broncetot FROM olimpiadas GROUP BY continente;";
  $result = $conn->query($sql);

 if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombres[] = $row["continente"];
        $series[] = [
            (int)$row["orotot"],
            (int)$row["platatot"],
            (int)$row["broncetot"]
        ];
    }
}

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $pc = new C_PhpChartX($series, 'chart1');
    $pc->jqplot_show_plugins(true);
    $pc->set_legend(array('show' => true));
    $pc->set_animate(true);

    foreach ($nombres as $nombre) {
    $pc->add_series(array('label' => $nombre));
    }
    
    $pc->draw(600,300);   
    
    ?>

    </body>
</html>