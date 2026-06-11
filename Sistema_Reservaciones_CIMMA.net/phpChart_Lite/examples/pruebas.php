<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
		<title>Medallero</title>
    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>


<?php
// Conexión a la base de datos
$servername = "fdb1031.runhosting.com";
$username = "4687073_basededatos";
$password = "tuzymR+8AN}DQ/o";
$database = "4687073_basededatos";
            
    $l1 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $l2 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $l3 = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $i=0;
    
// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM olimpiadas LIMIT 10";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $l1[$i]= $row["gold"];
        $l2[$i]= $row["silver"];
        $l3[$i]= $row["bronze"];
        $i++;
    }
} else {
    echo "0 results";
}



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $pc = new C_PhpChartX(array($l1,$l2,$l3),'chart1');
    $pc->jqplot_show_plugins(true);
    $pc->set_legend(array('show'=>true));
    $pc->set_animate(true);


    $pc->add_series(array('label'=>'Gold'));
    $pc->add_series(array('label'=>'Silver'));
    $pc->add_series(array('label'=>'Bronze'));
    $pc->add_series(array('showLabel'=>true));
  
    
    $pc->draw(600,300);   
    $conn->close();

    ?>

    </body>
</html>