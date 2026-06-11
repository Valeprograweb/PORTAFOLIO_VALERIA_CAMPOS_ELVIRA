<?php

require_once("../conf.php");

$random_numbers = array();
for ($i = 0; $i < 5; $i++) {
  $random_numbers[] = rand(1, 20);

}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Numeros aleatorios</title>
</head>
<body>
   
<?php
$pc = new C_PhpChartX(array($random_numbers),'basic_chart');
$pc->set_animate(true);
$pc->set_title(array('text'=>'Basic Chart Animated'));
$pc->draw();
?>

</body>

</html>